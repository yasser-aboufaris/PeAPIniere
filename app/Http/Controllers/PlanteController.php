<?php

namespace App\Http\Controllers;

use App\Repositories\Interface\PlanteRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

use Symfony\Component\HttpFoundation\Response;

class PlanteController extends Controller
{
    protected $planteRepository;

    public function __construct(PlanteRepositoryInterface $planteRepository)
    {
        $this->planteRepository = $planteRepository;
    }

    public function index()
    {
        try {
            $plantes = $this->planteRepository->getAll();
            return response()->json($plantes, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch plants'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function store(Request $request)
    {
        try {
            // Validate the incoming data
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|integer|min:0',
                'description' => 'required|string',
                'image' => 'required|string',
                'categorie_id' => 'required|integer|exists:categories,id',
            ]);
    
            $data['slug'] = Str::slug($data['name']);
    
            $plante = $this->planteRepository->create($data);
    
            // Return the response
            return response()->json($plante, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // Handle the error and return the response
            return response()->json(['error' => 'Failed to create plant', 'details' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
    
    

    public function show(int $id)
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

    public function update(Request $request, int $id)
{
    try {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|integer|min:0',
            'description' => 'sometimes|string',
            'image' => 'sometimes|string',
            'categorie_id' => 'sometimes|integer|exists:categories,id',
        ]);

        $plante = $this->planteRepository->update($id, $data);
        if (!$plante) {
            return response()->json(['error' => 'Plant not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($plante, Response::HTTP_OK);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to update plant', 'details' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
    }
}

    public function destroy(int $id)
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

    public function showBySlug($slug)
{
    try {
        $plante = $this->planteRepository->findBySlug($slug);

        if (!$plante) {
            return response()->json(['error' => 'Plant not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($plante, Response::HTTP_OK);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to retrieve plant', 'details' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
    }
}


}
