<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAllWithCreator();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $category = $this->categoryService->createByUser($request->validated());

        return response()->json([
            'message' => 'Categoria criada com sucesso',
            'data' => $category
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $category): JsonResponse
    {
        $category = $this->categoryService->findOrFailWithCreator($category);
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, int $category): JsonResponse
    {
        $category = $this->categoryService->updateWithCreator($category, $request->validated());
        
        if (!$category) {
            return response()->json(['message' => 'Categoria não encontrada'], 404);
        }

        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $category): JsonResponse
    {
        $deleted = $this->categoryService->delete($category);
        
        if (!$deleted) {
            return response()->json(['message' => 'Categoria não encontrada'], 404);
        }

        return response()->json(null, 204);
    }
} 