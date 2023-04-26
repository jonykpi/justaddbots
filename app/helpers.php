<?php
use GuzzleHttp\Client;
function deleteVector($namespace,array $source=[]){


    $client = new Client([
        'base_uri' => env('PINCONE_HOST_URL'),
    ]);

    $response = $client->request('POST', 'vectors/delete', [
        'headers' => [
            'Api-Key' => env('PINCONE_API_KEY'),
            'Content-Type' => 'application/json',
        ],
        'json' => isset($source[0]) ?  [
            "deleteAll"=> false,
            'namespace' => $namespace,
            'filter' => [
                'source' => [
                    '$in' =>$source,
                ],
            ],
        ] : [
            "deleteAll"=> true,
            'namespace' => $namespace,
        ],
    ]);

    //echo $response->getStatusCode();
    return $response->getBody();
}
