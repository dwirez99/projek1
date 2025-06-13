# DOKUMENTASI SISTEM INFORMASI PENCATATAN, PENILAIAN GIZI DAN KARAKTER ANAK

## 1. PENDAHULUAN

Repositori ini adalah aplikasi web Laravel untuk manajemen data peserta didik, artikel, guru, penilaian karakter, dan status gizi anak. Aplikasi menggunakan arsitektur MVC (Model-View-Controller).

---

## 2. STRUKTUR FOLDER UTAMA

- **app/Models/**: Model Eloquent (User, Artikel, Pesertadidik, Guru)
- **app/Http/Controllers/**: Controller utama (PesertadidikController, ArtikelController, GuruController, StatusgiziController, dsb)
- **resources/views/**: Template Blade (autentikasi, kelola peserta didik, artikel, guru, dsb)
- **routes/web.php**: Routing utama
- **routes/auth.php**: Routing autentikasi
- **public/**: Asset publik (CSS, JS, gambar)
- **config/**: Konfigurasi aplikasi

---

## 3. AUTENTIKASI (LOGIN, REGISTER, ROLE)

**Model:**
- `app/Models/User.php`  
  Berisi field: name, username, email, notelp, alamat, password.

**Controller:**
- Login dan register dengan Livewire (lihat `resources/views/livewire/auth/register.blade.php`)
- Middleware: `app/Http/Middleware/RoleMiddleware.php`
- Route:  
  ```php
  Route::middleware(['auth', 'role:guru'])->group(function () { ... });
  ```

**View:**
- `resources/views/livewire/auth/login.blade.php`
- `resources/views/livewire/auth/register.blade.php`

**Contoh Kode Middleware Role:**
```php
public function handle(Request $request, Closure $next, string $role)
{
    if (!Auth::check()) {
        return redirect('login');
    }
    if (!Auth::user()->hasRole($role)) {
        abort(403, 'Unauthorized');
    }
    return $next($request);
}
```

---

## 4. KOMPONEN UTAMA & STRUKTUR

- **Controller:**  
  - OrangtuaController, PesertadidikController, ArtikelController, GuruController, StatusgiziController
- **Model:**  
  - User, Artikel, Pesertadidik, Guru
- **View:**  
  - layouts/app.blade.php, landingpages.blade.php, dan view per fitur

---

## 5. KELOLA PESERTA DIDIK (CRUD)

**Model:**  
- `app/Models/Pesertadidik.php`

**Controller:**  
- `app/Http/Controllers/PesertadidikController.php`  
  Mendukung CRUD, upload penilaian, filter, dan pencarian.

**View:**  
- `resources/views/pesertadidik/index.blade.php`
- `resources/views/pesertadidik/create.blade.php`

**Cuplikan Kode Store:**
```php
public function store(Request $request)
{
    $validated = $request->validate([
        'idortu' => 'required',
        'namapd' => 'required',
        'tanggallahir' => 'required|date',
        'jeniskelamin' => 'required',
        'kelas' => 'required',
        'tinggibadan' => 'required|integer',
        'beratbadan' => 'required|integer',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);
    // Generate NIS unik
    do {
        $nis = random_int(1000000000, 9999999999);
    } while (DB::table('pesertadidiks')->where('nis', $nis)->exists());
    $validated['nis'] = $nis;
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('media', $filename, 'public');
        $validated['foto'] = $filename;
    }
    $pd = PesertaDidik::create($validated);
    return redirect()->route('pesertadidik.index')->with('success', 'Data ditambahkan!');
}
```

---

## 6. KELOLA ARTIKEL

**Model:**  
- `app/Models/Artikel.php`
```php
class Artikel extends Model
{
    use HasFactory;
    protected $fillable = ['judul', 'thumbnail', 'konten'];
}
```

**Controller:**  
- `app/Http/Controllers/ArtikelController.php`  
  Fungsi: index, create, store, show, edit, update, destroy.

**View:**  
- `resources/views/artikel/index.blade.php`
- `resources/views/artikel/create.blade.php`
- `resources/views/artikel/edit.blade.php`
- `resources/views/artikel/show.blade.php`

---

## 7. DAFTAR GURU

**Model:**  
- `app/Models/Guru.php`

**Controller:**  
- `app/Http/Controllers/GuruController.php`
```php
public function index(Request $request)
{
    $query = Guru::query();
    if ($request->has('search') && $request->search != '') {
        $query->where('name', 'like', '%' . $request->search . '%');
    }
    $gurus = $query->orderBy('name')->limit(5)->get();
    return view('guru.index', compact('gurus'));
}
```

**View:**  
- `resources/views/guru/index.blade.php`

---

## 8. HITUNG Z-SCORE & STATUS GIZI

**Controller:**  
- `app/Http/Controllers/StatusgiziController.php`
```php
$median = $dataStandar['median'];
$minus1sd = $dataStandar['-1sd'];
$plus1sd = $dataStandar['+1sd'];
if ($imt < $median) {
    $sd = $median - $minus1sd;
} else {
    $sd = $plus1sd - $median;
}
$z_score = ($imt - $median) / $sd;
if ($z_score < -2) {
    $status = 'Gizi Kurang';
} elseif ($z_score >= -2 && $z_score <= 1) {
    $status = 'Gizi Baik';
} elseif ($z_score > 1 && $z_score <= 2) {
    $status = 'Gizi Lebih';
} else {
    $status = 'Obesitas';
}
```

**View:**  
- `resources/views/statusgizi/index.blade.php`
- `resources/views/pesertadidik/index.blade.php` (tombol Hitung Z-Score)

---

## 9. PENILAIAN PESERTA DIDIK

**View:**
- `resources/views/penilaian/conclusion_index.blade.php`  
  Menampilkan daftar anak, status, dan link ke detail penilaian.
- `resources/views/penilaian/conclusion.blade.php`  
  Detail penilaian per anak: identitas, status gizi, dan tabel aspek penilaian.

**Contoh Tabel Penilaian (Blade):**
```blade
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Aspek</th>
            <th>Indikator</th>
            <th>Skor</th>
            <th>Komentar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($assessmentDetails as $detail)
            <tr>
                <td>{{ $detail->aspect }}</td>
                <td>{{ $detail->indicator }}</td>
                <td>{{ $detail->score }}</td>
                <td>{{ $detail->comment ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
```

---

## 10. KONVERSI KE DOCX

1. Simpan file ini sebagai `DOKUMENTASI_PROJEK1.md`.
2. Gunakan Microsoft Word (buka file .md, lalu Save As .docx) atau gunakan perintah pandoc:
   ```
   pandoc DOKUMENTASI_PROJEK1.md -o DOKUMENTASI_PROJEK1.docx
   ```
3. Edit/rapikan sesuai kebutuhan di Word.

---

**Catatan:**  
Jika Anda ingin memasukkan isi file kode secara utuh, silakan sebutkan file mana saja yang diinginkan agar saya lampirkan ke dokumen.  
Jika ingin template Word (DOCX) siap pakai, silakan unduh file ini dan konversi sesuai petunjuk di atas.
