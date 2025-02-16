<?php

namespace App\Contracts\Repositories\Elastic;

interface PostSearchRepositoryInterface
{
    public function searchByTitleAndBody($query);
}
