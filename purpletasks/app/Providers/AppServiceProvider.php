<?php

namespace App\Providers;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use BezhanSalleh\LanguageSwitch\LanguageSwitch;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        if (! app()->runningInConsole() || app()->environment('testing')) {
            config(['filesystems.disks.public.url' => request()->getSchemeAndHttpHost().'/storage']);

            // Redirect www to non-www
            $host = request()->getHost();
            if (str_starts_with($host, 'www.')) {
                $newHost = substr($host, 4);
                $newUrl = request()->getScheme().'://'.$newHost.request()->getRequestUri();

                if (app()->environment('testing')) {
                    abort(301, '', ['Location' => $newUrl]);
                }

                header("Location: $newUrl", true, 301);
                exit;
            }
        }

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['ar', 'en']);
            //                ->flags([
            //                    'ar' => asset('flags/saudi-arabia.svg'),
            //                    'en' => asset('flags/usa.svg'),
            //                ])
        });

        TranslatableTabs::configureUsing(function (TranslatableTabs $component) {
            $component
                // locales labels
                ->localesLabels([
                    'ar' => __('arabic'),
                    'en' => __('english'),
                ])
                // default locales
                ->locales(['ar', 'en']);
        });
    }
}
