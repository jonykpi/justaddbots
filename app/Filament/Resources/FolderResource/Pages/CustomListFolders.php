<?php

namespace App\Filament\Resources\FolderResource\Pages;

use App\Filament\Resources\FolderResource;
use App\Http\Services\cPanelApi;
use App\Models\Compliment;
use App\Models\Content;
use App\Models\Folder;
use App\Models\Mails;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Resources\Pages\Page;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use GuzzleHttp\RequestOptions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\PdfToText\Pdf;
use Illuminate\Database\Eloquent\Collection;

class CustomListFolders extends Page implements HasForms,HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    protected Content $content;



    //public static ?string $title = 'View folder';


    protected static string $resource = FolderResource::class;

    public $file_path;
    public $folder_id;
    public $embedded_id;
    public ?string $file_title;
    public ?string $text_data;
    public ?string $is_learned;
    public ?string $default_file_id = 'new';
    public ?string $default_then = 'SUMMARIZE';
    public ?string $default_custom_prompt = '';
    public ?string $enable_email = 'Import files via email';
    public ?string $reactive_text = 'Reactivate';
    protected $listeners = [
        'userUpdated' => '$refresh',
    ];

    ////////// default email /////////
    public ?array $default_email_settings = [[]];
    ////////// default email /////////
    ///
    public function addNew(){
        array_push($this->default_email_settings,[]);
      //  $this->total_email_settings =  array_push($this->default_email_settings,[]);

      // array_push($this->total_email_settings,[]);
    }

    public function submitDefault(){

      $folder = Folder::find($this->folder_id);
        $folder->default_file_id = $this->default_file_id;
        $folder->default_then = $this->default_then;
        $folder->default_custom_prompt = $this->default_custom_prompt;
        $folder->default_email_settings = json_encode($this->default_email_settings);
        $folder->save();
        Notification::make()
            ->title("Default settings save successfully")
            ->success()
            ->send();
    }
    public function changeForm($i){
        $this->default_email_settings[$i]['to'] = null;
    }

    public function defaultReset(){
        $this->default_file_id = 'new';
        $this->default_then = 'DO NOTHING';
        $this->default_email_settings = [
                                  [
                                    "to"=> "i",
                                    "from"=> "a",
                                    "include"=> "n"
                                ]
                          ];
    }
    public function delete($key){
        $settings = $this->default_email_settings;
        unset($settings[$key]);
        $this->default_email_settings = array_values($settings);
        //$this->total_email_settings--;
        $this->emit('userUpdated');
    }


    /**
     * @param string|null $breadcrumb
     */


    public function mount(): void
    {
        $this->content = new Content();
        $this->folder_id = \request()->route('record');
        $folder = Folder::find($this->folder_id );
        if($folder->company_id != Auth::user()->company->id){
            throw new \ErrorException('Error found');
        }
        //$this->title = $folder->name;

        Page::$title = $folder->name;
        $this->embedded_id =$folder->embedded_id;
        if (!empty($folder->email_status) && $folder->email_status == 1){

            $this->enable_email = $folder->email;
            $this->reactive_text = 'Deactivate';
        }

      $this->default_file_id = $folder->default_file_id;
      $this->default_then = $folder->default_then;
      $this->default_custom_prompt = $folder->default_custom_prompt;
      $this->default_email_settings = json_decode($folder->default_email_settings,true);






    }



    public function folders(){
        return Folder::all();
    }

    protected function getFormSchema(): array
    {
        return [
           TextInput::make('file_title')->label('Filename')
                ->hidden(),
            Hidden::make('folder_id')
                ->required(),
            Hidden::make('text_data')
                ->required(),
            Hidden::make('is_learned')->default(0),
            FileUpload::make('file_path')->required()->preserveFilenames()->acceptedFileTypes(['application/pdf'])->enableOpen()->enableDownload()

        ];
    }
    public function reactiveOrDeactive(){
        $folder = Folder::find($this->folder_id);
        if ($folder->email_status){
            $folder->email_status = 0;
            $this->enable_email = 'Import files via email';
            $this->reactive_text = 'Reactivate';
        }else{
            if ($folder->email == ""){
                $this->generateNEwEmail();
            }
            $folder = Folder::find($this->folder_id);
            $folder->email_status = 1;
            $this->enable_email = $folder->email;
            $this->reactive_text = 'Deactivate';
        }
        $folder->save();

        $this->getTitle();
    }


    public function generateNEwEmail(){



        $cpanel = new \App\Http\Service\cPanelApi(env('CPANEL_HOST'),env('CPANEL_USERNAME'),env('CPANEL_PASSWORD'));
        $string = Str::lower(Str::random(10));

        $mail=  $cpanel->createEmail($string."@aibotbuild.com",$string);


        if (json_decode($mail)->status == 1){

            $folder = Folder::find($this->folder_id);
            $folder->email_status = 1;
            $folder->email = $string."@aibotbuild.com";
            $folder->save();

            $this->enable_email = $string."@aibotbuild.com";
            $this->reactive_text = "Deactivate";
        }

        $this->getTitle();

//        return true;
    }

    public function getBreadcrumbs(): array
    {
        $arr = [];
                $folder = Folder::find($this->folder_id);

        if ($folder->parent){
            array_push($arr,$folder->parent->name);
        }
       // array_push($arr, $folder->name);


        return $arr; // TODO: Change the autogenerated stub
    }

