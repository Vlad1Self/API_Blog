<?php

namespace App\Services;

use App\Contracts\CategoryContract;
use App\DTO\CategoryDTO\IndexCategoryDTO;
use App\DTO\CategoryDTO\StoreCategoryDTO;
use App\DTO\CategoryDTO\UpdateCategoryDTO;
use App\Exceptions\CategoryException\DeleteCategoryException;
use App\Exceptions\CategoryException\FindCategoryException;
use App\Exceptions\CategoryException\IndexCategoryException;
use App\Exceptions\CategoryException\StoreCategoryException;
use App\Exceptions\CategoryException\UpdateCategoryException;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryService implements CategoryContract
{
    public function indexCategory(IndexCategoryDTO $data)
    {
        try {
            return Category::all();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new IndexCategoryException('Что-то пошло не так...', 500);
        }
    }
    public function storeCategory(StoreCategoryDTO $data): bool
    {
       try {
           /** @var Category $category */
           $category = new Category();
           $category->name = $data->name;
           $category->save();
       } catch (\Exception $e){
           Log::error($e->getMessage());
           throw new StoreCategoryException('Что-то пошло не так...', 500);
       }
        return true;
    }

    public function updateCategory(UpdateCategoryDTO $data): bool
    {
        try {
            /** @var Category $category */
            $category = Category::findOrFail($data->id);
        } catch (\Exception $e){
            Log::error($e->getMessage());
            throw new FindCategoryException('Категория не найдена', 404);
        }

        try {
            $category->name = $data->name;
            $category->save();
        } catch (\Exception $e){
            Log::error($e->getMessage());
            throw new UpdateCategoryException('Что-то пошло не так...', 500);
        }
        return true;
    }

    public function deleteCategory(int $id): bool
    {
        try {
            /** @var Category $category */
            $category = Category::findOrFail($id);
        } catch (\Exception $e){
            Log::error($e->getMessage());
            throw new FindCategoryException('Категория не найдена', 404);
        }

        try {
            $category->delete();
        } catch (\Exception $e){
            Log::error($e->getMessage());
            throw new DeleteCategoryException('Что-то пошло не так...', 500);
        }
        return true;
    }

}
