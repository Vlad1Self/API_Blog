<?php

namespace App\Services;

use App\DTO\PostDTO\IndexPostDTO;
use App\DTO\PostDTO\StorePostDTO;
use App\DTO\PostDTO\UpdatePostDTO;
use App\Contracts\PostContract;
use App\Exceptions\PostException\DeletePostException;
use App\Exceptions\PostException\FindPostException;
use App\Exceptions\PostException\IndexPostException;
use App\Exceptions\PostException\StorePostException;
use App\Exceptions\PostException\UpdatePostException;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class PostService implements PostContract
{
    public function indexPost(IndexPostDTO $data): LengthAwarePaginator
    {
        try {
            return Post::with(['categories', 'tags'])->paginate($data->per_page, ['*'], 'page', $data->page);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new IndexPostException('Что-то пошло не так...', 500);
        }
    }

    public function storePost(StorePostDTO $data): bool
    {
        try {
            /** @var Post $post */
            $post = new Post();
            $post->title = $data->title;
            $post->content = $data->content;
            $post->category_id = $data->category_id;
            $post->save();

            $post->tags()->sync($data->tag_id);
        } catch (\Exception $e){
            Log::error($e->getMessage());
            throw new StorePostException('Что-то пошло не так...', 500);
        }
        return true;
    }

    public function updatePost(UpdatePostDTO $data): bool
    {
        try {
            /** @var Post $post */
            $post = Post::findOrFail($data->id);
        } catch (\Exception $e){
            Log::error($e->getMessage());
            throw new FindPostException('Пост не найден', 404);
        }

        try {
            $post->title = $data->title;
            $post->content = $data->content;
            $post->category_id = $data->category_id;
            $post->save();

            $post->tags()->sync($data->tag_id);
        } catch (\Exception $e){
            Log::error($e->getMessage());
            throw new UpdatePostException('Что-то пошло не так...', 500);
        }
        return true;
    }

    public function deletePost(int $id): bool
    {
        try {
            /** @var Post $post */
            $post = Post::findOrFail($id);
        } catch (\Exception $e){
            Log::error($e->getMessage());
            throw new FindPostException('Пост не найден', 404);
        }

        try {
            $post->delete();
        } catch (\Exception $e){
            Log::error($e->getMessage());
            throw new DeletePostException('Что-то пошло не так...', 500);
        }
        return true;
    }
}
