<?php

namespace App\Providers;

use App;
use Session;
use App\Models\User;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\View;
use Config;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Cache::flush();

        cache()->forget('generalsettings');
        $admin_lang = DB::table('admin_languages')->where('is_default','=',1)->first();
        App::setlocale($admin_lang->name);
        User::chekValidation();

        view()->composer('*',function($settings){
           
            $settings->with('gs', cache()->remember('generalsettings', now()->addDay(), function () {
                return DB::table('generalsettings')->first();
            }));

            Config::set('captcha.sitekey', $settings['gs']->capcha_site_key);
            Config::set('captcha.secret', $settings['gs']->capcha_secret_key); 
            
            $settings->with('ps', cache()->remember('pagesettings', now()->addDay(), function () {
                return DB::table('pagesettings')->first();
            }));

            $settings->with('seo', cache()->remember('seotools', now()->addDay(), function () {
                return DB::table('seotools')->first();
            }));

            $settings->with('socialsetting', cache()->remember('socialsettings', now()->addDay(), function () {
                return DB::table('socialsettings')->first();
            }));

            $settings->with('categories', cache()->remember('categories', now()->addDay(), function () {
                return Category::with('subs')->where('status','=',1)->get();
            }));

            if (Session::has('language')){
                $data = cache()->remember('session_language', now()->addDay(), function () {
                    return DB::table('languages')->find(Session::get('language'));
                    
                });
               
                App::setlocale($data->name);
                
                $settings->with('langg', $data);
            }
            else{
                $data = cache()->remember('default_language', now()->addDay(), function () {
                    return DB::table('languages')->where('is_default','=',1)->first();
                });
                App::setlocale($data->name);
                $settings->with('langg', $data);
            }

            if (!Session::has('popup'))
            {
                $settings->with('visited', 1);
            }

            Session::put('popup' , 1);
            $cl = Language::where('is_default', 1)->first();
            View::share('cl', $cl);

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

    }
}
