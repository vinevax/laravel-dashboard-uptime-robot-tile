<?php

namespace VineVax\UptimeRobotTile\Commands;

use Illuminate\Console\Command;
use VineVax\UptimeRobotTile\Services\UptimeRobot;
use VineVax\UptimeRobotTile\UptimeRobotStore;

class FetchUptimeRobotDataCommand extends Command
{
    protected $signature = 'dashboard:fetch-uptime-robot-data';

    protected $description = 'Fetch Uptime Robot data';

    public function handle()
    {
        $montiors = UptimeRobot::getMonitors(
            config('dashboard.tiles.uptimerobot.key'),
            config('dashboard.tiles.uptimerobot.uptime')
        );

        UptimeRobotStore::make()->setMonitors($montiors);

        $this->info('All done!');
    }
}
