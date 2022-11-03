<?php

namespace VineVax\UptimeRobotTile;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use VineVax\UptimeRobotTile\Commands\FetchUptimeRobotDataCommand;

class UptimeRobotTileServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Livewire::component('uptime-robot-tile', UptimeRobotTileComponent::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                FetchUptimeRobotDataCommand::class,
            ]);
        }

        $resourcePath = __DIR__ . '/../resources/views/';

        if (config('dashboard.tiles.uptimerobot.blade') === 'original') {
            $resourcePath .= 'original';
        } else {
            $resourcePath .= 'alternate';
        }

        $this->publishes([
            $resourcePath . '/' => resource_path('views/vendor/dashboard-uptime-robot-tile'),
        ], 'dashboard-uptime-robot-tile-views');

        $this->loadViewsFrom($resourcePath, 'dashboard-uptime-robot-tile');
    }
}
