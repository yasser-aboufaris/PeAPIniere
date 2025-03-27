<?php 
namespace App\Repositories\Interface;
interface CategoryRepositoryInterface{
    public function Create(array $data);
    public function getAll();
    public function delete($id);
}