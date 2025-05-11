<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-orange-500 py-4 px-6">
            <h1 class="text-white text-2xl font-bold">FORM PENDAFTARAN</h1>
        </div>

        <form class="p-6" wire:submit.prevent="simpan">
            <!-- Nama Anak -->
            <div class="mb-4">
                <label for="nama_anak" class="block text-gray-700 font-bold mb-2">Nama Anak</label>
                <input type="text" id="nama_anak" wire:model="nama_anak"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                @error('nama_anak') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-4">
                <label for="tanggal_lahir" class="block text-gray-700 font-bold mb-2">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" wire:model="tanggal_lahir"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                @error('tanggal_lahir') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Jenis Kelamin -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Jenis Kelamin</label>
                <div class="flex items-center space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model="jenis_kelamin" value="Laki-Laki"
                               class="form-radio h-5 w-5 text-orange-500">
                        <span class="ml-2 text-gray-700">Laki-Laki</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" wire:model="jenis_kelamin" value="Perempuan"
                               class="form-radio h-5 w-5 text-orange-500">
                        <span class="ml-2 text-gray-700">Perempuan</span>
                    </label>
                </div>
                @error('jenis_kelamin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Foto -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Foto</label>

                @if($foto)
                    <div class="mb-2">
                        <img src="{{ $foto->temporaryUrl() }}" class="h-32 w-32 object-cover rounded-md">
                    </div>
                @endif

                <input type="file" wire:model="foto"
                       class="block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-md file:border-0
                              file:text-sm file:font-semibold
                              file:bg-orange-50 file:text-orange-700
                              hover:file:bg-orange-100">
                @error('foto') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                @if($nama_file)
                    <p class="mt-1 text-sm text-gray-500">Nama file: {{ $nama_file }}</p>
                @endif
            </div>

            <!-- Tombol Simpan -->
            <div class="mt-6">
                <button type="submit"
                        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition duration-150">
                    Simpan
                </button>
            </div>
        </form>

        @if(session()->has('message'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-6 mb-6" role="alert">
                <p>{{ session('message') }}</p>
            </div>
        @endif
    </div>
</div>