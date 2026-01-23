<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Repositories\All\Project\ProjectInterface;

class ProjectController extends Controller
{
    private ProjectInterface $projectRepository;

    public function __construct(ProjectInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->projectRepository->all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        $project = $this->projectRepository->create($request->validated());
        return response()->json($project, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = $this->projectRepository->find($id);
        if (! $project) {
            return response()->json(['message' => 'Project not found'], 404);
        }
        return response()->json($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, string $id)
    {
        $updated = $this->projectRepository->update($id, $request->validated());
        if (! $updated) {
            return response()->json(['message' => 'Project not found'], 404);
        }
        return response()->json(['message' => 'Project updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleted = $this->projectRepository->delete($id);
        if (! $deleted) {
            return response()->json(['message' => 'Project not found'], 404);
        }
        return response()->json(['message' => 'Project deleted successfully']);
    }
}
