@if (filled($brand = config('filament.brand')))
    <div @class([
        'filament-brand text-xl font-bold tracking-tight',
        'dark:text-white' => config('filament.dark_mode'),
    ])>

        <a href="https://www.aibotbuild.com/">
            <img class="logo" src="{{asset('icons/logo_.png')}}" alt="">
        </a>

    </div>
@endif
