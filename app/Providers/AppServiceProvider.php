<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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

        Arr::macro('mapKeys', function (array $array, callable $callback) {
            return Arr::mapWithKeys(
                $array,
                fn ($value, $key) => [$callback($key, $value) => $value]
            );
        });

        Arr::macro('mapKeysRecursively', function (array $array, callable $callback) {
            return Arr::mapWithKeys(
                $array,
                function ($value, $key) use ($callback) {
                    if (is_array($value)) {
                        return [$callback($key, $value) => Arr::mapKeysRecursively($value, $callback)];
                    }

                    return [$callback($key, $value) => $value];
                }
            );
        });
    }
}
