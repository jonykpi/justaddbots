

@if($item->type == "txt")
    {!! $item->row_text !!}
@else
    @php
        $media =  $item->media()->where('collection_name','images')->orderByDesc('id')->first();
    @endphp
    @if($media)
        @php
            $file_path = \Illuminate\Support\Facades\Storage::url('public/'.$media->id.'/'.$media->file_name);
        @endphp
        <style>
            .filament-modal-window{
                min-width: 100%;
            }
        </style>

        <iframe style="height: 100%;width: 100%;min-height: 700px" src="{{$file_path}}"></iframe>
    @endif



@endif

