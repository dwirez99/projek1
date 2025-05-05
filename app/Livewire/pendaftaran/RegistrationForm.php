<?php

namespace App\Livewire\pendaftaran;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Siswa;
use App\Models\Orangtua;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class RegistrationForm extends Component
{
    use WithFileUploads;

    // Siswa fields
    public $nama_anak;
    public $tanggal_lahir;
    public $jenis_kelamin;
    public $foto_tempat_tinggal;

    // Orangtua fields
    public $nama_ibu;
    public $no_telp;
    public $email;

    protected $rules = [
        'nama_anak' => 'required|string|max:255',
        'tanggal_lahir' => 'required|date',
        'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        'foto_tempat_tinggal' => 'nullable|image|max:2048', // max 2MB

        'nama_ibu' => 'required|string|max:255',
        'no_telp' => 'required|string|max:20',
        'email' => 'required|email|max:255|unique:users,email',
    ];

    public function submit()
    {
        $this->validate();

        // Handle photo upload
        $fotoPath = null;
        if ($this->foto_tempat_tinggal) {
            $fotoPath = $this->foto_tempat_tinggal->store('foto_tempat_tinggal', 'public');
        }

        // Create User account for orangtua
        $password = Str::random(8);
        $user = User::create([
            'name' => $this->nama_ibu,
            'email' => $this->email,
            'password' => Hash::make($password),
            'role' => 'orangtua',
            'username' => Str::slug($this->nama_ibu) . rand(100, 999),
        ]);

        // Create Orangtua record linked to User
        $orangtua = Orangtua::create([
            'user_id' => $user->id,
            'nama' => $this->nama_ibu,
            'no_telp' => $this->no_telp,
            'email' => $this->email,
        ]);

        // Create Siswa record linked to Orangtua or User if needed
        $siswa = Siswa::create([
            'nama' => $this->nama_anak,
            'ttl' => $this->tanggal_lahir,
            'jnskelamin' => $this->jenis_kelamin,
            'foto' => $fotoPath,
            'wali' => $this->nama_ibu,
            'kelas' => '',
            'thnajar' => '',
            'semester' => '',
            'tb' => 0,
            'bb' => 0,
        ]);

        // Reset form fields
        $this->reset(['nama_anak', 'tanggal_lahir', 'jenis_kelamin', 'foto_tempat_tinggal', 'nama_ibu', 'no_telp', 'email']);

        session()->flash('message', "Pendaftaran berhasil! Akun orang tua dibuat dengan password: $password");

    }

    public function render()
    {
        return view('livewire.pendaftaran.registration-form-wrapper');
    }
}
