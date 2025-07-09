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
use App\Models\Jurusan;
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
        $jenisPekerjaanList = JenisPekerjaan::all();
        $jurusanList = Jurusan::all();

        return view('profile.index', compact(
            'user', 'mahasiswa', 'tugasAkhir', 'pendidikans', 'pekerjaans', 'propinsiList', 'dosenList',
            'jenisPekerjaanList','jurusanList'
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

    public function storePendidikan(Request $request)
    {
        $request->validate([
            'idjurusan' => 'required|exists:jurusan,idjurusan',
            'jmlsemester'=> 'required',
            'angkatan' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'tanggallulus' => 'required|date',
            'ipk' => 'required|numeric|between:0,4.00',
        ]);

        $data = new Pendidikan();
        $data->nrp = auth()->user()->id;
        $data->idjurusan = $request->idjurusan;
        $data->angkatan = $request->angkatan;
        $data->jmlsemester = $request->jmlsemester;
        $data->tanggallulus = $request->tanggallulus;
        $data->ipk = $request->ipk;
        $data->save();

        return redirect()->route('profile')->with('status', 'Data pendidikan berhasil ditambahkan.');
    }

    public function getPendidikanEditForm(Request $request)
    {
        $id = $request->id;
        $data = Pendidikan::find($id);
    
        if (!$data) {
            return response()->json(['error' => 'Data not found.'], 404);
        }
    
        $jurusanList = Jurusan::all();
    
        return response()->json([
            'status' => 'oke',
            'msg' => view('profile.getPendidikanEditForm', compact('data', 'jurusanList'))->render()
        ], 200);
    }
    

    public function updatePendidikan(Request $request, $id)
    {
        $request->validate([
            'angkatan' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'jmlsemester'=> 'required',
            'tanggallulus' => 'required|date',
            'ipk' => 'required|numeric|between:0,4.00',
        ]);

        $data = Pendidikan::findOrFail($id);
        $data->angkatan = $request->angkatan;
        $data->jmlsemester = $request->jmlsemester;
        $data->tanggallulus = $request->tanggallulus;
        $data->ipk = $request->ipk;
        $data->save();

        return redirect()->route('profile')->with('status', 'Data pendidikan berhasil diperbarui.');
    }


    public function storePekerjaan(Request $request)
    {
        try
        {
            $request->validate([
                'idjenispekerjaan' => 'required|exists:jenispekerjaan,idjenispekerjaan',
                'bidangusaha' => 'required|string|max:255',
                'perusahaan' => 'nullable|string|max:255',
                'telepon' => 'nullable|string|max:50',
                'mulaikerja' => 'nullable|date',
                'gajipertama' => 'nullable|numeric',
                'alamat' => 'nullable|string|max:255',
                'kota' => 'nullable|string|max:100',
                'kodepos' => 'nullable|string|max:10',
                'idpropinsi' => 'required|exists:propinsi,idpropinsi',
                'jabatan' => 'nullable|string|max:100',
            ]);

            $data = new Pekerjaan();
            $data->nrp = auth()->user()->id;
            $data->idjenispekerjaan = $request->idjenispekerjaan;
            $data->bidangusaha = $request->bidangusaha;
            $data->perusahaan = $request->perusahaan;
            $data->telepon = $request->telepon;
            $data->mulaikerja = $request->mulaikerja;
            $data->gajipertama = $request->gajipertama;
            $data->alamat = $request->alamat;
            $data->kota = $request->kota;
            $data->kodepos = $request->kodepos;
            $data->idpropinsi = $request->idpropinsi;
            $data->jabatan = $request->jabatan;
            $data->save();

            return redirect()->route('profile.index')->with('status', 'Horray! Your data is successfully added!');

        } catch (\Exception $e) {
            return back()->with('status', 'Error: ' . $e->getMessage());
        }
    }

    public function getPekerjaanEditForm(Request $request)
    {
        $id = $request->id;
        $data = Pekerjaan::find($id);
    
        if (!$data) {
            return response()->json(['error' => 'Data not found.'], 404);
        }
    
        $propinsiList = Propinsi::all();
        $jenisPekerjaanList = JenisPekerjaan::all();
    
        return response()->json([
            'status' => 'oke',
            'msg' => view('profile.getPekerjaanEditForm', compact('data', 'propinsiList','jenisPekerjaanList'))->render()
        ], 200);
    }

    public function updatePekerjaan(Request $request, $id)
    {
        $request->validate([
            'idjenispekerjaan' => 'required|exists:jenispekerjaan,idjenispekerjaan',
            'bidangusaha' => 'required|string|max:255',
            'perusahaan' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:50',
            'mulaikerja' => 'nullable|date',
            'gajipertama' => 'nullable|numeric',
            'alamat' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:100',
            'kodepos' => 'nullable|string|max:10',
            'idpropinsi' => 'required|exists:propinsi,idpropinsi',
            'jabatan' => 'nullable|string|max:100',
        ]);

        try{
            $data = Pekerjaan::find($id);
            $data->idjenispekerjaan = $request->idjenispekerjaan;
            $data->bidangusaha = $request->bidangusaha;
            $data->perusahaan = $request->perusahaan;
            $data->telepon = $request->telepon;
            $data->mulaikerja = $request->mulaikerja;
            $data->gajipertama = $request->gajipertama;
            $data->alamat = $request->alamat;
            $data->kota = $request->kota;
            $data->kodepos = $request->kodepos;
            $data->idpropinsi = $request->idpropinsi;
            $data->jabatan = $request->jabatan;
            $data->save();
            // Log::error('Update Error', ['error' => $e->getMessage()]);

            return redirect()->route('profile.index')->with('status', 'Data updated!');
        }catch (\Exception $e) {
            // Log::error('Update Error', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('Gagal mendaftar: ' . $e->getMessage())->withInput();
        }
        
    }
}
