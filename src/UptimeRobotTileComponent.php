<?php

namespace VineVax\UptimeRobotTile;

use Livewire\Component;

class UptimeRobotTileComponent extends Component
{
    /** @var string */
    public $position;

    public function mount(string $position)
    {
        $this->position = $position;
    }

    public function render()
    {
        $uptimeRobotStore = UptimeRobotStore::make();

        if (config('dashboard.tiles.uptimerobot.blade') === 'original') {
            $monitors = $uptimeRobotStore->monitors();
        } else {
            $monitors = $uptimeRobotStore->monitorsByStatus();
        }

        return view('dashboard-uptime-robot-tile::tile', [
            'monitors' => $monitors
        ]);
    }
}
