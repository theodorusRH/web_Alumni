<form method="POST" action="{{ route('profile.updatePendidikan', [$data->nrp, $data->idjurusan]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label>Jurusan</label>
        <input type="text" class="form-control" value="{{ $data->jurusan->nama }}" readonly>
    </div>

    <div class="form-group">
        <label>Jumlah Semester</label>
        <input type="text" class="form-control" value="{{ $data->jmlsemester }}" readonly>
    </div>

    <div class="form-group">
        <label>Angkatan</label>
        <input type="number" name="angkatan" class="form-control" min="1900" max="{{ date('Y') }}" value="{{ $data->angkatan }}" required>
    </div>

    <div class="form-group">
        <label>Tanggal Lulus</label>
        <input type="date" name="tanggallulus" class="form-control" value="{{ \Carbon\Carbon::parse($data->tanggallulus)->format('Y-m-d') }}">

    </div>

    <div class="form-group">
        <label>IPK</label>
        <input type="number" name="ipk" class="form-control"
            step="0.01" min="0" max="4" value="{{ $data->ipk }}" required>
    </div>


    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
    </div>
</form>