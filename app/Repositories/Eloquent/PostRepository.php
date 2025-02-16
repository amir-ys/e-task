<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\Eloquent\PostRepositoryInterface;
use App\Models\Post;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    protected function modelName(): string
    {
        return Post::class;
    }

    public function paginate($perPage = 15, $filter = null)
    {
        return $this->query
            ->latest()
            ->with('category')
            ->paginate($perPage)
            ->withQueryString();
    }
}
