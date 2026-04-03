<nav x-data="{ open: false }" class="bg-navy-900/80 backdrop-blur-md border-b border-stroke sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-gold font-bold text-xl tracking-tight">NovaVault</a>
                </div>
                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">Dashboard</x-nav-link>
                            <x-nav-link :href="route('admin.vendors')" :active="request()->routeIs('admin.vendors*')">Vendors</x-nav-link>
                            <x-nav-link :href="route('admin.patrons')" :active="request()->routeIs('admin.patrons*')">Patrons</x-nav-link>
                            <x-nav-link :href="route('admin.transactions')" :active="request()->routeIs('admin.transactions')">Transactions</x-nav-link>
                        @elseif(auth()->user()->isVendor())
                            <x-nav-link :href="route('vendor.dashboard')" :active="request()->routeIs('vendor.dashboard')">Dashboard</x-nav-link>
                            <x-nav-link :href="route('vendor.orders.index')" :active="request()->routeIs('vendor.orders*')">Orders</x-nav-link>
                            <x-nav-link :href="route('vendor.products.index')" :active="request()->routeIs('vendor.products*')">Products</x-nav-link>
                            <x-nav-link :href="route('vendor.categories.index')" :active="request()->routeIs('vendor.categories*')">Categories</x-nav-link>
                            <x-nav-link :href="route('vendor.reward-rules.index')" :active="request()->routeIs('vendor.reward-rules*')">Rewards</x-nav-link>
                            <x-nav-link :href="route('vendor.pos')" :active="request()->routeIs('vendor.pos')" class="text-gold">POS</x-nav-link>
                        @else
                            <x-nav-link :href="route('patron.dashboard')" :active="request()->routeIs('patron.dashboard')">Dashboard</x-nav-link>
                            <x-nav-link :href="route('patron.wallets')" :active="request()->routeIs('patron.wallets')">Wallets</x-nav-link>
                            <x-nav-link :href="route('patron.discover')" :active="request()->routeIs('patron.discover')">Discover</x-nav-link>
                            <x-nav-link :href="route('patron.redemptions')" :active="request()->routeIs('patron.redemptions')">Redemptions</x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-2">
                <x-theme-toggle />
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 text-sm text-gray-300 hover:text-white transition">
                                {{ Auth::user()->name }}
                                <svg class="ms-1 fill-current h-4 w-4" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">@csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white text-sm mr-4">Log in</a>
                    <a href="{{ route('register') }}" class="bg-nv-blue text-navy-950 px-4 py-2 rounded-nv-sm text-sm font-semibold">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
