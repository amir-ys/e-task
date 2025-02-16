<?php

namespace App\Search;

use App\Jobs\IndexModelInElasticsearch;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Model;

trait ElasticSearchable
{
    public static function bootElasticSearchable(): void
    {
        static::created(function (Model $model) {
            IndexModelInElasticsearch::dispatch($model);
        });

        static::updated(function (Model $model) {
            IndexModelInElasticsearch::dispatch($model);
        });

        static::deleted(function (Model $model) {
            $searchIndex = $model->getSearchIndex();
            $searchId = $model->getKey();
            dispatch(function () use ($searchIndex, $searchId) {
                app(Client::class)->delete([
                    'index' => $searchIndex,
                    'id' => $searchId,
                ]);
            });
        });
    }

    public function getSearchIndex(): string
    {
        return $this->searchIndex ?? $this->getTable();
    }
}

