<?php

namespace App\Providers;

use App\Filament\Resources\FolderResource;
use App\Models\Folder;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {



        Filament::registerStyles([
            asset('css/custom.css'),
        ]);
        Filament::registerScripts([
            asset("https://code.jquery.com/jquery-2.2.4.min.js"),
            asset('js/custom.js')
        ]);


        Filament::navigation(function (NavigationBuilder $builder): NavigationBuilder {
            return $builder
                ->groups([
                    NavigationGroup::make('Website')
                        ->items([
                            ...PageResource::getNavigationItems(),
                            ...CategoryResource::getNavigationItems(),
                            ...HomePageSettings::getNavigationItems(),
                        ]),
                ]);
        });

        Filament::navigation(function (NavigationBuilder $builder) : NavigationBuilder {
            $folders = Folder::where('parent_folder_id','=',null)->get();
            $folder_menus = [
                NavigationItem::make('Dashboard')
                    ->icon('heroicon-o-home')
                    ->badge('main_folder')
                    ->activeIcon('heroicon-s-home')
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.pages.dashboard'))
                    ->url(route('filament.pages.dashboard'))
            ];
            foreach ($folders as $folder){

                $sub_folders = Folder::where('parent_folder_id','=',$folder->id)->get();

                $url = route('filament.resources.folders.view',$folder->id);

                if (!$folder->parent_folder_id){
                    $url = route('filament.resources.folders.viewProject',$folder->id);
                }

                array_push($folder_menus,
                    NavigationItem::make($folder->name)
                        ->icon('heroicon-o-cog')
                        ->badge('main_folder')
                        ->activeIcon('heroicon-s-cog')
                        ->isActiveWhen(fn (): bool => request()->fullUrlIs(url('admin/folders/project/view/'.$folder->id)) || request()->fullUrlIs(url('admin/folders/'.$folder->id."/edit"))|| request()->fullUrlIs(url('admin/folders/'.$folder->id."/thumb/logs")))
                        ->url($url)
                );

                foreach ($sub_folders as $sub_folder){
                    array_push($folder_menus,
                        NavigationItem::make($sub_folder->name)
                        ->icon('heroicon-o-folder')
                         ->badge($sub_folder->contents->count())
                        ->activeIcon('heroicon-s-folder')
                        ->isActiveWhen(fn (): bool => request()->fullUrlIs(url('admin/folders/view/'.$sub_folder->id)) || request()->fullUrlIs(url('admin/folders/'.$sub_folder->id."/edit")) || request()->fullUrlIs(url('admin/folders/'.$sub_folder->id."/thumb/logs")))
                        ->url(route('filament.resources.folders.view',$sub_folder->id)));
                }


            }
            return $builder->items($folder_menus);
        });

    }
}
