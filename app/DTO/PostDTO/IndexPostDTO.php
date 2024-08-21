<?php

namespace App\DTO\PostDTO;

use Spatie\DataTransferObject\DataTransferObject;

class IndexPostDTO extends DataTransferObject
{
    public string $title;
    public string $content;
}
