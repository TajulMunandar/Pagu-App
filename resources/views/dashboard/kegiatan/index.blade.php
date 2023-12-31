@extends('dashboard.layouts.main')

@section('content')
    <div class="row">
        <div class="col-sm-6 col-md">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif (session()->has('failed'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('failed') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    <button class="btn btn-primary fs-5 fw-normal mt-2" data-bs-toggle="modal" data-bs-target="#tambahKegiatan"><i
            class="fa-solid fa-square-plus fs-5 me-2"></i>Tambah</button>
    </button>
    <div class="row mt-3">
        <div class="col">
            <div class="card mt-2">
                <div class="card-body">

                    {{-- Tabel Data Kegiatan --}}
                    <table id="myTable" class="table responsive nowrap table-bordered table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>PROGRAM</th>
                                <th>KODE</th>
                                <th>KETERANGAN</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kegiatans as $kegiatan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $kegiatan->Program->keterangan }}</td>
                                    <td>{{ $kegiatan->kode }}</td>
                                    <td>{{ $kegiatan->keterangan }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editKegiatan{{ $loop->iteration }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#hapusKegiatan{{ $loop->iteration }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                {{-- Modal Edit Kegiatan --}}
                                <x-form_modal>
                                    @slot('id', "editKegiatan$loop->iteration")
                                    @slot('title', 'Edit Data Kegiatan')
                                    @slot('route', route('kegiatan.update', $kegiatan->id))
                                    @slot('method') @method('put') @endslot
                                    @slot('btnPrimaryTitle', 'Perbarui')

                                    <div class="mb-3">
                                        <label for="program_id" class="form-label">Program</label>
                                        <select class="form-select @error('program_id') is-invalid @enderror"
                                            name="program_id" id="program_id"
                                            value="{{ old('program_id', $kegiatan->program_id) }}">
                                            @foreach ($programs as $program)
                                                @if (old('program_id', $kegiatan->program_id) == $program->id)
                                                    <option value="{{ $program->id }}" selected>
                                                        {{ $program->keterangan }}</option>
                                                @else
                                                    <option value="{{ $program->id }}">
                                                        {{ $program->keterangan }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="kode" class="form-label">Kode</label>
                                        <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                            id="kode" name="kode" value="{{ old('kode', $kegiatan->kode) }}"
                                            autofocus required>
                                        @error('kode')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">keterangan</label>
                                        <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                            id="keterangan" name="keterangan"
                                            value="{{ old('keterangan', $kegiatan->keterangan) }}" autofocus required>
                                        @error('keterangan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </x-form_modal>
                                {{-- / Modal Edit Kegiatan --}}

                                {{-- Modal Hapus Kegiatan --}}
                                <x-form_modal>
                                    @slot('id', "hapusKegiatan$loop->iteration")
                                    @slot('title', 'Hapus Data Kegiatan')
                                    @slot('route', route('kegiatan.destroy', $kegiatan->id))
                                    @slot('method') @method('delete') @endslot
                                    @slot('btnPrimaryClass', 'btn-outline-danger')
                                    @slot('btnSecondaryClass', 'btn-secondary')
                                    @slot('btnPrimaryTitle', 'Hapus')

                                    <p class="fs-5">Apakah anda yakin akan menghapus data kegiatan
                                        <b>{{ $kegiatan->keterangan }}</b>?
                                    </p>

                                </x-form_modal>
                                {{-- / Modal Hapus Kegiatan  --}}
                            @endforeach
                        </tbody>
                    </table>
                    {{-- / Tabel Data ... --}}
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Tambah Kegiatan -->
    <x-form_modal>
        @slot('id', 'tambahKegiatan')
        @slot('title', 'Tambah Data Kegiatan')
        @slot('overflow', 'overflow-auto')
        @slot('route', route('kegiatan.store'))

        @csrf
        <div class="row">
            <div class="mb-3">
                <label for="program_id" class="form-label">Program</label>
                <select class="form-select" id="program_id" name="program_id">
                    @foreach ($programs as $program)
                        <option value="{{ $program->id }}" selected>{{ $program->keterangan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="kode" class="form-label">Kode</label>
                <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode"
                    autofocus required>
                @error('kode')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <input type="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                    name="keterangan" autofocus required>
                @error('keterangan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

        </div>
    </x-form_modal>
    <!-- Akhir Modal Tambah Kegiatan -->
@endsection
