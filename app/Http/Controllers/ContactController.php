<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Services\ContactService;

class ContactController extends Controller
{
    public function __construct(ContactService $contactService) {
        $this->contactService = $contactService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->contactService->getAllContacts());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'archived' => 'boolean',
            'phones' => 'array',
            'phones.*.number' => 'required|string|max:20',
            'phones.*.inactive' => 'boolean',
        ]);

        $contact = $this->contactService->createContact($validatedData);

        return response()->json(['id' => $contact->id, 'message' => 'Contact created'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        return response()->json($contact->load('phones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $validatedData = $request->validate([
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'archived' => 'boolean',
            'phones' => 'array',
            'phones.*.number' => 'required|string|max:20',
            'phones.*.inactive' => 'boolean',
        ]);

        $updatedContact = $this->contactService->updateContact($contact, $validatedData);

        return response()->json(['message' => 'Contact updated', 'contact' => $updatedContact]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $this->contactService->deleteContact($contact);
        return response()->json(['message' => 'Contact deleted']);
    }
}
