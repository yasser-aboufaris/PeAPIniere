<?php

namespace App\Http\Controllers;

use App\Repositories\PlanteRepositoryInterface;
use Illuminate\Http\Request;

class PlanteController extends Controller
{
    protected $planteRepository;

    public function __construct(PlanteRepositoryInterface $planteRepository)
    {
        $this->planteRepository = $planteRepository;
    }

    public function index()
    {
        return response()->json($this->planteRepository->getAll());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'species' => 'required|string',
            'age' => 'required|integer',
        ]);
        
        return response()->json($this->planteRepository->create($data), 201);
    }

    public function show($id)
    {
        return response()->json($this->planteRepository->getById($id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|string',
            'species' => 'sometimes|string',
            'age' => 'sometimes|integer',
        ]);
        
        return response()->json($this->planteRepository->update($id, $data));
    }

    public function destroy($id)
    {
        $this->planteRepository->delete($id);
        return response()->json(['message' => 'Plante deleted successfully']);
    }

}
