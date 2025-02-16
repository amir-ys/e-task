<?php

use Illuminate\Support\Facades\Route;

Route::get('ping/els', function () {
    $client = \Elasticsearch\ClientBuilder::create()
        ->setHosts([
            config('services.elasticsearch.host')
        ])
        ->build();

    try {
        $response = $client->ping();
        return response()->json([
            "message" => 'pong'
        ]);
    } catch (\Exception $e) {
        dd("Elasticsearch connection failed", $e->getMessage());
    }

});

