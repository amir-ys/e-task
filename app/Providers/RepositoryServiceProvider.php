<?php

namespace App\Providers;

use App\Contracts\Repositories\Elastic\PostSearchRepositoryInterface;
use App\Contracts\Repositories\Eloquent\PostRepositoryInterface;
use App\Repositories\Elastic\PostSearchRepository;
use App\Repositories\Eloquent\PostRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public $bindings = [
        #Elequent Repo
        PostRepositoryInterface::class => PostRepository::class,

        #Search Repo
        PostSearchRepositoryInterface::class => PostSearchRepository::class
    ];
}
