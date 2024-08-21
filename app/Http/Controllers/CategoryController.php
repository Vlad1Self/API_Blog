<?php

namespace App\Http\Controllers;

use App\Contracts\CategoryContract;
use App\DTO\CategoryDTO\IndexCategoryDTO;
use App\DTO\CategoryDTO\StoreCategoryDTO;
use App\DTO\CategoryDTO\UpdateCategoryDTO;
use App\Exceptions\CategoryException\DeleteCategoryException;
use App\Exceptions\CategoryException\FindCategoryException;
use App\Exceptions\CategoryException\IndexCategoryException;
use App\Exceptions\CategoryException\StoreCategoryException;
use App\Exceptions\CategoryException\UpdateCategoryException;
use App\Http\Requests\CategoryRequest\IndexCategoryRequest;
use App\Http\Requests\CategoryRequest\StoreCategoryRequest;
use App\Http\Requests\CategoryRequest\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{

    private CategoryContract $service;

    public function __construct(CategoryContract $service)
    {
        $this->service = $service;
    }

    public function indexCategory(IndexCategoryRequest $request): JsonResponse|AnonymousResourceCollection
    {
        $data = new IndexCategoryDTO($request->validated());

        try {
            $categories = $this->service->indexCategory($data);
        } catch (IndexCategoryException $e){
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return CategoryResource::collection($categories);
    }

    public function storeCategory(StoreCategoryRequest $request): JsonResponse
    {
        $data = new StoreCategoryDTO($request->validated());

        try {
            $this->service->storeCategory($data);
        } catch (StoreCategoryException $e){
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return response()->json(['message' => 'Успешно создано'], 201);
    }


    public function updateCategory(UpdateCategoryRequest $request): JsonResponse
    {
        $data = new UpdateCategoryDTO($request->validated());

        try {
            $this->service->updateCategory($data);
        } catch (UpdateCategoryException|FindCategoryException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        return response()->json(['message' => 'Успешно обновлено'], 200);
    }

    public function deleteCategory(int $id): JsonResponse
    {
        try {
            $this->service->deleteCategory($id);
        } catch (DeleteCategoryException|FindCategoryException $e){
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }
        return response()->json(['message' => 'Успешно удалено'], 200);
    }

}
