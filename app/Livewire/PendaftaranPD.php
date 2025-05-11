<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Storage;

class PendaftaranPD extends Component
{
    use WithFileUploads;

    public $nama_anak;
    public $tanggal_lahir;
    public $jenis_kelamin = 'Laki-Laki';
    public $foto;
    public $nama_file;

    protected $rules = [
        'nama_anak' => 'required|min:3',
        'tanggal_lahir' => 'required|date',
        'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
        'foto' => 'required|image|max:2048', // 2MB Max
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function simpan()
    {
        $validatedData = $this->validate();

        // Simpan file foto
        $path = $this->foto->store('public/foto_pendaftaran');
        $this->nama_file = basename($path);

        // Simpan data ke database
        PendaftaranPD::create([
            'nama_anak' => $this->nama_anak,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'foto_path' => $path,
        ]);

        session()->flash('message', 'Pendaftaran berhasil disimpan!');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.pendaftaran-p-d');
    }
}