<?php

namespace App\Contracts;

use App\DTO\CategoryDTO\IndexCategoryDTO;
use App\DTO\CategoryDTO\StoreCategoryDTO;
use App\DTO\CategoryDTO\UpdateCategoryDTO;

interface  CategoryContract
{
    public function indexCategory(IndexCategoryDTO $data);
    public function storeCategory(StoreCategoryDTO $data);
    public function updateCategory(UpdateCategoryDTO $data);
    public function deleteCategory(int $id);
}
