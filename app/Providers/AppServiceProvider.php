<?php

namespace App\Providers;

use App\Filament\Resources\FolderResource;
use App\Filament\Resources\PlansResource;
use App\Models\Folder;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\UserMenuItem;
use Filament\Widgets\AccountWidget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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

       Model::unguard();

        Filament::registerStyles([
            asset('css/custom.css'),
        ]);
        Filament::registerScripts([
            asset("https://code.jquery.com/jquery-2.2.4.min.js"),
            asset('js/custom.js')
        ]);

       // dd(Auth::user());
        Cache::delete('all_folder');

        Filament::navigation(function (NavigationBuilder $builder) : NavigationBuilder {
            $builder->items([
//                NavigationItem::make('Dashboard')
//                    ->icon('heroicon-o-home')
//                    ->badge('main_folder')
//                    ->activeIcon('heroicon-s-home')
//                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.pages.dashboard'))
//                    ->url(route('filament.pages.dashboard'))
            ]);
            if (Auth::user()->role == "user"){

                if (!Cache::has('all_folder')){
                   $all_folder = Folder::with('contents')->where('company_id',Auth::user()->currentCompany->id)->get();
                    Cache::set('all_folder',$all_folder);

                }else{
                    $all_folder = Cache::get('all_folder');

                }

                $folders = $all_folder->where('parent_folder_id','=',null);

                foreach ($folders as $folder){

                    $sum_menus = [];

                    $sub_folders = $all_folder->where('parent_folder_id','=',$folder->id);


                    $url = route('filament.resources.folders.view',$folder->id);

                    if (!$folder->parent_folder_id){
                        $url = route('filament.resources.folders.viewProject',$folder->id);
                    }


//                    array_push($folder_menus,
//                        NavigationItem::make($folder->name)
//                            ->icon('heroicon-o-cog')
//                            ->badge('main_folder')
//                            ->activeIcon('heroicon-s-cog')
//                            ->isActiveWhen(fn (): bool => request()->fullUrlIs(url('admin/folders/project/view/'.$folder->id)) || request()->fullUrlIs(url('admin/folders/'.$folder->id."/edit"))|| request()->fullUrlIs(url('admin/folders/'.$folder->id."/thumb/logs")))
//                            ->url($url)
//                    );
                    array_push($sum_menus,
                                            NavigationItem::make("Settings")
                            ->icon('heroicon-o-cog')
                            ->badge('main_folder')
                            ->activeIcon('heroicon-s-cog')
                            ->isActiveWhen(fn (): bool => request()->fullUrlIs(url('admin/folders/project/view/'.$folder->id)) || request()->fullUrlIs(url('admin/folders/'.$folder->id."/edit"))|| request()->fullUrlIs(url('admin/folders/'.$folder->id."/thumb/logs")))
                            ->url($url)
                    );

                    foreach ($sub_folders as $sub_folder){
                        array_push($sum_menus,
                            NavigationItem::make($sub_folder->name)
                                ->icon(($sub_folder->whatsapp_number && $sub_folder->whatsapp_access_token && $sub_folder->whatsapp_id) ? 'heroicon-o-phone' : 'heroicon-o-folder')
                                ->badge($sub_folder->contents->count())
                                ->activeIcon(($sub_folder->whatsapp_number && $sub_folder->whatsapp_access_token && $sub_folder->whatsapp_id) ? 'heroicon-o-phone' : 'heroicon-o-folder')
                                ->isActiveWhen(fn (): bool => request()->fullUrlIs(url('admin/folders/view/'.$sub_folder->id))
                                    || request()->fullUrlIs(url('admin/folders/'.$sub_folder->id."/edit"))
                                    || request()->fullUrlIs(url('admin/dynamic-buttons?folder_id='.$sub_folder->id))
                                    || request()->fullUrlIs(url('admin/contents/create?folder_id='.$sub_folder->id."&type=txt"))
                                    || request()->fullUrlIs(url('admin/contents/create?folder_id='.$sub_folder->id."&type=file"))
                                    || request()->fullUrlIs(url('admin/dynamic-buttons/create?folder_id='.$sub_folder->id))
                                    || request()->fullUrlIs(url('admin/folders/'.$sub_folder->id."/thumb/logs")))
                                ->url(route('filament.resources.folders.view',$sub_folder->id)));
                    }


                    $builder
                        ->groups([
                            NavigationGroup::make($folder->name)->collapsed()
                                ->items($sum_menus),
                        ]);


                }
            }else{
                $builder->items([
                    NavigationItem::make('Users')
                        ->icon('heroicon-o-users')
                        ->badge('main_folder')
                        ->activeIcon('heroicon-s-users')
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.resources.users.index'))
                        ->url(route('filament.resources.users.index')),
                    NavigationItem::make('Plans')
                        ->icon('heroicon-o-server')
                        ->badge('main_folder')
                        ->activeIcon('heroicon-s-server')
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.resources.plans.index'))
                        ->url(route('filament.resources.plans.index')),
                    NavigationItem::make('Settings')
                        ->icon('heroicon-o-server')
                        ->badge('main_folder')
                        ->activeIcon('heroicon-s-server')
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.pages.manage-default-project'))
                        ->url(route('filament.pages.manage-default-project')),
                ]);

            }


            return $builder;
        });

    }
}
