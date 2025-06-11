<?php

namespace App\Http\Controllers;


use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Http\Requests\RejectDriverRequest;
use App\Http\Requests\SubmitDriverRequest;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DriverController extends Controller
{

    // --- Level 1: Everyone's Actions ---

    public function index(): View
    {
        $drivers = Driver::with('createdBy')->latest()->paginate(15);

        return view('drivers.index', ['drivers' => $drivers]);
    }

    public function show(Driver $driver): View
    {
        $driver->load('createdBy', 'reviewedBy');
        return view('drivers.show', ['driver' => $driver, 'documentMap' => Driver::FILE_INPUT_MAP]);

    }

    // --- LEVEL 2: HR, Supervisor, Admin Actions ---

    public function create(): View
    {
        return view('drivers.create', ['documentMap' => Driver::FILE_INPUT_MAP]);
    }

    public function store(StoreDriverRequest $request): RedirectResponse
    {
        $driver = new Driver();
        $driver->fill($request->validated());
        $driver->created_by = Auth::id();

        $this->handleFileUploads($request, $driver);

        $driver->save();

        return redirect()->route('drivers.show', $driver)->with('success', 'Driver profile created successfully.');

    }

    public function edit(Driver $driver): View
    {
        if (! $driver->isEditable()) {
            abort(400, 'This driver profile cannot be edited at its current state.');
        }
        
        return view('drivers.edit', ['driver' => $driver, 'documentMap' => Driver::FILE_INPUT_MAP]);

    }

    public function update(UpdateDriverRequest $request, Driver $driver): RedirectResponse
    {
        if (! $driver->isEditable()) {
            abort(400, 'This driver profile cannot be edited at its current state.');
        }

        $driver->fill($request->validated());

        $this->handleFileUploads($request, $driver);

        $driver->save();

        return redirect()->route('drivers.show', $driver)->with('success', 'Driver profile updated successfully.');
    }

    public function destroy(Driver $driver): RedirectResponse
    {
        // We intentionally don't delete the images for the sake of auditability
        // This fits nicely with the soft deletion
        $driver->delete();

        return redirect()->route('drivers.index')->with('success', 'Driver profile deleted successfully.');

    }

    public function showDocument(Driver $driver, string $type): StreamedResponse
    {
        if (!array_key_exists($type, Driver::FILE_INPUT_MAP)) {
            abort(404, 'Invalid document type.');
        }

        $details = Driver::FILE_INPUT_MAP[$type];
        $path = $driver->{$details['column']};
        $disk = Storage::disk('private');

        if (is_null($path) || !$disk->exists($path)) {
            abort(404, 'File not found.');
        }

        return $disk->response($path);
    }

    private function handleFileUploads(Request $request, Driver $driver): void
    {
        $disk = Storage::disk('private');
        foreach (Driver::FILE_INPUT_MAP as $inputName => $details) {
            if ($request->hasFile($inputName)) {
                $columnName = $details['column'];
                $oldPath = $driver->{$columnName};

                // We never delete anything ;)
                if ($oldPath && $disk->exists($oldPath)) {
                    $originalFilename = basename($oldPath);
                    $archivePath = "{$driver->id}/old/" . time() . "_{$originalFilename}";
                    $disk->move($oldPath, $archivePath);
                }

                $folder = $driver->id . '/documents';
                $path = $request->file($inputName)->store($folder, 'private');
                $driver->{$columnName} = $path;
            }
        }
    }

    public function submit(SubmitDriverRequest $request, Driver $driver): RedirectResponse
    {
        if (! $driver->isSubmittable()) {
            return back()->withErrors(['error' => 'This profile cannot be submitted for approval.']);
        }

        $driver->status = 'pending_approval';
        $driver->submitted_at = now();
        $driver->rejection_reason = null;
        $driver->reviewed_by = null;
        $driver->reviewed_at = null;
        $driver->save();

        return redirect()->route('drivers.show', $driver)->with('success', 'Driver submitted for approval.');
    }

    // --- Level 3: Supervisor and Admin actions ---

    public function approve(Driver $driver): RedirectResponse
    {
        if (! $driver->isReviewable()) {
            return back()->withErrors(['error' => 'This profile is not pending approval.']);
        }

        $driver->status = 'approved';
        $driver->reviewed_by = Auth::id();
        $driver->reviewed_at = now();
        $driver->save();

        return redirect()->route('drivers.show', $driver)->with('success', 'Driver approved successfully.');

    }

    public function reject(RejectDriverRequest $request, Driver $driver): RedirectResponse
    {
        if (! $driver->isReviewable()) {
            return back()->withErrors(['error' => 'This profile is not pending approval.']);
        }

        $driver->status = 'rejected';
        $driver->rejection_reason = $request->validated()['rejection_reason'];
        $driver->reviewed_by = Auth::id();
        $driver->reviewed_at = now();
        $driver->save();

        return redirect()->route('drivers.show', $driver)->with('success', 'Driver rejected successfully.');
    }

}
