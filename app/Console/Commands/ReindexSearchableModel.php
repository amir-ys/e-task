<?php

namespace App\Console\Commands;

use App\Search\ElasticSearchable;
use Elasticsearch\Client;
use Illuminate\Console\Command;

class ReindexSearchableModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:reindex-searchable-model {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'reindex a specific model in Elasticsearch';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $modelName = $this->argument('model');

        if (!class_exists($modelName) || !in_array(ElasticSearchable::class, class_uses($modelName))) {
            $this->error("Model {$modelName} is either invalid or not searchable.");
            return;
        }

        $this->reindexModel($modelName);
    }

    private function reindexModel(string $modelName): void
    {
        $elasticsearch = resolve(Client::class);
        $this->info("reindexing {$modelName}...");

        $model = new $modelName;
        $totalRecords = $model->count();

        if ($totalRecords === 0) {
            $this->warn("no records found for {$modelName}.");
            return;
        }

        $progressBar = $this->output->createProgressBar($totalRecords);
        $progressBar->start();

        $query = $model->newQuery();
        $query->chunk(200, function ($models) use ($elasticsearch, $progressBar) {
            $bulkData = [];

            foreach ($models as $model) {
                $bulkData[] = [
                    'index' => [
                        '_index' => $model->getSearchIndex(),
                        '_id'    => $model->getKey(),
                    ]
                ];
                $bulkData[] = $model->toArray();

                $progressBar->advance();
            }

            if (!empty($bulkData)) {
                $elasticsearch->bulk(['body' => $bulkData]);
            }
        });

        $progressBar->finish();
        $this->newLine();
        $this->info("reindexing of {$modelName} completed.");
    }

}
