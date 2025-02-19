@extends('dashboard/layout/app')

@section('titles')
Ubah Data Siswa
@endsection
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <h6>Ubah Data Siswa | {{ $siswa->nama_siswa }}</h6>
                </div>

                <div class="card-body px-5 pt-3 pb-2">
                    <form action="{{ route('put.siswa', ['id'=> $siswa->id]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nisn" class="text-sm">NISN</label>
                            <input type="text" class="form-control" id="nisn" name="nisn" value="{{ $siswa->nisn }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="nipd" class="text-sm">NIPD</label>
                            <input type="text" class="form-control" id="nipd" name="nipd" value="{{ $siswa->nipd }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="nama" class="text-sm">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama_siswa" value="{{ $siswa->nama_siswa }}">
                        </div>
                        <div class="form-group">
                            <label for="tempat_lahir" class="text-sm">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ $siswa->tempat_lahir }}">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir" class="text-sm">Tanggal Lahir</label>
                            <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ $siswa->tanggal_lahir }}">
                        </div>
                        <div class="form-group">
                            <label for="kompetensi" class="text-sm">Kompetensi</label>
                            <select class="form-control form-control" id="kompetensi" name="kelas_id">
                                <option value="" selected hidden>Kompetensi</option>
                                {{-- @foreach ($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}" {{ $findJurusan->jurusan->id == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->jurusan }}</option>   
                                @endforeach --}}
                                @foreach ($dataJurusan as $jurusan)
                                    <option value="{{ $jurusan->id }}" {{ $jurusan->id == $siswa->jurusan_id ? 'selected' : '' }}>{{ $jurusan->jurusan }}</option>   
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
