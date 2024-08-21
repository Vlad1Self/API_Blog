<?php

namespace App\Services;

use App\Contracts\TagContract;
use App\DTO\TagDTO\IndexTagDTO;
use App\DTO\TagDTO\StoreTagDTO;
use App\DTO\TagDTO\UpdateTagDTO;
use App\Exceptions\TagException\DeleteTagException;
use App\Exceptions\TagException\FindTagException;
use App\Exceptions\TagException\IndexTagException;
use App\Exceptions\TagException\StoreTagException;
use App\Exceptions\TagException\UpdateTagException;
use App\Models\Tag;
use Illuminate\Support\Facades\Log;

class TagService implements TagContract
{
    public function indexTag(IndexTagDTO $data)
    {
        try {
            return Tag::all();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new IndexTagException('Что-то пошло не так...', 500);
        }
    }

    public function storeTag(StoreTagDTO $data): bool
    {
        try {
            /** @var Tag $tag */
            $tag = new Tag();
            $tag->name = $data->name;
            $tag->save();

        } catch (\Exception $e){
            Log::error($e->getMessage());
            throw new StoreTagException('Что-то пошло не так...', 500);
        }
        return true;
    }

    public function updateTag(UpdateTagDTO $data): bool
    {
        try {
            /** @var Tag $tag */
            $tag = Tag::findOrFail($data->id);
        } catch (\Exception $e){
            Log::error($e->getMessage());
            throw new FindTagException('Тег не найден', 404);
        }
        try {
            $tag->name = $data->name;
            $tag->save();
        } catch (\Exception $e){
            Log::error($e->getMessage());
            throw new UpdateTagException('Что-то пошло не так...', 500);
        }
        return true;
    }

    public function deleteTag(int $id): bool
    {
        try {
            /** @var Tag $tag */
            $tag = Tag::findOrFail($id);
        } catch (\Exception $e){
            Log::error($e->getMessage());
            throw new FindTagException('Тег не найден', 404);
        }
        try {
            $tag->delete();
        } catch (\Exception $e){
            Log::error($e->getMessage());
            throw new DeleteTagException('Что-то пошло не так...', 500);
        }
        return true;
    }
}
