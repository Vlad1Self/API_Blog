<?php

namespace App\Contracts;

use App\DTO\PostDTO\IndexPostDTO;
use App\DTO\PostDTO\StorePostDTO;
use App\DTO\PostDTO\UpdatePostDTO;

interface  PostContract
{
    public function indexPost(IndexPostDTO $data);
    public function storePost(StorePostDTO $data);
    public function updatePost(UpdatePostDTO $data);
    public function deletePost(int $id);
}
