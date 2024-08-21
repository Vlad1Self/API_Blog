<?php

namespace App\DTO\TagDTO;

use Spatie\DataTransferObject\DataTransferObject;

class UpdateTagDTO extends DataTransferObject
{
    public int $id;
    public string $name;
}
