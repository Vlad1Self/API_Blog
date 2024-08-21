<?php

namespace App\Contracts;

use App\DTO\TagDTO\IndexTagDTO;
use App\DTO\TagDTO\StoreTagDTO;
use App\DTO\TagDTO\UpdateTagDTO;

interface  TagContract
{
    public function indexTag(IndexTagDTO $data);
    public function storeTag(StoreTagDTO $data);
    public function updateTag(UpdateTagDTO $data);
    public function deleteTag(int $id);
}
