<x-MainHeader /><!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">



        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">

                    <div class="card-body">
                        <p class="card-title mb-2">Daftar Laporan</p>
                        <form method="GET" action="{{ url('draft') }}"
                            class="d-flex gap-4 align-items-center flex-wrap">
                            <input type="text" name="search" placeholder="Cari nama Pelaku"
                                value="{{ request('search') }}" class="form-input px-3 py-1 border rounded"
                                style="flex: 1 1 200px; min-width: 150px;" />

                            <select name="filter_date" class="form-select px-3 py-1 border rounded"
                                style="flex: 1 1 150px; min-width: 150px;">
                                <option value="">Semua data</option>
                                <option value="today" {{ request('filter_date') == 'today' ? 'selected' : '' }}>Hari
                                    Ini</option>
                                <option value="yesterday" {{ request('filter_date') == 'yesterday' ? 'selected' : '' }}>
                                    Kemarin</option>
                                <option value="last_7_days"
                                    {{ request('filter_date') == 'last_7_days' ? 'selected' : '' }}>7 Hari Terakhir
                                </option>
                            </select>

                            <button type="submit" class="btn btn-primary px-4 py-2 mx-2"
                                style="height: 33px; border-radius: 4px; flex: 0 0 auto;">Cari</button>
                        </form>

                        <div class="table-responsive">
                            @if (session('success'))
                                <div class="alert alert-success mb-3">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <table class="table table-striped table-borderless">
                                <thead>
                                    <tr>
                                        @auth
                                            @if (Auth::user()->is_admin)
                                                <th>NIS User</th>
                                            @endif
                                        @endauth
                                        <th>Id Laporan</th>
                                        <th>Nama Pelaku</th>
                                        <th>Deskripsi</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        @if (in_array(Auth::user()->role, ['guru', 'murid']))
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($laporan as $lapor)
                                        <tr>
                                            @auth
                                                @if (Auth::user()->is_admin)
                                                    <td>{{ $lapor->user->NIS ?? '-' }}</td>
                                                @endif
                                            @endauth
                                            <td>{{ $lapor->id_laporan }}</td>
                                            <td>{{ $lapor->nama }}</td>
                                            <td class="font-weight-bold">{{ Str::limit($lapor->deskripsi, 20) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($lapor->tanggal)->format('d M Y') }}</td>
                                            <td class="font-weight-medium">
                                                @if ($lapor->status === 'diterima')
                                                    <div class="badge badge-success">Diterima</div>
                                                @elseif($lapor->status === 'ditolak')
                                                    <div class="badge badge-danger">Ditolak</div>
                                                @else
                                                    <div class="badge badge-warning">Pending</div>
                                                @endif
                                            </td>
                                            @auth
                                                @if (in_array(Auth::user()->role, ['guru', 'murid']))
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <!-- Tombol Preview dengan target modal unik -->
                                                            <button type="button" class="btn btn-primary btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#modalPreview{{ $lapor->id_laporan }}">
                                                                Preview
                                                            </button>

                                                            <!-- Modal dengan ID unik sesuai laporan -->
                                                            <div class="modal fade"
                                                                id="modalPreview{{ $lapor->id_laporan }}" tabindex="-1"
                                                                role="dialog"
                                                                aria-labelledby="modalLabel{{ $lapor->id_laporan }}"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">

                                                                        <!-- Header -->
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="modalLabel{{ $lapor->id_laporan }}">
                                                                                Laporan
                                                                                lengkap</h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>

                                                                        <!-- Body -->
                                                                        <div class="modal-body">
                                                                            <form>
                                                                                @csrf
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="nama{{ $lapor->id_laporan }}">Nama</label>
                                                                                    <input type="text" name="nama"
                                                                                        class="form-control"
                                                                                        id="nama{{ $lapor->id_laporan }}"
                                                                                        value="{{ $lapor->nama }}"
                                                                                        disabled>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="deskripsi{{ $lapor->id_laporan }}">Deskripsi</label>
                                                                                    <textarea name="deskripsi" rows="5" class="form-control" id="deskripsi{{ $lapor->id_laporan }}" disabled>{{ $lapor->deskripsi }}</textarea>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="tanggal{{ $lapor->id_laporan }}">Tanggal</label>
                                                                                    <input type="text" name="tanggal"
                                                                                        class="form-control"
                                                                                        id="tanggal{{ $lapor->id_laporan }}"
                                                                                        value="{{ \Carbon\Carbon::parse($lapor->tanggal)->format('d M Y') }}"
                                                                                        disabled>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="foto{{ $lapor->id_laporan }}">Lampiran</label><br>
                                                                                    @if ($lapor->foto)
                                                                                        <!-- Gambar preview kecil -->
                                                                                        <img src="{{ asset('storage/' . $lapor->foto) }}"
                                                                                            alt="Foto Bukti"
                                                                                            class="img-thumbnail"
                                                                                            style="max-width: 150px; cursor: pointer;"
                                                                                            data-toggle="modal"
                                                                                            data-target="#modalFoto{{ $lapor->id_laporan }}">

                                                                                        <!-- Modal untuk gambar besar -->
                                                                                        <div class="modal fade"
                                                                                            id="modalFoto{{ $lapor->id_laporan }}"
                                                                                            tabindex="-1" role="dialog"
                                                                                            aria-labelledby="modalLabel{{ $lapor->id_laporan }}"
                                                                                            aria-hidden="true">
                                                                                            <div class="modal-dialog modal-dialog-centered modal-lg"
                                                                                                role="document">
                                                                                                <!-- modal-lg untuk lebar -->
                                                                                                <div class="modal-content">
                                                                                                    <div
                                                                                                        class="modal-header">
                                                                                                        <h5 class="modal-title"
                                                                                                            id="modalLabel{{ $lapor->id_laporan }}">
                                                                                                            Foto Bukti
                                                                                                            Kejadian</h5>
                                                                                                        <button
                                                                                                            type="button"
                                                                                                            class="close"
                                                                                                            data-dismiss="modal"
                                                                                                            aria-label="Tutup">
                                                                                                            <span
                                                                                                                aria-hidden="true">&times;</span>
                                                                                                        </button>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="modal-body text-center">
                                                                                                        <img src="{{ asset('storage/' . $lapor->foto) }}"
                                                                                                            alt="Foto Bukti"
                                                                                                            class="img-fluid rounded"
                                                                                                            style="max-height: 70vh; object-fit: contain;">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @else
                                                                                        <p class="text-muted">Tidak ada
                                                                                            lampiran</p>
                                                                                    @endif
                                                                                </div>



                                                                            </form>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <form
                                                                action="{{ route('laporan.destroy', $lapor->id_laporan) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Yakin ingin menghapus laporan ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger btn-sm">Hapus</button>

                                                                <a href="{{ route('laporan.cetak', $lapor->id_laporan) }}"
                                                                    class="btn btn-success btn-sm" target="_blank">
                                                                    Cetak PDF
                                                                </a>


                                                            </form>
                                                        </div>
                                                    </td>
                                                @endif
                                            @endauth

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">Tidak ada laporan yang di ajukan
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    <x-MainFooter />
