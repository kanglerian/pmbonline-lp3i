<section class="space-y-5">
    <header class="max-w-5xl mx-auto px-6 pt-5 space-y-1 text-center">
        <h1 class="flex flex-col text-xl items-center gap-2 font-bold text-gray-700">
            <span>Peta Data Sekolah Terdaftar di LP3I</span>
        </h1>
        <p class="text-gray-600 text-sm">Temukan sekolah-sekolah yang telah terdata dengan LP3I dalam peta interaktif ini. Data lengkap dan terkini akan memandu Anda dalam melihat sebaran sekolah yang telah terdata.</p>
    </header>
    <div class="max-w-7xl px-5 mx-auto space-y-5">
        <section>
            <div>
                <div id="map-school" class="rounded-3xl border border-gray-300"></div>
            </div>
        </section>
    </div>
</section>
@push('scripts')
    <script>
        let urlSchoolMap = `/api/school/getall`;
        let mapSchool = L.map('map-school').setView([-6.618, 107.282], 8);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://politekniklp3i-tasikmalaya.ac.id">Politeknik LP3I Kampus Tasikmalaya</a>'
        }).addTo(mapSchool);
    </script>
    <script>
        const getSchoolMap = async () => {
            const response = await axios.get(urlSchoolMap);
            let schools = response.data.schools;
            
            schools.forEach((result) => {
                const lat = result.lat ?? -6.618;
                const lng = result.lng ?? 107.282;
                const marker = L.marker([lat, lng]).addTo(mapSchool);
                const paragraph = `<b>${result.name}</b>`;
                
                marker.bindPopup(paragraph).openPopup();

                const circle = L.circle([lat, lng], {
                    color: 'red',
                    fillColor: '#f03',
                    fillOpacity: 0.5,
                    radius: 80
                }).addTo(mapSchool);
            });
        }
        getSchoolMap();
    </script>
@endpush
