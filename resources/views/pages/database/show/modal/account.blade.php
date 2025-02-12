<!-- Main modal -->
<div id="modal-account" tabindex="-1" aria-hidden="true"
    class="hidden flex justify-center items-center fixed top-0 left-0 right-0 z-50  w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="fixed top-0 left-0 right-0 bottom-0 bg-black opacity-50"></div>
    <div class="relative w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-2xl shadow">
            <button type="button" onclick="modalAccount()"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                data-modal-hide="modal-account">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="px-6 py-6 lg:px-8">
                <div class="space-y-1 mb-3">
                    <h3 class="text-lg font-bold text-gray-900">Buat Akun Baru</h3>
                    <p class="text-sm text-gray-600">Berikut ini adalah menu untuk membuat akun baru.</p>
                </div>
                <hr class="mb-3">
                <form class="space-y-4" action="{{ route('profile.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="identity" value="{{ $user->identity }}">
                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="gender" value="{{ $user->gender || 1 }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 md:gap-3">
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <i class="fa-solid fa-envelope text-gray-500"></i>
                                </div>
                                <input type="email" name="email" maxlength="50"  id="email" value="{{ $user->email }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Alamat Email"
                                    required>
                            </div>
                        </div>
                        <div>
                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">No. Whatsapp</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <i class="fa-brands fa-whatsapp text-gray-500"></i>
                                </div>
                                <input type="number" name="phone" maxlength="14" id="phone" value="{{ $user->phone }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="No. Whatsapp"
                                    required>
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Buat Akun Sekarang!</button>
                    <p class="text-xs text-gray-600 text-center">Periksa terlebih dahulu apakah sudah benar?</p>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function() {
        let phone = phoneInput.value;
        
        if (phone.length > 14) {
            phone = phone.substring(0, 14);
        }
        
        if (phone.startsWith("62")) {
            if (phone.length === 3 && (phone[2] === "0" || phone[2] !== "8")) {
                phoneInput.value = '62';
            } else {
                phoneInput.value = phone;
            }
        } else if (phone.startsWith("0")) {
            phoneInput.value = '62' + phone.substring(1);
        } else {
            phoneInput.value = '62';
        }
    });

    const saveChanges = () => {
        const form = document.getElementById('formChanges');
        form.submit();
    }
</script>
