<?php

namespace App\Services;

use App\Repositories\PlanteRepositoryInterface;

class PlanteService {
    protected $planteRepository;

    public function __construct(PlanteRepositoryInterface $planteRepository) {
        $this->planteRepository = $planteRepository;
    }

    public function createPlante(array $data) {
        return $this->planteRepository->create($data);
    }

    public function getAllPlantes() {
        return $this->planteRepository->getAll();
    }

    public function getPlanteById($id) {
        return $this->planteRepository->getById($id);
    }

    public function updatePlante($id, array $data) {
        return $this->planteRepository->update($id, $data);
    }

    public function deletePlante($id) {
        return $this->planteRepository->delete($id);
    }
}
