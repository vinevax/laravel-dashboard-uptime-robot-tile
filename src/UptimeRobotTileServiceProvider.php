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

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/dashboard-uptime-robot-tile'),
        ], 'dashboard-uptime-robot-tile-views');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'dashboard-uptime-robot-tile');
    }
}
