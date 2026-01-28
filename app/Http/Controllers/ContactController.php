<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Repositories\All\Contact\ContactInterface;

class ContactController extends Controller
{
    private ContactInterface $contactRepository;
    public function __construct(ContactInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->contactRepository->all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactRequest $request)
    {
        $contact = $this->contactRepository->create($request->validated());
        return response()->json($contact, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact = $this->contactRepository->find($id);

        if (! $contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        return response()->json($contact);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactRequest $request, string $id)
    {
        $updated = $this->contactRepository->update($id, $request->validated());

        if (! $updated) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        return response()->json(['message' => 'Contact updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleted = $this->contactRepository->delete($id);

        if (! $deleted) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        return response()->json(['message' => 'Contact deleted successfully']);
    }
}
