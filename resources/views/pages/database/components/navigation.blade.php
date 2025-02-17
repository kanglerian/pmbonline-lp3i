<div class="flex flex-col md:flex-row items-center justify-between gap-5">
    <nav class="flex">
        <ol class="inline-flex items-center space-x-2 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('database.index') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                    <i class="fa-solid fa-database mr-2"></i>
                    Database
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Profil Mahasiswa</span>
                </div>
            </li>
        </ol>
    </nav>
    <div class="flex items-center justify-center flex-wrap gap-3 md:gap-5">
        <a href="{{ route('database.show', $user->identity) }}"
            class="{{ request()->segment(1) == 'database' ? 'inline-flex items-center px-1 pt-1 border-b-2 border-lp3i-100 text-sm font-medium leading-8 text-gray-900 focus:outline-none focus:border-lp3i-300 transition duration-150 ease-in-out' : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-8 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out' }} "><i
                class="fa-regular fa-id-card mr-2"></i> Profil</a>
        @if ($user->phone)
            <a href="{{ route('database.chat', $user->identity) }}"
                class="{{ request()->segment(1) == 'chat' ? 'inline-flex items-center px-1 pt-1 border-b-2 border-lp3i-100 text-sm font-medium leading-8 text-gray-900 focus:outline-none focus:border-lp3i-300 transition duration-150 ease-in-out' : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-8 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out' }}"><i
                    class="fa-regular fa-comments mr-2"></i> Chat</a>
        @endif
        <a href="{{ route('database.events', $user->identity) }}"
            class="{{ request()->segment(1) == 'eventdetail' ? 'inline-flex items-center px-1 pt-1 border-b-2 border-lp3i-100 text-sm font-medium leading-8 text-gray-900 focus:outline-none focus:border-lp3i-300 transition duration-150 ease-in-out' : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-8 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out' }}"><i
                class="fa-regular fa-calendar-days mr-2"></i> Events</a>
        <a href="{{ route('database.file', $user->identity) }}"
            class="{{ request()->segment(1) == 'file' ? 'inline-flex items-center px-1 pt-1 border-b-2 border-lp3i-100 text-sm font-medium leading-8 text-gray-900 focus:outline-none focus:border-lp3i-300 transition duration-150 ease-in-out' : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-8 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out' }}"><i
                class="fa-regular fa-folder-open mr-2"></i> Berkas</a>
        <a href="{{ route('database.scholarship', $user->identity) }}"
            class="{{ request()->segment(1) == 'scholarship' ? 'inline-flex items-center px-1 pt-1 border-b-2 border-lp3i-100 text-sm font-medium leading-8 text-gray-900 focus:outline-none focus:border-lp3i-300 transition duration-150 ease-in-out' : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-8 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out' }}"><i
                class="fa-solid fa-graduation-cap mr-2"></i> Beasiswa</a>
        <a href="{{ route('database.achievement', $user->identity) }}"
            class="{{ request()->segment(1) == 'achievement' ? 'inline-flex items-center px-1 pt-1 border-b-2 border-lp3i-100 text-sm font-medium leading-8 text-gray-900 focus:outline-none focus:border-lp3i-300 transition duration-150 ease-in-out' : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-8 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out' }}"><i
                class="fa-solid fa-trophy mr-2"></i> Prestasi
        </a>
        <a href="{{ route('database.organization', $user->identity) }}"
            class="{{ request()->segment(1) == 'organization' ? 'inline-flex items-center px-1 pt-1 border-b-2 border-lp3i-100 text-sm font-medium leading-8 text-gray-900 focus:outline-none focus:border-lp3i-300 transition duration-150 ease-in-out' : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-8 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out' }}"><i
                class="fa-solid fa-sitemap mr-2"></i> Pengalaman Organisasi
        </a>
    </div>
</div>
