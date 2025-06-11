<?php

namespace App\Http\Controllers;


use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use Illuminate\Http\RedirectResponse;

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
        return view('drivers.show', ['driver' => $driver]);

    }

    // --- LEVEL 2: HR, Supervisor, Admin Actions ---

    public function create(): View
    {
        return view('drivers.create');
    }

    public function store(StoreDriverRequest $request): RedirectResponse
    {
        $driver = new Driver();
        $driver->fill($request->validated());
        $driver->created_by = Auth::id();
        $driver->save();

        return redirect()->route('drivers.show', $driver)->with('success', 'Driver profile created successfully.');

    }

    public function edit(Driver $driver): View
    {
        if (! $driver->isEditable()) {
            abort(400, 'This driver profile cannot be edited at its current state.');
        }
        
        return view('drivers.edit', ['driver' => $driver]);

    }

    public function update(UpdateDriverRequest $request, Driver $driver): RedirectResponse
    {
        if (! $driver->isEditable()) {
            abort(400, 'This driver profile cannot be edited at its current state.');
        }
        $driver->update($request->validated());

        return redirect()->route('drivers.show', $driver)->with('success', 'Driver profile updated successfully.');

    }

    public function destroy(Driver $driver): RedirectResponse
    {
        $driver->delete();

        return redirect()->route('drivers.index')->with('success', 'Driver profile deleted successfully.');

    }

    public function submit(Driver $driver): RedirectResponse
    {
        // Logic to change status from 'draft' to 'pending_approval'.
        return redirect()->route('drivers.show', $driver);
    }

    // --- Level 3: Supervisor and Admin actions ---

    public function approve(Driver $driver): RedirectResponse
    {
        // Logic to change status to 'approved'.
        return redirect()->route('drivers.show', $driver);
    }

    public function reject(Request $request, Driver $driver): RedirectResponse
    {
        // Logic to change status to 'rejected' and save a reason.
        return redirect()->route('drivers.show', $driver);
    }

}
