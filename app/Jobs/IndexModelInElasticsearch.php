<?php

namespace App\Jobs;

use Elasticsearch\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IndexModelInElasticsearch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function handle(): void
    {
        /**
         * @var $elasticSearch Client
         */
        $elasticSearch = resolve(Client::class);
        $elasticSearch->index([
            'index' => $this->model->getSearchIndex(),
            'id' => $this->model->getKey(),
            'body' => $this->model->toArray(),
        ]);
    }
}
