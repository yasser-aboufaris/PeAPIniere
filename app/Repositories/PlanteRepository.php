<?php

namespace App\Repositories;

use App\Models\Plante;
use App\Repositories\Interface\PlanteRepositoryInterface;

class PlanteRepository implements PlanteRepositoryInterface {
    public function create(array $data) {
        return Plante::create($data);
    }
    
    public function getAll() {
        return Plante::all();
    }

    public function getById($id) {
        return Plante::findOrFail($id);
    }

    public function update($id, array $data) {
        $plante = Plante::findOrFail($id);
        $plante->update($data);
        return $plante;
    }

    public function delete($id) {
        return Plante::destroy($id);
    }
}
