<?php

namespace App\Http\Controllers;

use App\Repositories\Interface\PlanteRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PlanteController extends Controller
{
    protected $planteRepository;

    public function __construct(PlanteRepositoryInterface $planteRepository)
    {
        $this->planteRepository = $planteRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $plantes = $this->planteRepository->getAll();
            return response()->json($plantes, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch plants'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|integer|min:0',
                'description' => 'required|string',
                'image' => 'required|string',
                'categorie_id' => 'required|integer|exists:categories,id',
                'slug' => 'required|string|unique:plantes,slug'
            ]);

            $plante = $this->planteRepository->create($data);
            return response()->json($plante, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create plant','error' => $e], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $plante = $this->planteRepository->getById($id);
            if (!$plante) {
                return response()->json(['error' => 'Plant not found'], Response::HTTP_NOT_FOUND);
            }
            return response()->json($plante, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch plant'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $data = $request->validate([
                'name' => 'sometimes|string|max:255',
                'price' => 'sometimes|integer|min:0',
                'description' => 'sometimes|string',
                'image' => 'sometimes|string',
                'categorie_id' => 'sometimes|integer|exists:categories,id',
                'slug' => 'sometimes|string|unique:plantes,slug,' . $id
            ]);

            $plante = $this->planteRepository->update($id, $data);
            if (!$plante) {
                return response()->json(['error' => 'Plant not found'], Response::HTTP_NOT_FOUND);
            }
            return response()->json($plante, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update plant'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->planteRepository->delete($id);
            if (!$deleted) {
                return response()->json(['error' => 'Plant not found'], Response::HTTP_NOT_FOUND);
            }
            return response()->json(['message' => 'Plant deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete plant'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
