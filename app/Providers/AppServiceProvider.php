<?php

namespace App\Providers;

use App\Support\Enums\Rank;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // TODO: move this somewhere else?
    public const string MAIN_GUILD = 'Exalted';

    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (App::isLocal()) {
            FilamentView::registerRenderHook(
                PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
                static fn (PanelsRenderHook $panelsRenderHook) => Blade::render('<x-login-link />')
            );
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
        Model::shouldBeStrict();

        FilamentColor::register(Rank::colors());
    }
}
