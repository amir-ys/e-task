<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\PostRepositoryInterface;
use App\Http\Requests\Post\PostRequest;
use App\Http\Resources\PostResource;
use App\Utilities\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{

    public function __construct(
        protected PostRepositoryInterface $postRepository
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $posts = $this->postRepository->paginate();

        return ApiResponse::success(
            PostResource::collection($posts)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $post = $this->postRepository->insert(
            $request->validated()
        );

        return ApiResponse::success(
            PostResource::make($post)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $post = $this->postRepository->findOneById($id);

        return ApiResponse::success(
            PostResource::make($post->load(['category']))
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        $post = $this->postRepository->findOneById($id);

        if (!$post) {
            return throw new ModelNotFoundException();
        }

        $this->postRepository->update(
            $id, $request->validated()
        );

        return ApiResponse::success(
            PostResource::make($post->refresh())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $this->postRepository->findOneById($id);
        $this->postRepository->destroy($id);

        return ApiResponse::success(
            data: [],
            message: "post deleted successfully"
        );
    }
}
