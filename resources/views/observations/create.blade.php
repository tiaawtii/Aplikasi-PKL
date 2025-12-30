<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Data Observasi Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Form Input Data --}}
                    <form method="POST" action="{{ route('observations.store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- BAGIAN 1: INFORMASI PEKERJAAN --}}
                        <div class="mb-6 border-b pb-4">
                            <h3 class="text-lg font-bold text-gray-700 mb-4">1. Data Umum Pekerjaan</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Jenis Pekerjaan</label>
                                    <input type="text" name="jenis_pekerjaan" 
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" 
                                        required value="{{ old('jenis_pekerjaan') }}">
                                    @error('jenis_pekerjaan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                                
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Unit Pekerjaan</label>
                                    <select name="work_unit_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                                        <option value="">-- Pilih Unit Pekerjaan --</option>
                                        @foreach($workUnits as $unit)
                                            <option value="{{ $unit->id }}" {{ old('work_unit_id') == $unit->id ? 'selected' : '' }}>
                                                {{ $unit->nama_unit }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('work_unit_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                                
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Lokasi Pekerjaan</label>
                                    <input type="text" name="lokasi_pekerjaan" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required value="{{ old('lokasi_pekerjaan') }}">
                                    @error('lokasi_pekerjaan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Tanggal</label>
                                    @php $today = date('Y-m-d'); @endphp
                                    <input type="date" name="tanggal" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required value="{{ old('tanggal', $today) }}" min="{{ $today }}">
                                    @error('tanggal') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div> 
                                    <label class="block font-medium text-sm text-gray-700">Perusahaan Pelaksana</label>
                                    <select name="company_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                                        <option value="">-- Pilih Perusahaan --</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                                [{{ $company->kode_perusahaan }}] {{ $company->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('company_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Waktu</label>
                                    <input type="time" name="waktu" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required value="{{ old('waktu') }}">
                                    @error('waktu') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- BAGIAN 2: PERSONEL --}}
                        <div class="mb-6 border-b pb-4">
                            <h3 class="text-lg font-bold text-gray-700 mb-4">2. Personel</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Nama Personel Diobservasi</label>
                                    <input type="text" name="nama_personel_diobservasi" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required value="{{ old('nama_personel_diobservasi') }}">
                                    @error('nama_personel_diobservasi') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Nama Observer (Pengamat K3LK)</label>
                                    <select name="k3lk_employee_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                                        <option value="">-- Pilih Observer --</option>
                                        @foreach($observers as $observer)
                                            <option value="{{ $observer->id }}" {{ old('k3lk_employee_id') == $observer->id ? 'selected' : '' }}>
                                                {{ $observer->nama_pegawai }} ({{ $observer->jabatan }}) {{-- PERUBAHAN DI SINI: MENAMPILKAN JABATAN --}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('k3lk_employee_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- BAGIAN 3: KELENGKAPAN DOKUMEN --}}
                        <div class="mb-6 border-b pb-4">
                            <h3 class="text-lg font-bold text-gray-700 mb-4">3. Kelengkapan Dokumen</h3>
                            
                            <div class="flex items-center gap-4 mb-4">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="dokumen_tersedia[]" value="WP" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ is_array(old('dokumen_tersedia')) && in_array('WP', old('dokumen_tersedia')) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-700">WP</span>
                                </label>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-700 uppercase">NOMOR WP:</span>
                                    <input type="text" name="no_wp" value="{{ old('no_wp') }}" placeholder="Masukkan nomor..." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm py-1 w-48">
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-6 mb-6">
                                @foreach(['SOP', 'JSA', 'IK', 'IBPPR'] as $doc)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="dokumen_tersedia[]" value="{{ $doc }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ is_array(old('dokumen_tersedia')) && in_array($doc, old('dokumen_tersedia')) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">{{ $doc }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <div class="mb-4">
                                <label class="block font-medium text-sm text-gray-700">Upload Bukti Dokumen</label>
                                <input type="file" name="bukti_dokumen" class="block w-64 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 mt-1">
                                @error('bukti_dokumen') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">Catatan Umum</label>
                                <textarea name="catatan" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('catatan') }}</textarea>
                                @error('catatan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- BAGIAN 4: HASIL OBSERVASI --}}
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-gray-700 mb-4">4. Hasil Observasi</h3>

                            <div class="mb-4">
                                <span class="text-gray-700 font-medium block mb-2 text-sm">Apakah pekerjaan dilakukan dengan aman sesuai standar keselamatan kerja?</span>
                                <div class="flex space-x-6">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="dokumen_dilaksanakan_baik" value="Ya" class="form-radio text-green-600 focus:ring-green-500 h-4 w-4" required {{ old('dokumen_dilaksanakan_baik') == 'Ya' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Ya (Aman)</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="dokumen_dilaksanakan_baik" value="Tidak" class="form-radio text-red-600 focus:ring-red-500 h-4 w-4" required {{ old('dokumen_dilaksanakan_baik') == 'Tidak' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Tidak (Tidak Aman)</span>
                                    </label>
                                </div>
                                @error('dokumen_dilaksanakan_baik') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Catatan Unsafe Actions / Conditions</label>
                                    <textarea name="unsafe_actions_conditions" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('unsafe_actions_conditions') }}</textarea>
                                    @error('unsafe_actions_conditions') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                                
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Rekomendasi Perbaikan</label>
                                    <textarea name="rekomendasi_perbaikan" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('rekomendasi_perbaikan') }}</textarea>
                                    @error('rekomendasi_perbaikan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <span class="text-gray-700 font-medium text-sm block mb-1">Review Bersama Pekerja?</span>
                                <div class="flex space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="review_bersama_pekerja" value="Ya" class="form-radio text-indigo-600 h-4 w-4" {{ old('review_bersama_pekerja') == 'Ya' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Ya</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="review_bersama_pekerja" value="Tidak" class="form-radio text-indigo-600 h-4 w-4" {{ old('review_bersama_pekerja') == 'Tidak' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Tidak</span>
                                    </label>
                                </div>
                                @error('review_bersama_pekerja') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror

                                <div id="foto_review_container" class="mt-2" style="display: none;">
                                    <label class="block font-medium text-xs text-gray-600 italic">Upload Bukti Foto Review</label>
                                    <input type="file" name="foto_review" class="block w-64 text-sm text-gray-500 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:bg-gray-100 mt-1">
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block font-medium text-sm text-gray-700">Review yang disampaikan (Bila ada)</label>
                                <textarea name="review_disampaikan" rows="2" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('review_disampaikan') }}</textarea>
                                @error('review_disampaikan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 transition ease-in-out duration-150">
                                {{ __('Simpan Data Observasi') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const timeInput = document.querySelector('input[name="waktu"]');
        if (timeInput && !timeInput.value) {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            timeInput.value = `${hours}:${minutes}`;
        }

        const radioButtons = document.querySelectorAll('input[name="review_bersama_pekerja"]');
        const container = document.getElementById('foto_review_container');

        function toggleUpload() {
            const selected = document.querySelector('input[name="review_bersama_pekerja"]:checked');
            if (selected && selected.value === 'Ya') {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        }

        radioButtons.forEach(radio => radio.addEventListener('change', toggleUpload));
        toggleUpload(); 
    });
    </script>
</x-app-layout>