<?php

namespace App\Services;

use App\Repositories\CategoryRepositoryInterface;

class CategoryService {
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    public function createCategory(array $data) {
        return $this->categoryRepository->create($data);
    }

    public function getAllCategories() {
        return $this->categoryRepository->getAll();
    }

    public function deleteCategory($id) {
        return $this->categoryRepository->delete($id);
    }
}
