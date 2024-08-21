<?php

namespace App\DTO\PostDTO;

use Spatie\DataTransferObject\DataTransferObject;

class StorePostDTO extends DataTransferObject
{
    public string $title;
    public string $content;
    public int $category_id;
    public array $tag_id;
}