//    public function getTitle(): string
//    {
//        $folder = Folder::find($this->folder_id);
//
//        if ($folder->parent){
//            return $folder->parent->name." / ".$folder->name;
//        }
//        return $folder->name; // TODO: Change the autogenerated stub
//    }

    protected function getTableQuery(): Builder
    {

        return Content::where('folder_id',$this->folder_id)->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('file_title')->searchable()->limit(20)->tooltip(fn($record)=>$record->file_title)->label('Filename'),
            TextColumn::make('file_id')->searchable()->label('FileId'),
            TextColumn::make('summery')->searchable()->limit(20)->tooltip(fn($record)=>$record->summery)->label('summery'),
            BadgeColumn::make('is_learned')->searchable()
                ->color(static function ($state): string {
                    if ($state === '1') {
                        return 'success';
                    }

                    return 'primary';
                })
                ->enum([
                    '0' => 'Pending',
                    '1' => 'Learned',
                ])->label('Learned'),


        ];
    }


    protected function getTableActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('Edit')->icon('heroicon-o-pencil')->url(fn (Content $record): string => route('filament.resources.contents.edit', [$record,'type'=>!empty($record->type) ? $record->type : 'file'])),
                Action::make('Preview')
                    ->configure()
                    ->icon('heroicon-o-document')
                    ->action(fn () => $this->record)
                    ->modalActions([])
                    ->modalContent(fn (Content $record): object =>view('filament.resources.folder-resource.pages.preview', ['item' => $record])),
                DeleteAction::make()->before(function (Content $record) {
                    $media = $record->media()->first();
                    if ($media){
                        deleteVector($record->folder->embedded_id,[Storage::path("public/".$media->id."/".$media->file_name)]);
                    }else{

                        if ($record->type == 'url'){

                            deleteVector($record->folder->embedded_id,[$record->file_title]);
                        }else{
                            deleteVector($record->folder->embedded_id,[$this->clean($record->file_title)]);
                        }

                    }

                })
            ]),

        ];
    }

    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    protected function getTableBulkActions(): array
    {
        return [
            DeleteBulkAction::make()->before(function (Collection $records, array $data): void {
             $folder = Folder::find($this->folder_id);
              $paths = [];
                foreach ($records as $record) {
                    if ($record->is_learned == 1){
                        $media = $record->media()->first();
                        if ($media){
                            array_push($paths,Storage::path("public/".$media->id."/".$media->file_name));
                        }else{
                            if ($record->type == 'url') {
                                array_push($paths,$record->file_title);
                            }else{
                                array_push($paths,$this->clean($record->file_title));
                            }

                        }

                    }

                }
               deleteVector($folder->embedded_id,$paths);
            })
        ];
    }

    protected function getFormModel(): string
    {
        return Content::class;
    }

    public function create()
    {

        $folder = Folder::find($this->folder_id);
       $file_titel =  array_values($this->file_path)[0]->getClientOriginalName();
        $this->text_data = (new Pdf('/opt/homebrew/bin/pdftotext'))
            ->setPdf(array_values($this->file_path)[0]->getRealPath())->text();


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,env('BOT_URL')."/api/training");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            "name=".asset('storage'.array_values($this->file_path)[0]->getFilename())."&pincone_name=".$folder->embedded_id."&content=".$this->text_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close($ch);

        if (json_decode($server_output)->status == false){
            $this->is_learned = 1;
        }else{
            $this->is_learned = 0;
        }


       $arra = $this->form->getState();
        $arra['file_title'] =$file_titel;

        Content::create($arra);

        return redirect()->route('filament.resources.folders.view',$this->folder_id);
    }

    protected static string $view = 'filament.resources.folder-resource.pages.custom-list-folders';
}
