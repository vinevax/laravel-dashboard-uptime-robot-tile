<?php

namespace VineVax\UptimeRobotTile\Services;

use Illuminate\Support\Facades\Http;

class UptimeRobot
{
    public const url = 'https://api.uptimerobot.com/v2/';

    public static function getMonitors(string $apiKey) : array
    {
        return Http::post(self::url . 'getMonitors', [
            'api_key' => $apiKey,
            'all_time_uptime_ratio' => 1
        ])->json()['monitors'];
    }
}
