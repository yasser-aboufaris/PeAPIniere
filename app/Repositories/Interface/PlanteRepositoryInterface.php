<?php
namespace App\Repositories\Interface;
interface PlanteRepositoryInterface {
    public function create(array $data);
    public function getAll();
    public function getById($id);
    public function update($id, array $data);
    public function delete($id);
}