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
        $this->app->bind(
            \Filament\Livewire\DatabaseNotifications::class,
            \App\Livewire\CustomDatabaseNotifications::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        \Livewire\Livewire::component('database-notifications', \App\Livewire\CustomDatabaseNotifications::class);

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
