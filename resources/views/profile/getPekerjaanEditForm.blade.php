<form method="POST" action="{{ route('profile.updatePekerjaan', [$data->nrp, $data->idjenispekerjaan]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="form-group">
        <label>Jenis Pekerjaan</label>
        <select name="idjenispekerjaan" class="form-control" required>
            @foreach ($jenisPekerjaanList as $jenis)
                <option value="{{ $jenis->idjenispekerjaan }}" {{ $data->idjenispekerjaan == $jenis->idjenispekerjaan ? 'selected' : '' }}>
                    {{ $jenis->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div class="form-group"><label>Bidang Usaha</label>
        <input type="text" name="bidangusaha" class="form-control" value="{{ $data->bidangusaha }}" required>
    </div>

    <br>

    <div class="form-group"><label>Perusahaan</label>
        <input type="text" name="perusahaan" class="form-control" value="{{ $data->perusahaan }}" required>
    </div>

    <br>
    
    <div class="form-group"><label>Telepon</label>
        <input type="text" name="telepon" class="form-control" value="{{ $data->telepon }}" required>
    </div>

    <br>

    <div class="form-group"><label>Mulai Kerja</label>
        <input type="date" name="mulaikerja" value="{{ \Carbon\Carbon::parse($data->mulaikerja)->format('Y-m-d') }}">
    </div>

    <br>

    <div class="form-group"><label>Gaji Pertama</label>
        <input type="number" name="gajipertama" class="form-control" value="{{ $data->gajipertama }}" required>
    </div>

    <br>

    <div class="form-group"><label>Alamat</label>
        <input type="text" name="alamat" class="form-control" value="{{ $data->alamat }}" required>
    </div>

    <br>

    <div class="form-group"><label>Kota</label>
        <input type="text" name="kota" class="form-control" value="{{ $data->kota }}" required>
    </div>

    <br>

    <div class="form-group"><label>Kode Pos</label>
        <input type="text" name="kodepos" class="form-control" value="{{ $data->kodepos }}" required>
    </div>

    <br>

    <div class="form-group"><label>Provinsi</label>
        <select name="idpropinsi" class="form-control">
            @foreach($propinsiList as $prov)
                <option value="{{ $prov->idpropinsi }}" {{ $data->idpropinsi == $prov->idpropinsi ? 'selected' : '' }}>
                    {{ $prov->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div class="form-group"><label>Jabatan</label>
        <input type="text" name="jabatan" class="form-control" value="{{ $data->jabatan }}" required>
    </div>

    <br>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
    </div>
</form>
