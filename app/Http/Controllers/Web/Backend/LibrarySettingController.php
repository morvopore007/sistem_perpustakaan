<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\LibrarySetting;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class LibrarySettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $settings = LibrarySetting::all()->keyBy('key');
        return view('backend.layouts.settings.library_settings', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'max_borrow_days_student' => 'required|integer|min:1|max:365',
            'max_borrow_days_teacher' => 'required|integer|min:1|max:365',
            'max_books_per_student' => 'required|integer|min:1|max:20',
            'max_books_per_teacher' => 'required|integer|min:1|max:20',
            'reservation_expiry_days' => 'required|integer|min:1|max:30',
            'library_name' => 'required|string|max:255',
            'library_address' => 'required|string|max:500',
            'library_phone' => 'required|string|max:50',
            'library_email' => 'required|email|max:255',
        ]);

        try {
            foreach ($request->all() as $key => $value) {
                if ($key !== '_token' && $key !== '_method') {
                    LibrarySetting::updateOrCreate(
                        ['key' => $key],
                        ['value' => $value]
                    );
                }
            }

            return redirect()->route('library-settings.index')
                ->with('success', 'Library settings updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update library settings: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
