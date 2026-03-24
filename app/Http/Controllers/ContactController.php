<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        // Fetch ALL contacts (James and Jan) instead of just one
        $contacts = Contact::all();

        // Pass the variable as 'contacts' to match your Blade @foreach loop
        return view('pages.contact', compact('contacts'));
    }
}