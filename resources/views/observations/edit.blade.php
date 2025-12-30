<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Observasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Form Edit Data --}}
                    <form method="POST" action="{{ route('observations.update', $observation->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') 

                        {{-- BAGIAN 1: INFORMASI PEKERJAAN --}}
                        <div class="mb-6 border-b pb-4">
                            <h3 class="text-lg font-bold text-gray-700 mb-4">1. Data Umum Pekerjaan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Jenis Pekerjaan</label>
                                    <input type="text" name="jenis_pekerjaan" 
                                        value="{{ old('jenis_pekerjaan', $observation->jenis_pekerjaan) }}" 
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" 
                                        required>
                                    @error('jenis_pekerjaan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                                
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Unit Pekerjaan</label>
                                    <select name="work_unit_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                                        @foreach($workUnits as $unit)
                                            <option value="{{ $unit->id }}" {{ old('work_unit_id', $observation->work_unit_id) == $unit->id ? 'selected' : '' }}>{{ $unit->nama_unit }}</option>
                                        @endforeach
                                    </select>
                                    @error('work_unit_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Lokasi Pekerjaan</label>
                                    <input type="text" name="lokasi_pekerjaan" value="{{ old('lokasi_pekerjaan', $observation->lokasi_pekerjaan) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                                    @error('lokasi_pekerjaan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Tanggal</label>
                                    @php $formattedDate = $observation->tanggal ? \Carbon\Carbon::parse($observation->tanggal)->format('Y-m-d') : ''; @endphp
                                    <input type="date" name="tanggal" value="{{ old('tanggal', $formattedDate) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                                    @error('tanggal') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>
                                
                                <div> 
                                    <label class="block font-medium text-sm text-gray-700">Perusahaan Pelaksana</label>
                                    <select name="company_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}" {{ (old('company_id', $observation->company_id) == $company->id) ? 'selected' : '' }}>[{{ $company->kode_perusahaan }}] {{ $company->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('company_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Waktu</label>
                                    <input type="time" name="waktu" value="{{ old('waktu', $observation->waktu) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
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
                                    <input type="text" name="nama_personel_diobservasi" value="{{ old('nama_personel_diobservasi', $observation->nama_personel_diobservasi) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                                    @error('nama_personel_diobservasi') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Nama Observer (Pengamat K3LK)</label>
                                    <select name="k3lk_employee_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1" required>
                                        <option value="">-- Pilih Observer --</option>
                                        @foreach($observers as $obs)
                                            {{-- PERUBAHAN DI SINI: MENAMPILKAN JABATAN --}}
                                            <option value="{{ $obs->id }}" {{ old('k3lk_employee_id', $observation->k3lk_employee_id) == $obs->id ? 'selected' : '' }}>
                                                {{ $obs->nama_pegawai }} ({{ $obs->jabatan }})
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
                            @php $docs = json_decode($observation->dokumen_tersedia, true) ?? []; @endphp

                            {{-- Baris WP & No WP Sejajar Ramping --}}
                            <div class="flex items-center gap-4 mb-4">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="dokumen_tersedia[]" value="WP" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ in_array('WP', old('dokumen_tersedia', $docs)) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-700">WP</span>
                                </label>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-700 uppercase">NOMOR WP:</span>
                                    <input type="text" name="no_wp" value="{{ old('no_wp', $observation->no_wp) }}" placeholder="Masukkan nomor..." class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm py-1 w-48">
                                </div>
                            </div>

                            {{-- Baris Dokumen Lainnya Sejajar --}}
                            <div class="flex flex-wrap gap-6 mb-6">
                                @foreach(['SOP', 'JSA', 'IK', 'IBPPR'] as $doc)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="dokumen_tersedia[]" value="{{ $doc }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ in_array($doc, old('dokumen_tersedia', $docs)) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">{{ $doc }}</span>
                                    </label>
                                @endforeach
                            </div>

                            {{-- Upload Foto Ringkas (w-64) --}}
                            <div class="mb-4">
                                <label class="block font-medium text-sm text-gray-700">Ganti Bukti Dokumen (Opsional)</label>
                                <input type="file" name="bukti_dokumen" class="block w-64 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 mt-1">
                                @if($observation->bukti_dokumen_path)
                                    <p class="mt-2 text-xs text-gray-500 italic">File saat ini: <a href="{{ asset('storage/' . $observation->bukti_dokumen_path) }}" target="_blank" class="text-indigo-600 underline">Lihat Foto</a></p>
                                @endif
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700">Catatan Umum</label>
                                <textarea name="catatan" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('catatan', $observation->catatan) }}</textarea>
                            </div>
                        </div>

                        {{-- BAGIAN 4: HASIL OBSERVASI --}}
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-gray-700 mb-4">4. Hasil Observasi</h3>
                            <div class="mb-4">
                                <span class="text-gray-700 font-medium block mb-2 text-sm">Apakah pekerjaan dilakukan dengan aman sesuai standar keselamatan kerja?</span>
                                <div class="flex space-x-6">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="dokumen_dilaksanakan_baik" value="Ya" class="form-radio text-green-600 h-4 w-4" {{ old('dokumen_dilaksanakan_baik', $observation->dokumen_dilaksanakan_baik) == 'Ya' ? 'checked' : '' }} required>
                                        <span class="ml-2 text-sm text-gray-700">Ya (Aman)</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="dokumen_dilaksanakan_baik" value="Tidak" class="form-radio text-red-600 h-4 w-4" {{ old('dokumen_dilaksanakan_baik', $observation->dokumen_dilaksanakan_baik) == 'Tidak' ? 'checked' : '' }} required>
                                        <span class="ml-2 text-sm text-gray-700">Tidak (Tidak Aman)</span>
                                    </label>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Catatan Unsafe Actions / Conditions</label>
                                    <textarea name="unsafe_actions_conditions" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('unsafe_actions_conditions', $observation->unsafe_actions_conditions) }}</textarea>
                                </div>
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Rekomendasi Perbaikan</label>
                                    <textarea name="rekomendasi_perbaikan" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('rekomendasi_perbaikan', $observation->rekomendasi_perbaikan) }}</textarea>
                                </div>
                            </div>

                            <div class="mt-4">
                                <span class="text-gray-700 font-medium text-sm block mb-1">Review Bersama Pekerja?</span>
                                <div class="flex space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="review_bersama_pekerja" value="Ya" class="form-radio text-indigo-600 h-4 w-4" {{ old('review_bersama_pekerja', $observation->review_bersama_pekerja) == 'Ya' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Ya</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="review_bersama_pekerja" value="Tidak" class="form-radio text-indigo-600 h-4 w-4" {{ old('review_bersama_pekerja', $observation->review_bersama_pekerja) == 'Tidak' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Tidak</span>
                                    </label>
                                </div>
                                <div id="foto_review_container" class="mt-2" style="display: none;">
                                    <label class="block font-medium text-xs text-gray-600 italic">Upload Bukti Foto Review</label>
                                    <input type="file" name="foto_review" class="block w-64 text-sm text-gray-500 file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:bg-gray-100 mt-1">
                                    @if($observation->foto_review_path)
                                        <p class="mt-1 text-xs text-gray-500 italic">Evidence saat ini: <a href="{{ asset('storage/' . $observation->foto_review_path) }}" target="_blank" class="text-indigo-600 underline">Lihat Foto</a></p>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block font-medium text-sm text-gray-700">Review yang disampaikan (Bila ada)</label>
                                <textarea name="review_disampaikan" rows="2" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('review_disampaikan', $observation->review_disampaikan) }}</textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('observations.index') }}" class="mr-4 text-gray-600 hover:text-gray-900 font-semibold text-sm">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 transition ease-in-out duration-150">
                                {{ __('Update Data Observasi') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const radioButtons = document.querySelectorAll('input[name="review_bersama_pekerja"]');
        const container = document.getElementById('foto_review_container');
        function toggleUpload() {
            const selected = document.querySelector('input[name="review_bersama_pekerja"]:checked');
            container.style.display = (selected && selected.value === 'Ya') ? 'block' : 'none';
        }
        radioButtons.forEach(radio => radio.addEventListener('change', toggleUpload));
        toggleUpload(); 
    });
    </script>
</x-app-layout>