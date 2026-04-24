<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        return view('pages.contact', compact('contacts'));
    }

    // Show form to add new staff
    public function create()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('pages.contact-create');
    }

    // Save new staff to database
    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'staff_type' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        Contact::create($validated);

        return redirect()->route('contact.index')->with('success', 'New staff added!');
    }

    public function edit(Contact $contact)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }
        
        // FIX: Added quotes around 'contact'
        return view('pages.contact-edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'staff_type' => 'required|string|max:255', // Added this
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        $contact->update($validated);
        
        return redirect()->route('contact.index')->with('success', 'Staff updated successfully.');
    }
    // Delete staff
    public function destroy(Contact $contact)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $contact->delete();
        return redirect()->route('contact.index')->with('success', 'Staff removed.');
    }
}