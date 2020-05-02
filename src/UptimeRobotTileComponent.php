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

        return view('dashboard-uptime-robot-tile::tile', [
            'monitors' => $uptimeRobotStore->monitors()
        ]);
    }
}
