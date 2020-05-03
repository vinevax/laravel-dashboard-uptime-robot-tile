<?php

namespace VineVax\UptimeRobotTile;

use Spatie\Dashboard\Models\Tile;

class UptimeRobotStore
{
    private Tile $tile;

    private array $statuses = [
        0 => '⏸ Paused',
        1 => '❔ Not checked yet',
        2 => '✔ Up',
        8 => '❓ Seems down',
        9 => '❌ Down'
    ];

    private array $badges = [
        0 => 'bg-blue-200 text-blue-700',
        1 => 'bg-gray-200 text-gray-800',
        2 => 'bg-green-200 text-green-700',
        8 => 'bg-red-100 text-red-700',
        9 => 'bg-red-200 text-red-900'
    ];

    public static function make()
    {
        return new static();
    }

    public function __construct()
    {
        $this->tile = Tile::firstOrCreateForName("uptimeRobot");
    }

    public function setMonitors(array $monitors): self
    {
        $this->tile->putData('monitors', $monitors);

        return $this;
    }

    public function monitors(): array
    {
        $monitors = collect($this->tile->getData('monitors'));

        if (!empty(config('dashboard.tiles.uptimerobot.monitors'))) {
            $monitors = $monitors->filter(function ($item, $key) {
                return in_array($item['id'], config('dashboard.tiles.uptimerobot.monitors'));
            });
        }

        return $monitors->map(function ($item, $key) {
            $item['badge'] = $this->badges[$item['status']];
            $item['status'] = $this->statuses[$item['status']];
            return $item;
        })->toArray() ?? [];
    }
}
