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
        <div class="grid grid-cols-5 card-scrollbar"
             style="height:70vh;"
             x-data="{monitors: uptime_monitors}">
            <template x-for="monitor in monitors">
                <div class="uptime-card">
                    <div class="row-auto pl-2 text-sm"
                         x-text="monitor.status"
                         x-init="$store.monitors.addBadgeClasses($el, monitor.badge)"
                    ></div>
                    <div class="text-gray-900 bg-neutral-100 text-sm text-left pl-1 text-truncate"
                         x-text="monitor.friendly_name">
                    </div>
                    <div class="text-gray-900 bg-neutral-100 text-sm text-right pr-1"
                         x-text="Number(monitor.all_time_uptime_ratio).toFixed(2) + '% uptime'">
                    </div>
                </div>
            </template>
        </div>

    </div>
</x-dashboard-tile>
