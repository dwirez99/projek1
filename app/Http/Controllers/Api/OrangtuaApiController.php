<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Orangtua;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class OrangtuaApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('cari');
        $perPage = $request->input('per_page', 10);

        $orangtuas = Orangtua::with('user')
            ->when($search, function ($query) use ($search) {
                return $query->where('namaortu', 'like', '%' . $search . '%')
                    ->orWhere('nickname', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('username', 'like', '%' . $search . '%')
                          ->orWhere('email', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->paginate($perPage);

        return response()->json($orangtuas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'namaortu' => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'notelportu' => 'required|string|max:20|unique:orangtuas,notelportu|unique:users,notelp',
            'alamat' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email', // Email for user, can be optional
            'password' => 'nullable|string|min:6', // Password for user, can be optional
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Generate username from namaortu
        $baseUsername = Str::slug($request->namaortu);
        $username = $baseUsername;
        $count = 1;
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $count;
            $count++;
        }

        // Generate email if not provided
        $email = $request->email;
        if (!$email) {
            $baseEmail = Str::slug($request->namaortu) . '@orangtua.com';
            $email = $baseEmail;
            $emailCount = 1;
            while (User::where('email', $email)->exists()) {
                $email = Str::slug($request->namaortu) . $emailCount . '@orangtua.com';
                $emailCount++;
            }
        }

        // Determine password
        $password = $request->password ? Hash::make($request->password) : Hash::make($request->notelportu);

        $user = User::create([
            'name' => $request->namaortu,
            'username' => $username,
            'email' => $email,
            'notelp' => $request->notelportu,
            'alamat' => $request->alamat,
            'password' => $password,
        ]);

        $user->assignRole('orangtua');

        $orangtua = $user->orangTua()->create([
            'namaortu' => $request->namaortu,
            'nickname' => $request->nickname,
            'emailortu' => $email, // Sync with user's email
            'notelportu' => $request->notelportu,
            'alamat' => $request->alamat,
        ]);

        return response()->json($orangtua->load('user'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Orangtua $orangtua)
    {
        return response()->json($orangtua->load('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orangtua $orangtua)
    {
        $user = $orangtua->user;

        $validator = Validator::make($request->all(), [
            'namaortu'   => 'sometimes|required|string|max:255',
            'nickname'   => 'sometimes|nullable|string|max:255',
            'emailortu'  => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('orangtuas', 'emailortu')->ignore($orangtua->id),
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'notelportu' => [
                'sometimes',
                'required',
                'string',
                'max:20',
                Rule::unique('orangtuas', 'notelportu')->ignore($orangtua->id),
                Rule::unique('users', 'notelp')->ignore($user->id),
            ],
            'alamat'     => 'sometimes|nullable|string|max:255',
            'username'   => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'password'   => 'nullable|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $orangtuaData = $request->only(['namaortu', 'nickname', 'emailortu', 'notelportu', 'alamat']);
        if ($request->has('emailortu')) {
             $orangtuaData['emailortu'] = $request->emailortu;
        }
        $orangtua->update(array_filter($orangtuaData, fn($value) => !is_null($value)));


        $userData = [
            'name' => $request->input('namaortu', $user->name),
            'username' => $request->input('username', $user->username),
            'email' => $request->input('emailortu', $user->email), // Sync email
            'notelp' => $request->input('notelportu', $user->notelp),
            'alamat' => $request->input('alamat', $user->alamat),
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update(array_filter($userData, fn($value) => !is_null($value) || $value === ''));


        return response()->json($orangtua->fresh()->load('user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orangtua $orangtua)
    {
        $user = $orangtua->user;
        if ($user) {
            // Deleting the user should ideally cascade to Orangtua if foreign keys are set up with onDelete('cascade')
            // Or handle it via model events (observers)
            $user->delete();
        } else {
            // If for some reason user is not found, delete orangtua directly
            $orangtua->delete();
        }

        return response()->json(null, 204);
    }
}
