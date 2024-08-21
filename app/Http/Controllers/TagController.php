<?php

namespace App\Http\Controllers;

use App\Contracts\TagContract;
use App\DTO\TagDTO\IndexTagDTO;
use App\DTO\TagDTO\StoreTagDTO;
use App\DTO\TagDTO\UpdateTagDTO;
use App\Exceptions\TagException\DeleteTagException;
use App\Exceptions\TagException\FindTagException;
use App\Exceptions\TagException\IndexTagException;
use App\Exceptions\TagException\StoreTagException;
use App\Exceptions\TagException\UpdateTagException;
use App\Http\Requests\TagRequest\IndexTagRequest;
use App\Http\Requests\TagRequest\StoreTagRequest;
use App\Http\Requests\TagRequest\UpdateTagRequest;
use App\Http\Resources\TagResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TagController extends Controller
{

    private TagContract $service;

    public function __construct(TagContract $service)
    {
        $this->service = $service;
    }

    public function indexTag(IndexTagRequest $request): JsonResponse|AnonymousResourceCollection
    {
        $data = new IndexTagDTO($request->validated());

        try {
            $tags = $this->service->indexTag($data);
        } catch (IndexTagException $e){
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return TagResource::collection($tags);
    }

    public function storeTag(StoreTagRequest $request): JsonResponse
    {
        $data = new StoreTagDTO($request->validated());

        try {
            $this->service->storeTag($data);
        } catch (StoreTagException $e){
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return response()->json(['message' => 'Успешно создано'], 201);
    }


    public function updateTag(UpdateTagRequest $request): JsonResponse
    {
        $data = new UpdateTagDTO($request->validated());

        try {
            $this->service->updateTag($data);
        } catch (UpdateTagException|FindTagException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        return response()->json(['message' => 'Успешно обновлено'], 200);
    }

    public function deleteTag(int $id): JsonResponse
    {
        try {
            $this->service->deleteTag($id);
        } catch (DeleteTagException|FindTagException $e){
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }
        return response()->json(['message' => 'Успешно удалено'], 200);
    }

}
