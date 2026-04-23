{{-- SIDEBAR --}}
<aside id="top-bar-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-full pt-20 transition-transform -translate-x-full bg-neutral-primary-soft border-e border-default dark:border-default-medium sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto">
        <ul class="space-y-2 font-medium">
            @foreach ($verticalMenu ?? [] as $menu)
                @php
                    $isActive = request()->routeIs($menu['route']);

                    if ($menu['route'] === 'ticket.index' && !$isActive) {
                        $isActive = request()->routeIs('ticket.show');
                    }

                @endphp
                <li>
                    <a href="{{ route($menu['route']) }}"
                        class="flex items-center p-2 rounded-base group transition-colors {{ $isActive ? 'bg-neutral-secondary-medium text-heading' : 'text-body hover:bg-neutral-secondary-medium hover:text-heading' }}">

                        <div class="w-6 h-6 flex items-center justify-center shrink-0">
                            <i
                                class="{{ $menu['icon'] }} text-xl transition duration-75 {{ $isActive ? 'text-heading' : 'text-neutral-tertiary-medium group-hover:text-heading' }}"></i>
                        </div>

                        <span class="ms-3">{{ $menu['name'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</aside>
