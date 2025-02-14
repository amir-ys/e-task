<?php

namespace App\Providers;

use App\Contracts\Repositories\PostRepositoryInterface;
use App\Repositories\Eloquent\PostRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public $bindings = [
        PostRepositoryInterface::class => PostRepository::class
    ];
}
