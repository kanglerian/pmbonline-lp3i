<nav x-data="{ open: false }" class="bg-gray-50 py-3">
    <!-- Primary Navigation Menu -->
    <div class="w-full max-w-7xl mx-auto px-5 md:px-0">
        <div class="flex items-center justify-between h-16 py-3">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard.index') }}">
                        <img src="{{ asset('img/lp3i-logo.svg') }}" alt="Politeknik LP3I Kampus Tasikmalaya"
                            class="w-40 text-center">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-5 sm:-my-px sm:ml-10 sm:flex overflow-x-auto">
                    <x-nav-link :href="route('dashboard.index')" :active="request()->routeIs([
                        'dashboard.index',
                        'dashboard.rekapitulasi_perolehan_pmb_page',
                        'dashboard.rekapitulasi_history',
                        'dashboard.rekapitulasi_database',
                        'dashboard.rekapitulasi_perolehan_pmb',
                        'dashboard.rekapitulasi_register_program',
                        'dashboard.rekapitulasi_aplikan',
                        'dashboard.rekapitulasi_persyaratan',
                        'dashboard.rekapitulasi_register_school',
                        'dashboard.rekapitulasi_register_school_year',
                        'dashboard.rekapitulasi_register_source',
                        'dashboard.rekapitulasi_pencapaian_pmb',
                        'profile.edit',
                    ])">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @if ((Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'P') || Auth::user()->role == 'A')
                        <x-nav-link :href="route('database.index')" :active="request()->routeIs([
                            'database.index',
                            'database.create',
                            'database.edit',
                            'database.show',
                            'database.chat',
                            'database.file',
                            'database.scholarship',
                            'database.achievement',
                            'database.organization',
                            'recommendation.index',
                            'recommendation.edit',
                        ])">
                            {{ __('Databases') }}
                        </x-nav-link>
                    @endif
                    @if (Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'A')
                        <x-nav-link :href="route('payment.index')" :active="request()->routeIs([
                            'payment.index',
                            'payment.create',
                            'payment.edit',
                            'payment.show',
                            'enrollment.index',
                            'registration.index',
                        ])">
                            {{ __('Payments') }}
                        </x-nav-link>
                    @endif
                    @if (Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'A')
                        <x-nav-link :href="route('schools.index')" :active="request()->routeIs([
                            'schools.index',
                            'schools.create',
                            'schools.edit',
                            'schools.show',
                            'schools.setting'
                        ])">
                            {{ __('Schools') }}
                        </x-nav-link>
                    @endif
                    @if (Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'A')
                        <x-nav-link :href="route('presenters.index')" :active="request()->routeIs([
                            'presenters.index',
                            'presenters.create',
                            'presenters.edit',
                            'presenters.show',
                            'presenters.sales_volume',
                            'presenters.sales_revenue',
                            'presenters.sales_database',
                        ])">
                            {{ __('Presenters') }}
                        </x-nav-link>
                    @endif
                    @if (Auth::check() && Auth::user()->status == '1' && (Auth::user()->role == 'P' || Auth::user()->role == 'A'))
                        <x-nav-link :href="route('question.index')" :active="request()->routeIs(['question.index', 'scholarship.index', 'scholarship.question'])">
                            {{ __('Assessments') }}
                        </x-nav-link>
                    @endif
                    @if (Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'A')
                        <x-nav-link :href="route('user.index')" :active="request()->routeIs(['user.index', 'user.create', 'user.edit'])">
                            {{ __('Accounts') }}
                        </x-nav-link>
                    @endif
                    @if (Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'A')
                        <x-nav-link :href="route('setting.index')" :active="request()->routeIs([
                            'setting.index',
                            'applicantstatus.index',
                            'applicantstatus.create',
                            'applicantstatus.edit',
                            'followup.index',
                            'followup.create',
                            'followup.edit',
                            'programtype.index',
                            'programtype.create',
                            'programtype.edit',
                            'source.index',
                            'source.create',
                            'source.edit',
                            'fileupload.index',
                            'fileupload.create',
                            'fileupload.edit',
                        ])">
                            {{ __('Settings') }}
                        </x-nav-link>
                    @endif
                    @if (Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'S')
                        <x-nav-link :href="route('userupload.edit', Auth::user()->identity)" :active="request()->routeIs(['userupload.index', 'userupload.create', 'userupload.edit'])">
                            {{ __('Upload Berkas') }}
                        </x-nav-link>
                        <x-nav-link :href="route('recommendation.show', Auth::user()->identity)" :active="request()->routeIs([
                            'recommendation.index',
                            'recommendation.show',
                            'recommendation.create',
                        ])">
                            {{ __('Rekomendasi ✨') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex overflow-hidden gap-3 rounded-lg items-center text-sm font-medium text-gray-500 focus:outline-none transition duration-150 ease-in-out">
                            @if (Auth::user()->avatar)
                                <img src="https://uploadhub.politekniklp3i-tasikmalaya.ac.id/download?identity={{ Auth::user()->identity }}&filename={{ Auth::user()->identity }}-{{ Auth::user()->avatar }}"
                                    alt="Avatar" class="h-10 rounded-full">
                            @else
                                @if (Auth::user()->gender)
                                    <img src="{{ asset('avatar/male-' . (Auth::user()->id % 2 == 0 ? '1' : '0') . '.png') }}"
                                        alt="Avatar" class="h-10 rounded-full">
                                @else
                                    <img src="{{ asset('avatar/female-' . (Auth::user()->id % 2 == 0 ? '1' : '0') . '.png') }}"
                                        alt="Avatar" class="h-10 rounded-full">
                                @endif
                            @endif
                            <div class="w-full hidden lg:flex flex-col items-start">
                                <span class="font-bold">{{ Auth::user()->name }}</span>
                                <span class="text-xs font-light">
                                    @switch(Auth::user()->role)
                                        @case('A')
                                            Administrator
                                        @break

                                        @case('P')
                                            Presenter
                                        @break

                                        @case('S')
                                            Siswa
                                        @break

                                        @case('K')
                                            Kepala Kampus
                                        @break
                                    @endswitch
                                </span>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            @if (Auth::check() && Auth::user()->status == '1')
                                <x-dropdown-link :href="route('profile.edit', Auth::user()->id)">
                                    <i class="fa-solid fa-user mr-1"></i> {{ __('Ubah Profil') }}
                                </x-dropdown-link>
                            @endif
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fa-solid fa-right-from-bracket mr-1"></i> {{ __('Keluar') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard.index')" :active="request()->routeIs([
                'dashboard.index',
                'dashboard.rekapitulasi_perolehan_pmb_page',
                'dashboard.rekapitulasi_history',
                'dashboard.rekapitulasi_database',
                'dashboard.rekapitulasi_perolehan_pmb',
                'dashboard.rekapitulasi_register_program',
                'dashboard.rekapitulasi_aplikan',
                'dashboard.rekapitulasi_persyaratan',
                'dashboard.rekapitulasi_register_school',
                'dashboard.rekapitulasi_register_school_year',
                'dashboard.rekapitulasi_register_source',
                'dashboard.rekapitulasi_pencapaian_pmb',
                'profile.edit',
            ])">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @if ((Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'P') || Auth::user()->role == 'A')
                <x-responsive-nav-link :href="route('database.index')" :active="request()->routeIs([
                    'database.index',
                    'database.create',
                    'database.edit',
                    'database.show',
                    'database.chat',
                    'database.file',
                    'database.scholarship',
                    'database.achievement',
                    'database.organization',
                ])">
                    {{ __('Database') }}
                </x-responsive-nav-link>
            @endif
            @if (Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'A')
                <x-responsive-nav-link :href="route('payment.index')" :active="request()->routeIs([
                    'payment.index',
                    'payment.create',
                    'payment.edit',
                    'payment.show',
                    'enrollment.index',
                    'registration.index',
                ])">
                    {{ __('Payments') }}
                </x-responsive-nav-link>
            @endif
            @if (Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'A')
                <x-responsive-nav-link :href="route('schools.index')" :active="request()->routeIs(['schools.index', 'schools.create', 'schools.edit', 'schools.show'])">
                    {{ __('Schools') }}
                </x-responsive-nav-link>
            @endif
            @if (Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'A')
                <x-responsive-nav-link :href="route('presenters.index')" :active="request()->routeIs([
                    'presenters.index',
                    'presenters.create',
                    'presenters.edit',
                    'presenters.show',
                    'presenters.sales_volume',
                    'presenters.sales_revenue',
                ])">
                    {{ __('Presenters') }}
                </x-responsive-nav-link>
            @endif

            @if (Auth::check() && Auth::user()->status == '1' && (Auth::user()->role == 'P' || Auth::user()->role == 'A'))
                <x-responsive-nav-link :href="route('question.index')" :active="request()->routeIs(['question.index', 'scholarship.index', 'scholarship.question'])">
                    {{ __('Assessments') }}
                </x-responsive-nav-link>
            @endif

            @if (Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'A')
                <x-responsive-nav-link :href="route('user.index')" :active="request()->routeIs(['user.index', 'user.create', 'user.edit'])">
                    {{ __('Accounts') }}
                </x-responsive-nav-link>
            @endif
            @if (Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'A')
                <x-responsive-nav-link :href="route('setting.index')" :active="request()->routeIs(['setting.index', 'setting.create', 'setting.edit', 'setting.show'])">
                    {{ __('Setting') }}
                </x-responsive-nav-link>
            @endif
            @if (Auth::check() && Auth::user()->status == '1' && Auth::user()->role == 'S')
                <x-responsive-nav-link :href="route('userupload.edit', Auth::user()->identity)" :active="request()->routeIs(['userupload.index', 'userupload.create', 'userupload.edit'])">
                    {{ __('Upload Berkas') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <a href="{{ route('profile.edit', Auth::user()->id) }}" class="block px-4 py-2 bg-gray-50">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">
                    @switch(Auth::user()->role)
                        @case('A')
                            Administrator
                        @break

                        @case('P')
                            Presenter
                        @break

                        @case('S')
                            Siswa
                        @break
                    @endswitch
                </div>
            </a>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Keluar') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
