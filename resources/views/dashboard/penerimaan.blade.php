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
                                    @foreach ($laporan as $lapor)
                                        <tr>
                                            <td>{{ $lapor->id_laporan }}</td>
                                            <td>{{ $lapor->nama }}</td>
                                            <td class="font-weight-bold">{{ $lapor->deskripsi }}</td>
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
                                                        <button type="submit" class="btn btn-warning btn-sm"
                                                            onclick="return confirm('Tolak laporan ini?')">Tolak</button>
                                                    </form>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach

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
