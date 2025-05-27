<x-MainHeader /><!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">



        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">

                    <div class="card-body">
                        <p class="card-title mb-0">Daftar Laporan di ajukan</p>

                        <div class="table-responsive">
                            <table class="table table-striped table-borderless">
                                <thead>
                                    <tr>
                                        <th>Id Laporan</th>
                                        <th>Nama</th>
                                        <th>Deskripsi</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($laporan as $lapor)
                                        <tr>
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
                                            <td>
                                                <button type="button" style="display:inline;"
                                                    class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#modalPreview{{ $lapor->id_laporan }}">
                                                    Preview
                                                </button>

                                                <!-- Modal dengan ID unik sesuai laporan -->
                                                <div class="modal fade" id="modalPreview{{ $lapor->id_laporan }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="modalLabel{{ $lapor->id_laporan }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">

                                                            <!-- Header -->
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="modalLabel{{ $lapor->id_laporan }}">Laporan
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
                                                                            value="{{ $lapor->nama }}" disabled>
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
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($lapor->status === 'pending')
                                                    <form action="{{ route('laporan.approve', $lapor->id_laporan) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm"
                                                            onclick="return confirm('Terima laporan ini?')">Terima</button>
                                                    </form>

                                                    <form action="{{ route('laporan.reject', $lapor->id_laporan) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Tolak laporan ini?')">Tolak</button>
                                                    </form>
                                                @endif

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">Tidak ada laporan yang di ajukan</td>
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
