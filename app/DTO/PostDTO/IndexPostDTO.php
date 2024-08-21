<?php

namespace App\DTO\PostDTO;

use Spatie\DataTransferObject\DataTransferObject;

class IndexPostDTO extends DataTransferObject
{
    public  int $per_page;
    public  int $page;
}
