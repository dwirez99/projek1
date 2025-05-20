<?php

namespace App\Http\Controllers;

use App\Models\Orangtua;
use App\Models\Pesertadidik;
use App\Models\StatusGizi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class OrangtuaController extends Controller
{
    public function index()
    {
        $orangtuas = Orangtua::all();
        return view('orangtuas.index', compact('orangtuas'));

        $search = request('cari');

    $orangtuas = Orangtua::with('user')
        ->when($search, function($query) use ($search) {
            return $query->where('namaortu', 'like', '%'.$search.'%')
                         ->orWhere('nickname', 'like', '%'.$search.'%');
        })
        ->paginate(10); // This is the key change - use paginate() instead of get()
    }

    public function create()
    {
        return view('orangtuas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaortu' => 'required|string',
            'nickname' => 'required|string',
            'notelportu' => 'required|string|unique:orangtuas,notelportu',
            'alamat' => 'nullable|string',
        ]);

        // Generate email dari nama
        $username = Str::slug($request->namaortu);
        $email = $username . '@orangtua.com';

        // Hindari duplikat
        $original_email = $email;
        $count = 1;
        while (User::where('email', $email)->exists()) {
            $email = $username . $count . '@orangtua.com';
            $count++;
        }
        // End Hindari duplikat

        // Insert into users value
        $user = User::create([
            'name' => $request->namaortu,
            'username' => $username,
            'email' => $email,
            'notelp' => $request->notelportu,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->notelportu), // password = notelportu
        ]);
        // End Insert into users

        $user->assignRole('orangtua');

        // Insert into orangtuas value
        $user->orangTua()->create([
            'namaortu' => $request->namaortu,
            'nickname' => $request->nickname,
            'emailortu' => $email,
            'notelportu' => $request->notelportu,
            'alamat' => $request->alamat,
        ]);
        // End Insert into orangtuas

        return redirect()->route('orangtua.index')->with('success', 'Akun orang tua berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $orangtua = Orangtua::findOrFail($id);
        $user = $orangtua->user;

        // Validasi
        $request->validate([
            'namaortu'   => 'required|string|max:255',
            'nickname'   => 'nullable|string|max:255',
            'emailortu'  => 'required|email|max:255',
            'notelportu' => 'required|string|max:20',
            'username'   => 'required|string|max:255|unique:users,username,' . $user->id,
            'password'   => 'nullable|string|min:6|confirmed',
            'alamat' => 'nullable|string|max:255',
        ]);

        // Update data orangtua
        $orangtua->update([
            'namaortu'   => $request->namaortu,
            'nickname'   => $request->nickname,
            'emailortu'  => $request->emailortu,
            'notelportu' => $request->notelportu,
        ]);

        // Update data user
        $user->username = $request->username;
        $user->email = $request->emailortu; // sinkronisasi email
        $user->notelp = $request->notelportu;
        $user->alamat = $request->alamat;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('orangtua.index')->with('success', 'Data orang tua berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $ortu = Orangtua::findOrFail($id);

        // Hapus user, otomatis juga hapus data orangtua jika ada CASCADE
        $user = $ortu->user;
        if ($user) {
            $user->delete();
        }

        return redirect()->route('orangtua.index')->with('success', 'Akun orang tua berhasil dihapus.');
    }

    public function nilaiSiswa()
    {
        $user = Auth::user();
        $orangTua = $user->orangtua;

        if (!$orangTua) {
            return redirect()->route('orangtua.index')->with('error', 'Orangtua tidak ditemukan untuk pengguna ini.');
        }

        $anakanaks = Pesertadidik::with('orangtua')->where('idortu', $orangTua->id)->get();

        // Ambil semua status gizi terbaru per anak
        $statusgizis = [];
        foreach ($anakanaks as $anak) {
            $status = Statusgizi::with('pesertadidik')
                ->where('nisn', $anak->nisn)
                ->latest('created_at')
                ->first();

            $statusgizis[$anak->nisn] = $status;
        }

        return view('orangtuas.anakanak', compact('anakanaks', 'statusgizis'));
    }
}
