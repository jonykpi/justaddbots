<?php
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use OpenAI\Laravel\Facades\OpenAI;

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

//    dd(json_decode($response->getBody(), true),$namespace,$source);

    //echo $response->getStatusCode();
    return $response->getBody();
}

function languages(){
    $languages = array(
        'US' => 'English',
        'ES' => 'Spanish',
        'FR' => 'French',
        'PT' => 'Portuguese',
        'DA' => 'Danish',
        'DE' => 'German',
        'IT' => 'Italian',
        'NL' => 'Dutch',
        'NO' => 'Norwegian',
        'SV' => 'Swedish',
        'JS' => 'Japanese',
        'GR' => 'Greek',
        'CN' => 'Chinese',
        'IN' => 'Hindi',
        'KR' => 'Korean',
        'TR' => 'Turkish',
        'IL' => 'Hebrew',
        'SA' => 'Arabic'
    );
    return $languages;
}

function languageModels(){
    return [
        'gpt-3.5-turbo'=>'gpt-3.5-turbo',
        'gpt-3.5-turbo-16k'=> 'gpt-3.5-turbo-16k',
        'gpt-3.5-turbo-16k-0613'=>'gpt-3.5-turbo-16k-0613',
        'gpt-4'=>'gpt-4',
        'gpt-4-0613'=>'gpt-4-0613',
//        'gpt-4-32k'=>'gpt-4-32k',
//        'gpt-4-32k-0613'=>'gpt-4-32k-0613',
    ];
}

function userMbUsed($record){


        $total = 0;
    if ($record->email == "gerenteit@tiendasmass.com"){
        dd($record->companies->folders);
        foreach ($record->folders->pluck('contents') as $dd) {

            foreach ($dd as $item){
                $total += $item->media->sum('size');
            }
        }

        dd($total);

    }

        return number_format($total*0.000001,0);
}

function translateKeywords(array $keywords,array $languages){
    $messages = [
        ['role' => 'system', 'content' => ''],
        ['role' => 'user', 'content' => implode(',',$keywords).'
      translate the  keywords in JSON format with '.implode(',',$languages).' the language name will be the json key, '."here is the example of json response
 {
    'English': 'DO NOT UPGRADE YOUR FIRMWARE - PLEASE REQUEST TECHNICAL SUPPORT HERE',
    'Spanish': 'NO ACTUALIZES TU FIRMWARE - MEJOR SOLICITA SOPORTE TÉCNICO AQUÍ',
    'French': 'NE METTEZ PAS À JOUR VOTRE FIRMWARE - VEUILLEZ DEMANDER UN SUPPORT TECHNIQUE ICI',
    'Portuguese': 'NÃO ATUALIZE SEU FIRMWARE - POR FAVOR, SOLICITE SUPORTE TÉCNICO AQUI',

    }"],
    ];

    $result2 = OpenAI::chat()->create([
        'model' => 'gpt-3.5-turbo',
        'messages' => $messages,
    ]);

    return json_decode(Arr::get($result2, 'choices.0.message')['content']);

}

function translateString($string,array $languages){
    $messages = [
        ['role' => 'system', 'content' => ''],
        ['role' => 'user', 'content' => '``'.$string.'` ' .'
      translate the  text in JSON format with '.implode(',',$languages).' , each language name will be the json key and the translated items will be in json value'],
    ];

    $result2 = OpenAI::chat()->create([
        'model' => 'gpt-3.5-turbo',
        'messages' => $messages,
    ]);

    return json_decode(Arr::get($result2, 'choices.0.message')['content']);
}

function translateArray(array $arr){
    $langs = array_values(languages());
    $messages = [
        ['role' => 'system', 'content' => ''],
        ['role' => 'user', 'content' => '``'.json_encode($arr).'` ' .'
      translate this into this selected languages, here is the language list '.implode(',',$langs).' , each language name will be the json key and the translated items will be in json value'],
    ];

    $result2 = OpenAI::chat()->create([
        'model' => 'gpt-3.5-turbo',
        'messages' => $messages,
    ]);

    return json_decode(Arr::get($result2, 'choices.0.message')['content']);
}


function defultForm($default_then){
    if ($default_then == "DO NOTHING"){
        return [
            'a'=> 'CHATBOT LINK in EMAIL BODY',
            'c' =>'Custom EMAIL SUBJECT',
            'e' =>'PDF FILE to ANOTHER BOT',
        ];
    }else{
        return [
            'a'=> 'CHATBOT LINK in EMAIL BODY',
            'b' =>'BOT ANSWER in EMAIL BODY',
            'c' =>'Custom EMAIL SUBJECT with {answer}',
            'd' =>'BOT ANSWER to ANOTHER BOT',
            'e' =>'PDF FILE to ANOTHER BOT',
        ];
    }

}
function defaultTo($from,$user_id){
    $return = [];
    if (in_array($from,['a','b','c'])){
        $return['i'] ='EMAIL SENDER';
        $return['j'] = 'CUSTOM EMAIL';
    }elseif (in_array($from,['d','e'])){
        $return = \App\Models\User::find($user_id)->bots->pluck('name','id')->toArray();
    }
    return $return;
}
function defaultWith($to) : array{
    \Illuminate\Support\Facades\Log::info($to);
    $return = [];
    if (in_array($to,['i','j'])){
        $return['m'] = 'With PDF';
        $return['n'] = 'Without PDF';
    }else{
        $files =  \App\Models\Folder::find($to)?->contents->pluck('file_id','id')->toArray();
        if (!empty($files)){
            return $files;
        }
    }
    return $return;
}
