<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Repositories\All\Feedback\FeedbackInterface;

class FeedbackController extends Controller
{
    private FeedbackInterface $feedbackRepository;

    public function __construct(FeedbackInterface $feedbackRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->feedbackRepository->all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FeedbackRequest $request)
    {
        $feedback = $this->feedbackRepository->create($request->validated());
        return response()->json($feedback, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $feedback = $this->feedbackRepository->find($id);

        if (! $feedback) {
            return response()->json(['message' => 'Feedback not found'], 404);
        }

        return response()->json($feedback);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FeedbackRequest $request, string $id)
    {
        $updated = $this->feedbackRepository->update($id, $request->validated());

        if (! $updated) {
            return response()->json(['message' => 'Feedback not found'], 404);
        }

        return response()->json(['message' => 'Feedback updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleted = $this->feedbackRepository->delete($id);

        if (! $deleted) {
            return response()->json(['message' => 'Feedback not found'], 404);
        }

        return response()->json(['message' => 'Feedback deleted successfully']);
    }
}
