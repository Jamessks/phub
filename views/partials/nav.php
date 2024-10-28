<nav class="bg-black border-b-2 border-orange-700">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                        <a href="/"
                            class="<?= urlIs('/') ? 'bg-gray-900 text-white' : 'text-gray-300' ?> hover:bg-gray-700 px-3 py-2 rounded-md text-md font-medium">Home</a>
                        <a href="/pornstars/list"
                            class="<?= urlIs('/pornstars/list') ? 'bg-gray-900 text-white' : 'text-gray-300' ?> hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-md font-medium">Pornstars</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="md:hidden" id="mobile-menu">
        <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
            <a href="/"
                class="<?= urlIs('/') ? 'bg-gray-900 text-white' : 'text-gray-300' ?> hover:bg-gray-700 px-3 py-2 rounded-md text-md font-medium">Home</a>
            <a href="/pornstars/list"
                class="<?= urlIs('/pornstars/list') ? 'bg-gray-900 text-white' : 'text-gray-300' ?> hover:bg-gray-700 px-3 py-2 rounded-md text-md font-medium">Pornstars</a>
        </div>
    </div>
</nav>