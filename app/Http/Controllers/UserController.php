<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Propinsi;
use App\Models\TugasAkhir;
use App\Models\Mahasiswa;
use App\Models\Pendidikan;
use App\Models\Pekerjaan;
use App\Models\Dosen;
use App\Models\JenisPekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $mahasiswa  = $user->mahasiswa; 
        $pendidikans = $user->pendidikan()->with('jurusan')->get();
        $pekerjaans = $user->pekerjaan()->with(['jenisPekerjaan', 'propinsi'])->get();
        $tugasAkhir = $mahasiswa?->tugasAkhir()?->with(['dosen1', 'dosen2'])->first(); 

        return view('dashboard.user', compact(
            'user', 'mahasiswa', 'tugasAkhir', 'pendidikans', 'pekerjaans'
        ));
    }

    public function profile()
    {
        $user = auth()->user();

        $mahasiswa = $user->mahasiswa;
        $pendidikans = $user->pendidikan()->with('jurusan')->get();
        $pekerjaans = $user->pekerjaan()->with(['jenisPekerjaan', 'propinsi'])->get();
        $tugasAkhir = $mahasiswa?->tugasAkhir()?->with(['dosen1', 'dosen2'])->first();

        $propinsiList = DB::table('propinsi')->get();
        $dosenList = Dosen::all();

        return view('profile.index', compact(
            'user', 'mahasiswa', 'tugasAkhir', 'pendidikans', 'pekerjaans', 'propinsiList', 'dosenList'
        ));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'username' => 'required|string',
            'password' => 'nullable|string|min:5',
        ];

        if ($user->roles->name !== 'alumni') {
            $rules['id'] = 'required|string';
        }

        $request->validate($rules);

        if ($user->roles->name !== 'alumni') {
            $user->id = $request->id;
        }

        $user->username = $request->username;

        if ($request->filled('password_lama') || $request->filled('password_baru')) {
            $request->validate([
                'password_lama' => 'required',
                'password_baru' => 'required|string|min:5|same:password_konfirmasi|different:password_lama',
                'password_konfirmasi' => 'required|string|min:5|same:password_baru',
            ]);

            if (!Hash::check($request->password_lama, $user->password)) {
                return back()->withErrors(['password_lama' => 'Password lama tidak cocok']);
            }

            $user->password = bcrypt($request->password_baru);
        }


        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/foto_user'), $filename);
            $user->foto = $filename;
        }

        $user->save();

        if ($user->roles->name === 'alumni') {
            $dataMahasiswa = $request->only([
                'nama', 'alamat', 'kota', 'kodepos', 'sex', 'email', 'telepon',
                'hp', 'tmptlahir', 'tgllahir', 'alamatluarkota', 'kotaluarkota',
                'kodeposluarkota', 'teleponluarkota', 'idpropinsi'
            ]);

            $alumniData = Mahasiswa::where('nrp', $user->id)->first();

            if ($alumniData) {
                $alumniData->update($dataMahasiswa);
            } else {
                Mahasiswa::create(array_merge(['nrp' => $user->id], $dataMahasiswa));
            }
        }

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function getPendidikanEditForm(Request $request)
    {
        $nrp = $request->nrp;
        $idjurusan = $request->idjurusan;

        $data = Pendidikan::where('nrp', $nrp)
                        ->where('idjurusan', $idjurusan)
                        ->first();

        if (!$data) {
            return response()->json(['error' => 'Data not found.'], 404);
        }

        return response()->json([
            'status' => 'oke',
            'msg' => view('profile.getPendidikanEditForm', compact('data'))->render()
        ]);
    }

    public function updatePendidikan(Request $request, $nrp, $idjurusan)
    {
        $request->validate([
            'angkatan' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'tanggallulus' => 'required|date',
            'ipk' => 'required|numeric|between:0,4.00',
        ]);

        Pendidikan::where('nrp', $nrp)
            ->where('idjurusan', $idjurusan)
            ->update($request->only(['angkatan', 'tanggallulus', 'ipk']));

        return redirect()->route('profile')->with('status', 'Data pendidikan berhasil diperbarui.');
    }

    public function getPekerjaanEditForm(Request $request)
    {
        $nrp = $request->nrp;
        $idjenispekerjaan = $request->idjenispekerjaan;

        $data = Pekerjaan::where('nrp', $nrp)
            ->where('idjenispekerjaan', $idjenispekerjaan)
            ->first();

        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $propinsiList = Propinsi::all();
        $jenisPekerjaanList = JenisPekerjaan::all();

        return response()->json([
            'status' => 'oke',
            'msg' => view('profile.getPekerjaanEditForm', compact('data', 'propinsiList','jenisPekerjaanList'))->render()
        ]);
    }

    public function updatePekerjaan(Request $request, $nrp, $idjenispekerjaan)
    {
        $request->validate([
            'bidangusaha' => 'required|string|max:30',
            'perusahaan' => 'required|string|max:45',
            'telepon' => 'required|string|max:20',
            'mulaikerja' => 'required|date',
            'gajipertama' => 'required|numeric',
            'alamat' => 'required|string|max:50',
            'kota' => 'required|string|max:20',
            'kodepos' => 'required|string|max:5',
            'idpropinsi' => 'required|numeric',
            'jabatan' => 'required|string|max:30',
        ]);

        $data = Pekerjaan::where('nrp', $nrp)
            ->where('idjenispekerjaan', $idjenispekerjaan)
            ->firstOrFail();

        $data->update($request->only([
            'bidangusaha', 'perusahaan', 'telepon', 'mulaikerja', 'gajipertama',
            'alamat', 'kota', 'kodepos', 'idpropinsi', 'jabatan'
        ]));

        return redirect()->route('profile')->with('success', 'Data pekerjaan berhasil diperbarui.');
    }


}
