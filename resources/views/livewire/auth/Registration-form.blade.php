<div class="max-w-md mx-auto p-6 bg-white rounded-md shadow-md font-sans">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Pendaftaran Siswa</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" enctype="multipart/form-data" class="space-y-5">
        <div>
            <label for="nama_anak" class="block text-gray-700 font-medium mb-1">Nama Anak</label>
            <input type="text" id="nama_anak" wire:model.defer="nama_anak" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            @error('nama_anak') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="tanggal_lahir" class="block text-gray-700 font-medium mb-1">Tanggal Lahir</label>
            <input type="date" id="tanggal_lahir" wire:model.defer="tanggal_lahir" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            @error('tanggal_lahir') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-1">Jenis Kelamin</label>
            <div class="flex space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" wire:model.defer="jenis_kelamin" value="Laki-laki" class="form-radio text-indigo-600">
                    <span class="ml-2">Laki-laki</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" wire:model.defer="jenis_kelamin" value="Perempuan" class="form-radio text-indigo-600">
                    <span class="ml-2">Perempuan</span>
                </label>
            </div>
            @error('jenis_kelamin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="foto_tempat_tinggal" class="block text-gray-700 font-medium mb-1">Foto Tempat Tinggal</label>
            <input type="file" id="foto_tempat_tinggal" wire:model="foto_tempat_tinggal" accept="image/*" class="w-full" />
            @error('foto_tempat_tinggal') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            @if ($foto_tempat_tinggal)
                <div class="mt-2">
                    <p class="text-gray-600 text-sm mb-1">Preview:</p>
                    <img src="{{ $foto_tempat_tinggal->temporaryUrl() }}" alt="Preview" class="max-w-full h-auto rounded" />
                </div>
            @endif
        </div>

        <div>
            <label for="nama_ibu" class="block text-gray-700 font-medium mb-1">Nama Ibu</label>
            <input type="text" id="nama_ibu" wire:model.defer="nama_ibu" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            @error('nama_ibu') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="no_telp" class="block text-gray-700 font-medium mb-1">No Telp</label>
            <input type="text" id="no_telp" wire:model.defer="no_telp" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            @error('no_telp') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
            <input type="email" id="email" wire:model.defer="email" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <button type="submit" class="w-full bg-indigo-600 text-white p-3 rounded hover:bg-indigo-700 transition duration-200">Daftar</button>
        </div>
    </form>
</div>
