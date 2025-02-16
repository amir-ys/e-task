<?php

namespace App\Repositories\Elastic;

use App\Contracts\Repositories\Elastic\PostSearchRepositoryInterface;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

class PostSearchRepository extends BaseSearchRepository implements PostSearchRepositoryInterface
{
    protected function modelName(): string
    {
        return Post::class;
    }

    public function searchByTitleAndBody($query): LengthAwarePaginator
    {
        $response = $this->elasticSearch->search([
            'index' => $this->getSearchIndex(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'query' => $query,
                        'fields' => ['title', 'body'],
                    ],
                ],
            ],
        ]);

        return $this->getSearchResults(
            $response
        );
    }
}
