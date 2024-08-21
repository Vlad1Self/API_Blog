<?php

namespace App\Http\Controllers;

use App\Contracts\PostContract;
use App\DTO\PostDTO\IndexPostDTO;
use App\DTO\PostDTO\StorePostDTO;
use App\DTO\PostDTO\UpdatePostDTO;
use App\Exceptions\PostException\DeletePostException;
use App\Exceptions\PostException\FindPostException;
use App\Exceptions\PostException\IndexPostException;
use App\Exceptions\PostException\StorePostException;
use App\Exceptions\PostException\UpdatePostException;
use App\Http\Requests\PostRequest\IndexPostRequest;
use App\Http\Requests\PostRequest\StorePostRequest;
use App\Http\Requests\PostRequest\UpdatePostRequest;
use App\Http\Resources\PostResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{

    private PostContract $service;

    public function __construct(PostContract $service)
    {
        $this->service = $service;
    }

    public function indexPost(IndexPostRequest $request): JsonResponse|AnonymousResourceCollection
    {
        $data = new IndexPostDTO($request->validated());

        try {
            $posts = $this->service->indexPost($data);
        } catch (IndexPostException $e){
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return PostResource::collection($posts);
    }

    public function storePost(StorePostRequest $request): JsonResponse
    {
        $data = new StorePostDTO($request->validated());

        try {
            $this->service->storePost($data);
        } catch (StorePostException $e){
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return response()->json(['message' => 'Успешно создано'], 201);
    }


    public function updatePost(UpdatePostRequest $request): JsonResponse
    {
        $data = new UpdatePostDTO($request->validated());

        try {
            $this->service->updatePost($data);
        } catch (UpdatePostException|FindPostException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        return response()->json(['message' => 'Успешно обновлено'], 200);
    }

    public function deletePost(int $id): JsonResponse
    {
        try {
            $this->service->deletePost($id);
        } catch (DeletePostException|FindPostException $e){
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }
        return response()->json(['message' => 'Успешно удалено'], 200);
    }

}
