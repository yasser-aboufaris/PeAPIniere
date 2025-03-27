<?php

namespace App\Http\Controllers;
use App\Repositories\Interface\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(): JsonResponse
    {
        try {
            $categories = $this->categoryRepository->getAll();
            return response()->json($categories, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch categories'], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    public function store(Request $request): JsonResponse
    {
        // dd($request);
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string'
            ]);
            // dd($data);

            $category = $this->categoryRepository->create($data);
            return response()->json($category, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create category'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $category = $this->categoryRepository->getById($id);
            if (!$category) {
                return response()->json(['error' => 'Category not found'], Response::HTTP_NOT_FOUND);
            }
            return response()->json($category, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch category'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->categoryRepository->delete($id);
            if (!$deleted) {
                return response()->json(['error' => 'Category not found'], Response::HTTP_NOT_FOUND);
            }
            return response()->json(['message' => 'Category deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete category'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
