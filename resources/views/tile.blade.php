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
        <div class="grid grid-cols-7 card-scrollbar"
             style="height:70vh;"
             x-data="{monitors: uptime_monitors}">
            <template x-for="monitor in monitors">
                <div class="uptime-card">
                    <div class="text-xs grid grid-cols-2"
                         x-init="$store.monitors.addBadgeClasses($el, monitor.badge)">
                        <div class="pl-2 col-span-1"
                             x-text="monitor.status"
                        ></div>
                        <div class="text-gray-900 text-xs text-right pr-1"
                             x-text="Number(monitor.all_time_uptime_ratio).toFixed(2) + '% up'">
                        </div>
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

    </div>
</x-dashboard-tile>
