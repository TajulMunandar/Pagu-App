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

    <button class="btn btn-primary fs-5 fw-normal mt-2" data-bs-toggle="modal" data-bs-target="#tambahKontrak"><i
            class="fa-solid fa-square-plus fs-5 me-2"></i>Tambah</button>
    <div class="row mt-3">
        <div class="col">
            <div class="card mt-2">
                <div class="card-body">

                    {{-- Tabel Data Kontrak --}}
                    <table id="myTable" class="table responsive nowrap table-bordered table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>PAGU</th>
                                <th>PENYEDIA</th>
                                <th>NOMOR</th>
                                <th>TANGGAL</th>
                                <th>JUMLAH</th>
                                <th>JANGKA WAKTU</th>
                                <th>BUKTI</th>
                                <th>HPS</th>
                                <th>DOKUMEN</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kontraks as $kontrak)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $kontrak->Pagu->paket }}</td>
                                    <td>{{ $kontrak->penyedia }}</td>
                                    <td>{{ $kontrak->nomor }}</td>
                                    <td>{{ $kontrak->tanggal }}</td>
                                    <td>{{ $kontrak->jumlah }}</td>
                                    <td>{{ $kontrak->jangka_waktu }}</td>
                                    @php
                                        if ($kontrak->bukti == 1) {
                                            $bukti = 'YA';
                                        } else {
                                            $bukti = 'TIDAK';
                                        }
                                    @endphp
                                    <td>{{ $bukti }}</td>
                                    <td>{{ $kontrak->hps }}</td>
                                    <td>{{ $kontrak->dokumen }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#showKontrak{{ $loop->iteration }}">
                                            <i class="fa-solid fa-list"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editKontrak{{ $loop->iteration }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#hapusKontrak{{ $loop->iteration }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                {{-- Modal Edit Kontrak --}}
                                <x-form_modal>
                                    @slot('id', "editKontrak$loop->iteration")
                                    @slot('title', 'Edit Data Kontrak')
                                    @slot('route', route('kontrak.update', $kontrak->id))
                                    @slot('method') @method('put') @endslot
                                    @slot('btnPrimaryTitle', 'Perbarui')


                                    <div class="mb-3">
                                        <label for="pagu_id" class="form-label">Pagu</label>
                                        <select class="form-select @error('pagu_id') is-invalid @enderror" name="pagu_id"
                                            id="pagu_id" value="{{ old('pagu_id', $kontrak->pagu_id) }}">
                                            @foreach ($pagus as $pagu)
                                                @if (old('pagu_id', $pagu->pagu_id) == $pagu->id)
                                                    <option value="{{ $pagu->id }}" selected>
                                                        {{ $pagu->paket }}</option>
                                                @else
                                                    <option value="{{ $pagu->id }}">
                                                        {{ $pagu->paket }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="penyedia" class="form-label">penyedia</label>
                                        <input type="text" class="form-control @error('penyedia') is-invalid @enderror"
                                            id="penyedia" name="penyedia"
                                            value="{{ old('penyedia', $kontrak->penyedia) }}" autofocus required>
                                        @error('penyedia')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="nomor" class="form-label">Nomor</label>
                                        <input type="text" class="form-control @error('nomor') is-invalid @enderror"
                                            id="nomor" name="nomor" value="{{ old('nomor', $kontrak->nomor) }}"
                                            autofocus required>
                                        @error('nomor')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                            id="tanggal" name="tanggal" value="{{ old('tanggal', $kontrak->tanggal) }}"
                                            autofocus required>
                                        @error('tanggal')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="jumlah" class="form-label">Jumlah</label>
                                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                            id="jumlah" name="jumlah" value="{{ old('jumlah', $kontrak->jumlah) }}"
                                            autofocus required>
                                        @error('jumlah')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="jangka_waktu" class="form-label">Jangka Waktu</label>
                                        <input type="number"
                                            class="form-control @error('jangka_waktu') is-invalid @enderror"
                                            id="jangka_waktu" name="jangka_waktu"
                                            value="{{ old('jangka_waktu', $kontrak->jangka_waktu) }}" autofocus required>
                                        @error('jangka_waktu')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="bukti" class="form-label">Bukti</label>
                                        <select class="form-select" id="bukti" name="bukti">
                                            <option value="1"
                                                {{ old('bukti', $kontrak->bukti) === 'ya' ? 'selected' : '' }}>Ya
                                            </option>
                                            <option value="0"
                                                {{ old('bukti', $kontrak->bukti) === 'tidak' ? 'selected' : '' }}>Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="hps" class="form-label">HPS</label>
                                        <input type="number" class="form-control @error('hps') is-invalid @enderror"
                                            id="hps" name="hps" value="{{ old('hps', $kontrak->hps) }}"
                                            autofocus required>
                                        @error('hps')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="dokumen" class="form-label">Dokumen</label>
                                        <input type="text" class="form-control @error('dokumen') is-invalid @enderror"
                                            id="dokumen" name="dokumen"
                                            value="{{ old('dokumen', $kontrak->dokumen) }}" autofocus required>
                                        @error('dokumen')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>



                                </x-form_modal>
                                {{-- / Modal Edit Kontrak --}}

                                {{-- Modal Hapus Kontrak --}}
                                <x-form_modal>
                                    @slot('id', "hapusKontrak$loop->iteration")
                                    @slot('title', 'Hapus Data Kontrak')
                                    @slot('route', route('kontrak.destroy', $kontrak->id))
                                    @slot('method') @method('delete') @endslot
                                    @slot('btnPrimaryClass', 'btn-outline-danger')
                                    @slot('btnSecondaryClass', 'btn-secondary')
                                    @slot('btnPrimaryTitle', 'Hapus')

                                    <p class="fs-5">Apakah anda yakin akan menghapus data Kontrak
                                        <b>{{ $kontrak->penyedia }}</b>?
                                    </p>

                                </x-form_modal>
                                {{-- / Modal Hapus Kontrak  --}}

                                {{-- Modal Detail Kontrak --}}
                                <x-form_modal2>
                                    @slot('id', "showKontrak$loop->iteration")
                                    @slot('title', 'Show Data Detail Kontrak')

                                    <div class="row">
                                        <div class="mb-2 col-lg-6">
                                            <a href="{{ route('adendum.show', $kontrak->id) }}">
                                                <div class="card shadow">
                                                    <div class="card-body text-center">
                                                        Adendum
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="mb-2 col-lg-6">
                                            <a href="{{ route('sp2d.show', $kontrak->id) }}">
                                                <div class="card shadow">
                                                    <div class="card-body text-center">
                                                        SP2D
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                </x-form_modal2>
                                {{-- / Modal Detail Kontrak --}}
                            @endforeach
                        </tbody>
                    </table>
                    {{-- / Tabel Data ... --}}
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Tambah Kontrak -->
    <x-form_modal>
        @slot('id', 'tambahKontrak')
        @slot('title', 'Tambah Data Kontrak')
        @slot('overflow', 'overflow-auto')
        @slot('route', route('kontrak.store'))

        @csrf
        <div class="row">
            <div class="mb-3">
                <label for="pagu_id" class="form-label">Pagu</label>
                <select class="form-select @error('pagu_id') is-invalid @enderror" name="pagu_id" id="pagu_id"
                    value="{{ old('pagu_id') }}">
                    @foreach ($pagus as $pagu)
                        <option value="{{ $pagu->id }}" selected>
                            {{ $pagu->paket }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="penyedia" class="form-label">penyedia</label>
                <input type="text" class="form-control @error('penyedia') is-invalid @enderror" id="penyedia"
                    name="penyedia" value="{{ old('penyedia') }}" autofocus required>
                @error('penyedia')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nomor" class="form-label">Nomor</label>
                <input type="text" class="form-control @error('nomor') is-invalid @enderror" id="nomor"
                    name="nomor" value="{{ old('nomor') }}" autofocus required>
                @error('nomor')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal"
                    name="tanggal" value="{{ old('tanggal') }}" autofocus required>
                @error('tanggal')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah"
                    name="jumlah" value="{{ old('jumlah') }}" autofocus required>
                @error('jumlah')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jangka_waktu" class="form-label">Jangka Waktu</label>
                <input type="number" class="form-control @error('jangka_waktu') is-invalid @enderror" id="jangka_waktu"
                    name="jangka_waktu" value="{{ old('jangka_waktu') }}" autofocus required>
                @error('jangka_waktu')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="bukti" class="form-label">Bukti</label>
                <select class="form-select" id="bukti" name="bukti">
                    <option value="1">Ya
                    </option>
                    <option value="0">Tidak
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label for="hps" class="form-label">HPS</label>
                <input type="number" class="form-control @error('hps') is-invalid @enderror" id="hps"
                    name="hps" value="{{ old('hps') }}" autofocus required>
                @error('hps')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="dokumen" class="form-label">Dokumen</label>
                <input type="text" class="form-control @error('dokumen') is-invalid @enderror" id="dokumen"
                    name="dokumen" value="{{ old('dokumen') }}" autofocus required>
                @error('dokumen')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </x-form_modal>
    <!-- Akhir Modal Tambah Pagu -->
@endsection
