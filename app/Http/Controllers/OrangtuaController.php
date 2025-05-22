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
use Illuminate\Support\Facades\Log;
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
            ->paginate(1); // This is the key change - use paginate() instead of get()
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

        Log::info("user: {$user}");

        // Logging untuk memastikan user terautentikasi
        if (!$user) {
            Log::warning('Akses nilaiSiswa tanpa login.');
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        Log::info("User yang login: {$user->id} - {$user->name}");

        $orangTua = $user->orangTua; // relasi hasOne

        // Logging untuk mengecek apakah relasi berhasil
        if (!$orangTua) {
            Log::warning("Data orangtua tidak ditemukan untuk user_id: {$user->id}");
            return redirect()->route('orangtua.index')->with('error', 'Orangtua tidak ditemukan untuk pengguna ini.');
        }

        Log::info("Orangtua ditemukan dengan ID: {$orangTua->id}");

        $anakanaks = Pesertadidik::with('orangtua')
            ->where('idortu', $orangTua->id)
            ->get();

        Log::info("Jumlah anak ditemukan: " . $anakanaks->count());

        // Ambil status gizi terbaru setiap anak
        $statusgizis = [];

        foreach ($anakanaks as $anak) {
            Log::info("Mengambil status gizi untuk NIS: {$anak->nis}");

            $status = Statusgizi::with('pesertadidik')
                ->where('nis', $anak->nis)
                ->latest('created_at')
                ->first();

            if ($status) {
                Log::info("Status gizi ditemukan untuk NIS {$anak->nis} - ID Status: {$status->id}");
            } else {
                Log::warning("Status gizi TIDAK ditemukan untuk NIS {$anak->nis}");
            }

            $statusgizis[$anak->nis] = $status;
        }

        return view('orangtuas.anakanak', compact('anakanaks', 'statusgizis'));
    }
}
