<?php

namespace App\Repositories\Elastic;

use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

abstract class BaseSearchRepository
{
    protected Client $elasticSearch;
    protected Model $model;

    public function __construct()
    {
        $this->elasticSearch = resolve(Client::class);
        $this->model = resolve($this->modelName());
    }

    abstract protected function modelName(): string;

    public function getSearchIndex(): string
    {
        return $this->model->getSearchIndex();
    }

    protected function getSearchResults($response, $perPage = null, $page = 1): LengthAwarePaginator
    {
        if ($perPage == null) {
            $perPage = $this->model->getPerPage();
        }

        $posts = $this->extractHits($response);
        $total = $response['hits']['total']['value'] ?? 0;

        return $this->paginateResults($posts, $total, $perPage, $page);
    }

    protected function extractHits($response): Collection
    {
        $hits = $response['hits']['hits'] ?? [];
        return collect($hits)->map(function ($hit) {
            return $this->model->newFromBuilder($hit['_source']);
        });
    }

    protected function paginateResults($posts, $total, $perPage, $page): LengthAwarePaginator
    {
        return new LengthAwarePaginator(
            $posts,
            $total,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}
