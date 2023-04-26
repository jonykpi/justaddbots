<?php

use App\Models\Content;
use App\Models\Folder;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->intended('admin/login');
});
Route::get('delete/folder/', function (\Illuminate\Http\Request $request) {
    $current = Folder::find($request->folder_id);

    deleteVector($current->embedded_id);

//
//    $headers    =   [
//        'headers' => [
//            'Content-Type' => 'application/json',
//            'api-Key' => env('PINCONE_API_KEY'),
//        ],
//        'http_errors' => true,
//    ];
//
//
//
//    $client = new \GuzzleHttp\Client();
//    $response = $client->delete(
//        env('PINCONE_VECTOR_PATH')."/vectors/delete?namespaces=".$current->embedded_id,
//        $headers
//    );
//
//    $responseJSON = json_decode($response->getBody(), true);
//    dd($responseJSON,$current->embedded_id);
//



    Content::where('folder_id',$request->folder_id)->delete();
    $current->delete();

    return redirect()->route('filament.pages.dashboard');
})->name('delete.folder');



Route::get('/', function () {
    return redirect()->route('filament.pages.dashboard');
})->name('delete.folder');

Route::get('last-email/{folder}', function (Folder $folder) {
return view('mail.lastEmail',['email'=>json_decode($folder->last_email)]);
})->name('lastEmail');


