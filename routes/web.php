<?php

use App\Models\Content;
use App\Models\Folder;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

Route::get('/wz', function () {
    return view('welcome');
});
Route::get('/', function () {

    return view('welcome');
});
Route::get('delete/folder/', function (\Illuminate\Http\Request $request) {
    $current = Folder::find($request->folder_id);
    deleteVector($current->embedded_id);
    Content::where('folder_id',$request->folder_id)->delete();
    $current->delete();

    return redirect()->route('filament.pages.dashboard');
})->name('delete.folder');


//Route::get('/', function () {
//    return redirect()->route('filament.pages.dashboard');
//});
Route::get('folder-content/{id}/{slug}', function (Content $id,$slug) {

    return view('text-show',['content'=>$id]);
})->name('folderTextContent');
Route::get('dowloadRqCode', function (\Illuminate\Http\Request $request) {
    $folder = Folder::where('embedded_id',explode('?widget=',$request->url)[1])->first();
    $fileDest = storage_path('app/'.$folder->name.'.svg');
    $url =$request->url;
    \SimpleSoftwareIO\QrCode\Facades\QrCode::size(400)->generate($url, $fileDest);
    //return \Illuminate\Support\Facades\Storage::download($fileDest);
    return response()->download($fileDest);
})->name('dowloadRqCode');
Route::get('moveFolder/{folder}/{target}', function (Folder $folder,$target) {
    $folder->parent_folder_id = $target;
    $folder->save();
    return redirect()->back();
})->name('moveFolder');

Route::get('copyFolder/{folder}/{target}', function (Folder $folder,$target) {




    $replicate = $folder->replicate();



    $replicate->embedded_id = Str::random(40);
    $replicate->parent_folder_id = $target;
    $replicate->email = null;
    $replicate->email_status = 0;
    $replicate->save();

    if (!is_dir(\Illuminate\Support\Facades\Storage::path("public/".$folder->id))){
        mkdir( \Illuminate\Support\Facades\Storage::path("public/".$folder->id),0777);
    }

       if (is_file(\Illuminate\Support\Facades\Storage::path("public/".$folder->bot_icon))){
           \Illuminate\Support\Facades\File::copy(
               \Illuminate\Support\Facades\Storage::path("public/".$folder->bot_icon),
               \Illuminate\Support\Facades\Storage::path("public/".$replicate->id."-".$folder->bot_icon)
           );
           $replicate->bot_icon =   $replicate->id."-".$folder->bot_icon;
       }


    if (is_file(\Illuminate\Support\Facades\Storage::path("public/".$folder->user_icon))) {
        \Illuminate\Support\Facades\File::copy(
            \Illuminate\Support\Facades\Storage::path("public/" . $folder->user_icon),
            \Illuminate\Support\Facades\Storage::path("public/" . $replicate->id . "-" . $folder->user_icon)
        );
        $replicate->user_icon =   $replicate->id."-".$folder->user_icon;
    }
    if (is_file(\Illuminate\Support\Facades\Storage::path("public/".$folder->instruction_logo))) {
        \Illuminate\Support\Facades\File::copy(
            \Illuminate\Support\Facades\Storage::path("public/" . $folder->instruction_logo),
            \Illuminate\Support\Facades\Storage::path("public/" . $replicate->id . "-" . $folder->instruction_logo)
        );
        $replicate->instruction_logo =   $replicate->id."-".$folder->instruction_logo;
    }
    if (is_file(\Illuminate\Support\Facades\Storage::path("public/".$folder->send_button_icon))) {
        \Illuminate\Support\Facades\File::copy(
            \Illuminate\Support\Facades\Storage::path("public/" . $folder->send_button_icon),
            \Illuminate\Support\Facades\Storage::path("public/" . $replicate->id . "-" . $folder->send_button_icon)
        );
        $replicate->send_button_icon =   $replicate->id."-".$folder->send_button_icon;
    }
    if (is_file(\Illuminate\Support\Facades\Storage::path("public/".$folder->custom_button_icon))) {
        \Illuminate\Support\Facades\File::copy(
            \Illuminate\Support\Facades\Storage::path("public/" . $folder->custom_button_icon),
            \Illuminate\Support\Facades\Storage::path("public/" . $replicate->id . "-" . $folder->custom_button_icon)
        );
        $replicate->custom_button_icon =   $replicate->id."-".$folder->custom_button_icon;
    }




    $replicate->save();
    foreach ($folder->prompts as $prompt){
        $prompt->folder_id = $replicate->id;

//       dd($button->tags->replicate());
        $replicate_promote = $prompt->replicate();
        $replicate_promote->save();
    }

    foreach ($folder->commands as $command){
        $command->folder_id = $replicate->id;

//       dd($button->tags->replicate());
        $replicate_promote = $command->replicate();
        $replicate_promote->save();
    }

    foreach ($folder->buttons as $button){
        $button->folder_id = $replicate->id;

//       dd($button->tags->replicate());
        $replicate_button = $button->replicate();
        $replicate_button->save();


        if (!is_dir(\Illuminate\Support\Facades\Storage::path("public/".$replicate_button->id))){
            mkdir( \Illuminate\Support\Facades\Storage::path("public/".$replicate_button->id),0777);
        }

        if (is_file(\Illuminate\Support\Facades\Storage::path("public/".$button->button_icon))){
            $ty = explode('/',$button->button_icon);

            \Illuminate\Support\Facades\File::copy(
                \Illuminate\Support\Facades\Storage::path("public/".$button->button_icon),
              isset($ty[1]) ?
                  \Illuminate\Support\Facades\Storage::path("public/".$replicate_button->id."/".$ty[1])
                  :
                  \Illuminate\Support\Facades\Storage::path("public/".$replicate_button->id."/".$ty[0])
            );
            if (isset($ty[1])){
                $replicate_button->button_icon =   $replicate_button->id."/". $ty[1];
            }else{
                $replicate_button->button_icon =   $replicate_button->id."/".$ty[0];
            }

        }

        if (is_object($button->tags)){
            $replicate_button->attachTags($button->tags->pluck('name')->toArray());
        }else{
            $replicate_button->attachTags(json_decode($button->tags));
        }
        $replicate_button->save();


    }

    //user_icon
    //instruction_logo
    //send_button_icon
    //custom_button_icon



    return redirect()->back();
})->name('copyFolder');

//Route::get('admin/project-create',[\App\Http\Controllers\ProjectController::class,'index'])->name('project.create');
Route::get('admin/projectcreate/{project?}',[\App\Http\Controllers\ProjectController::class,'index'])->name('project.create');
Route::get('last-email/{folder}', function (Folder $folder) {
return view('mail.lastEmail',['email'=>json_decode($folder->last_email)]);
})->name('lastEmail');



Route::middleware([
    'auth:sanctum',
    config('filament-companies.auth_session'),
    'verified'
])->group(function () {

});


Route::get('sitemap',function() {
    \Spatie\Sitemap\SitemapGenerator::create('https://aibotbuild.com')->writeToFile('sitemap.xml');

});

