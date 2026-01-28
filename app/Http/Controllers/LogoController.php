<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogoRequest;
use App\Repositories\All\Logo\LogoInterface;
use Illuminate\Http\JsonResponse;

class LogoController extends Controller
{
    private LogoInterface $logoRepository;

    public function __construct(LogoInterface $logoRepository)
    {
        $this->logoRepository = $logoRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json($this->logoRepository->all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LogoRequest $request): JsonResponse
    {
        $logo = $this->logoRepository->create($request->validated());
        return response()->json($logo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $logo = $this->logoRepository->find($id);
        if (! $logo) {
            return response()->json(['message' => 'Logo not found'], 404);
        }
        return response()->json($logo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LogoRequest $request, string $id): JsonResponse
    {
        $updated = $this->logoRepository->update($id, $request->validated());
        if (! $updated) {
            return response()->json(['message' => 'Logo not found'], 404);
        }
        return response()->json(['message' => 'Logo updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $deleted = $this->logoRepository->delete($id);
        if (! $deleted) {
            return response()->json(['message' => 'Logo not found'], 404);
        }
        return response()->json(['message' => 'Logo deleted successfully']);
    }
}
