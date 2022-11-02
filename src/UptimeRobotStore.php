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
        0 => ['bg-blue-200', 'text-blue-700'],
        1 => ['bg-gray-200', 'text-gray-800'],
        2 => ['bg-green-200', 'text-green-700'],
        8 => ['bg-red-100', 'text-red-700'],
        9 => ['bg-red-200', 'text-red-900']
    ];

    public array $monitorSortOrder = [
        '❌ Down' => [],
        '❓ Seems down' => [],
        '❔ Not checked yet' => [],
        '⏸ Paused' => [],
        '✔ Up' => []
    ];

    public static function make()
    {
        return new static();
    }

    public function __construct()
    {
        $this->tile = Tile::firstOrCreateForName("uptimeRobot");
    }

    public function setMonitors(array $monitorSortOrder): self
    {
        $this->tile->putData('monitors', $monitorSortOrder);

        return $this;
    }

    public function monitors(): array
    {
        $monitors = collect($this->tile->getData('monitors'));
        $monitorTypes = config('dashboard.tiles.uptimerobot.monitor_types');

        if (!empty(config('dashboard.tiles.uptimerobot.monitors'))) {
            $monitors = $monitors->filter(function ($item, $key) {
                return in_array($item['id'], config('dashboard.tiles.uptimerobot.monitors'));
            });
        }

        return $monitors->map(function ($item, $key) use ($monitorTypes) {
            $item['badge'] = $this->badges[$item['status']];
            $item['status'] = $this->statuses[$item['status']];
            $item['monitor_type'] = $monitorTypes[$item['type']];
            return $item;
        })->toArray() ?? [];
    }

    public function monitorsByStatus(): array
    {
        $monitors = collect($this->tile->getData('monitors'));
        $monitorTypes = config('dashboard.tiles.uptimerobot.monitor_types');

        if (!empty(config('dashboard.tiles.uptimerobot.monitors'))) {
            $monitors = $monitors->filter(function ($item, $key) {
                return in_array($item['id'], config('dashboard.tiles.uptimerobot.monitors'));
            });
        }

        foreach ($monitors as $monitor) {
            $monitor['badge'] = $this->badges[$monitor['status']];
            $monitor['status'] = $this->statuses[$monitor['status']];
            $monitor['monitor_type'] = $monitorTypes[$monitor['type']];
            $this->monitorSortOrder[$monitor['status']][] = $monitor;
        }

        return $this->monitorSortOrder;
    }
}
