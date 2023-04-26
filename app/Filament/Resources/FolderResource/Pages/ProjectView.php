<?php

namespace App\Filament\Resources\FolderResource\Pages;

use App\Filament\Resources\FolderResource;
use App\Models\Content;
use App\Models\Folder;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Actions\ViewAction;
use Filament\Resources\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\PdfToText\Pdf;

class ProjectView extends Page implements HasForms,HasTable
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


    public function mount(): void
    {

        $this->content = new Content();
        $this->folder_id = \request()->route('record');
        $folder = Folder::find($this->folder_id);
        //$this->title = $folder->name;
        Page::$title = $folder->name;
        $this->embedded_id = $folder->embedded_id;

    }


    public function folders()
    {
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

    public function delete()
    {
        $current = Folder::find($this->folder_id);
        Content::where('folder_id', $this->folder_id)->delete();
        $current->delete();

        return redirect()->route('filament.pages.dashboard');

    }

    protected function getTableQuery(): Builder
    {
        return Folder::where('parent_folder_id', $this->folder_id)->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')->label('name'),


        ];
    }


   protected function getTableActions(): array
   {
       return [
           Action::make('edit')
               ->url(fn (Folder $record): string => route('filament.resources.bot.edit', $record)),
            Action::make('view')
                ->url(fn (Folder $record): string => route('filament.resources.bot.view', $record)),
           DeleteAction::make()
       ];
   }

    protected function getTableBulkActions(): array
    {
        return [
            DeleteBulkAction::make(),
        ];
    }

    protected function getFormModel(): string
    {
        return Content::class;
    }

    public function create()
    {

        $folder = Folder::find($this->folder_id);
        $file_titel = array_values($this->file_path)[0]->getClientOriginalName();
        $this->text_data = (new Pdf('/opt/homebrew/bin/pdftotext'))
            ->setPdf(array_values($this->file_path)[0]->getRealPath())->text();


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, env('BOT_URL') . "/api/training");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            "name=" . asset('storage' . array_values($this->file_path)[0]->getFilename()) . "&pincone_name=" . $folder->embedded_id . "&content=" . $this->text_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close($ch);

        if (json_decode($server_output)->status == false) {
            $this->is_learned = 1;
        } else {
            $this->is_learned = 0;
        }


        $arra = $this->form->getState();
        $arra['file_title'] = $file_titel;

        Content::create($arra);

        return redirect()->route('filament.resources.bot.view', $this->folder_id);
    }

    protected static string $view = 'filament.resources.folder-resource.pages.custom-list-folders';

}
