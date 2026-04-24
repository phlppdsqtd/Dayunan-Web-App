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

    public function edit(Contact $contact)
    {
        // Block anyone who isn't an admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Only administrators can edit staff details.');
        }

        return view('pages.contact-edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        // Double check authority before saving
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'role'           => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email'          => 'required|email|max:255',
        ]);

        $contact->update($validated);

        return redirect()->route('contact.index')->with('success', 'Staff details updated.');
    }
}