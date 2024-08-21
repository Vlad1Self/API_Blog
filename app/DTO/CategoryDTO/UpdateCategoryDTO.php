<?php

namespace App\DTO\CategoryDTO;

use Spatie\DataTransferObject\DataTransferObject;
class UpdateCategoryDTO extends DataTransferObject
{
    public int $id;
    public string $name;
}
