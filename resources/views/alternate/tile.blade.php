<x-dashboard-tile :position="$position" refresh-interval="60">
    <style>
        .uptime-card {
            font-size: .6rem;
            overflow: hidden;
            border-radius: 0.25rem;
            font-weight: bolder;
            margin: 10px 0;
            display: block;
            width: 90%
        }
        /* custom scrollbar */
        .card-scrollbar {
            overflow: auto;
        }
        .card-scrollbar::-webkit-scrollbar {
            width: 15px;
        }
        .card-scrollbar::-webkit-scrollbar-track {
            background-color: transparent;
        }
        .card-scrollbar::-webkit-scrollbar-thumb {
            background-color: var(--color-accent); /** from tailwind **/
            border-radius: 20px;
            border: 6px solid transparent;
            background-clip: content-box;
        }
        .card-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: #a8bbbf;
        }
    </style>
    <script>
        let uptime_monitors = @json($monitors);
        document.addEventListener('alpine:init', () => {
            Alpine.store('monitors', {
                addBadgeClasses(el, badge) {
                    badge.forEach((css_class) => {
                        el.classList.add(css_class);
                    });
                }
            });
        });
    </script>

    <div>
        <div style="height:70vh;"
             x-data="{monitors: uptime_monitors}">
            <template x-for="monitor_states in monitors">
                <div x-show="(monitor_states.length > 0)"
                     class="grid grid-cols-7 card-scrollbar">
                    <template x-for="monitor in monitor_states"
                              x-init="console.log((monitor_states.length > 0))">
                        <div class="uptime-card">
                            <div class="text-xs grid grid-cols-2"
                                 x-init="$store.monitors.addBadgeClasses($el, monitor.badge)">
                                <div class="pl-2 col-span-1"
                                     x-text="monitor.status"
                                ></div>
                                @if (config('dashboard.tiles.uptimerobot.uptime') === 1)
                                    <div class="text-gray-900 text-xs text-right pr-1"
                                         x-text="Number(monitor.all_time_uptime_ratio).toFixed(2) + '% up'">
                                    </div>
                                @endif
                            </div>
                            <div class="bg-neutral-100 text-xs grid grid-cols-4">
                                <div class="text-gray-900 bg-neutral-100 text-left pl-2 text-truncate col-span-3"
                                     x-text="monitor.friendly_name">
                                </div>
                                <div class="text-gray-900 bg-neutral-100 text-right pr-2 text-truncate col-span-1"
                                     x-text="monitor.monitor_type">
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>
</x-dashboard-tile>
