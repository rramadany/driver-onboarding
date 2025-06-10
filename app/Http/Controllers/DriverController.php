<?php

namespace App\Http\Controllers;


use App\Models\Driver; // to be added
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DriverController extends Controller
{

    // --- Level 1: Everyone's Actions ---

    public function index(): View
    {
        // Logic to fetch and display all drivers will go here.
        // For now, return a placeholder view.
        return view('drivers.index', ['drivers' => []]);
    }

    public function show(Driver $driver): View
    {
        // Logic to show a single driver's details.
        return view('drivers.show', ['driver' => $driver]);
    }

    // --- LEVEL 2: HR, Supervisor, Admin Actions ---

    public function create(): View
    {
        return view('drivers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        // Validation and creation logic will be added.
        return redirect()->route('drivers.index');
    }

    public function edit(Driver $driver): View
    {
        return view('drivers.edit', ['driver' => $driver]);
    }

    public function update(Request $request, Driver $driver): RedirectResponse
    {
        // Validation and update logic will be added.
        return redirect()->route('drivers.show', $driver);
    }

    public function destroy(Driver $driver): RedirectResponse
    {
        // Deletion logic will be added.
        return redirect()->route('drivers.index');
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
