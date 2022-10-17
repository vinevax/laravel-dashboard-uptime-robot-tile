<?php

namespace VineVax\UptimeRobotTile\Commands;

use Illuminate\Console\Command;
use VineVax\UptimeRobotTile\Services\UptimeRobot;
use VineVax\UptimeRobotTile\UptimeRobotStore;

class FetchUptimeRobotDataCommand extends Command
{
    protected string $signature = 'dashboard:fetch-uptime-robot-data';

    protected string $description = 'Fetch Uptime Robot data';

    public function handle()
    {
        $montiors = UptimeRobot::getMonitors(
            config('dashboard.tiles.uptimerobot.key')
        );

        UptimeRobotStore::make()->setMonitors($montiors);

        $this->info('All done!');
    }
}
