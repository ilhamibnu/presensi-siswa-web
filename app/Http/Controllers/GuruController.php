<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $guru = User::where('role_id', 2)->get();
        return view('admin.pages.guru', [
            'guru' => $guru
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'username' => 'required|unique:users',
                'password' => 'required',
                'repassword' => 'required|same:password',
            ], [
                'name.required' => 'Nama harus diisi',
                'username.required' => 'username harus diisi',
                'username.unique' => 'username sudah digunakan',
                'password.required' => 'Password harus diisi',
                'repassword.required' => 'Konfirmasi password harus diisi',
                'repassword.same' => 'Password tidak sama',
            ]);

            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'role_id' => 2,
            ]);

            return redirect()->back()->with('success', 'Data guru berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data guru gagal ditambahkan');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            if ($request->password != null) {
                $request->validate([
                    'name' => 'required',
                    'username' => 'required|unique:users,username,' . $id,
                    'password' => 'required',
                    'repassword' => 'required|same:password',
                ], [
                    'name.required' => 'Nama harus diisi',
                    'username.required' => 'username harus diisi',
                    'username.unique' => 'username sudah digunakan',
                    'password.required' => 'Password harus diisi',
                    'repassword.required' => 'Konfirmasi password harus diisi',
                    'repassword.same' => 'Password tidak sama',
                ]);
            } else {
                $request->validate([
                    'name' => 'required',
                    'username' => 'required|unique:users,username,' . $id,
                ], [
                    'name.required' => 'Nama harus diisi',
                    'username.required' => 'username harus diisi',
                    'username.unique' => 'username sudah digunakan',
                ]);
            }


            $guru = User::find($id);
            $guru->name = $request->name;
            $guru->username = $request->username;
            if ($request->password != null) {
                $guru->password = bcrypt($request->password);
            }
            $guru->save();

            return redirect()->back()->with('success', 'Data guru berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data guru gagal diubah');
        }
    }

    public function destroy($id)
    {
        try {
            $guru = User::find($id);
            $guru->delete();
            return redirect()->back()->with('success', 'Data guru berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data guru gagal dihapus');
        }
    }
}
