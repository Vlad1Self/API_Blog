<?php

namespace App\DTO\PostDTO;

use Spatie\DataTransferObject\DataTransferObject;

class UpdatePostDTO extends DataTransferObject
{
    public int $id;
    public string $title;
    public string $content;
    public int $category_id;
    public $tags;
}
