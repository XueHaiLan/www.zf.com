<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EsController extends Controller
{
    public function initIndex()
    {
        $host=config('es.host');
        $client = \Elasticsearch\ClientBuilder::create()->setHosts($host)->build();

// 创建索引
        $params = [
            'index' => 'fangs',
            'body' => [
                'settings' => [
                    'number_of_shards' => 5,
                    'number_of_replicas' => 1
                ],
                'mappings' => [
                        '_source' => [
                            'enabled' => true
                        ],
                        'properties' => [
                            'title' => [
                                'type' => 'keyword'
                            ],
                            'desn' => [
                                'type' => 'text',
                                'analyzer' => 'ik_max_word',
                                'search_analyzer' => 'ik_max_word'
                            ]
                        ]
                ]
            ]
        ];
        $response = $client->indices()->create($params);
        dump($response);
    }
}
