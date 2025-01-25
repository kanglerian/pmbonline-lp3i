<x-app-layout>
    <x-slot name="header">
        @include('pages.database.components.navigation')
    </x-slot>

    <main>
        @if (session('error'))
            <div id="alert" class="flex items-center p-4 mb-4 bg-red-500 text-red-50 rounded-xl" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div class="ml-3 text-sm font-reguler">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        @if (session('message'))
            <div id="alert" class="flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg" role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <div class="ml-3 text-sm font-reguler">
                    {{ session('message') }}
                </div>
            </div>
        @endif
        @if ($errors->first('berkas'))
            <div id="alert" class="flex items-center p-4 mb-4 bg-red-500 text-red-50 rounded-xl" role="alert">
                <i class="fa-solid fa-circle-xmark"></i>
                <div class="ml-3 text-sm font-reguler">
                    {{ $errors->first('berkas') }}
                </div>
            </div>
        @endif

        <section id="content">
            <div id="phone" data-phone="{{ $user->phone }}" class="flex flex-col md:flex-row gap-5" id="riwayat">
                <div class="w-full">
                    <div class="p-6">
                        @forelse ($events as $event)
                            <ol class="relative border-l border-gray-200">
                                <li class="mb-10 ml-4 space-y-2">
                                    <div
                                        class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -left-1.5 border border-white">
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $event->event->code }}
                                        ({{ $event->event->pmb }})
                                    </span>
                                    <div>
                                        <h3 class="text-base font-semibold text-gray-900">{{ $event->event->title }}
                                        </h3>
                                        <p class="mb-4 text-sm font-normal text-gray-500">
                                            {{ $event->event->description }}</p>
                                    </div>
                                    @if ($event->comment)
                                        <p class="italic text-sm text-gray-600">"{{ $event->comment }}"</p>
                                    @else
                                        <p class="italic text-sm text-red-500">Belum ada komentar</p>
                                    @endif
                                    <div class="flex items-center gap-1">
                                        @for ($i = 0; $i < $event->rating; $i++)
                                            <i class="fa-solid fa-star text-xs text-yellow-500"></i>
                                        @endfor
                                    </div>
                                </li>
                            </ol>
                        @empty
                            <p class="mb-4 text-base font-normal text-gray-800">Belum ada kegiatan yang diikuti.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </main>

</x-app-layout>
