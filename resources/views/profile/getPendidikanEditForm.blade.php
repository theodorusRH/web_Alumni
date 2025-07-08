<form method="POST" action="{{ route('profile.updatePendidikan', $data->id) }}">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Jurusan</label>
        <input type="text" class="form-control" value="{{ $data->jurusan->nama ?? '-' }}" disabled>
    </div>

    <div class="form-group">
        <label>Angkatan</label>
        <input type="text" name="angkatan" class="form-control" value="{{ $data->angkatan }}">
    </div>

    <div class="form-group">
        <label>Jumlah Semester</label>
        <input type="text" name="jmlsemester" class="form-control" value="{{ $data->jmlsemester }}">
    </div>

    <div class="form-group">
        <label>Tanggal Lulus</label>
        <input type="date" name="tanggallulus" class="form-control" value="{{ $data->tanggallulus }}">
    </div>

    <div class="form-group">
        <label>IPK</label>
        <input type="text" name="ipk" class="form-control" value="{{ $data->ipk }}">
    </div>

    <div class="mt-3 text-end">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
    </div>
</form>
