<x-MainHeader /><!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">



        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">

                    <div class="card-body">
                        <p class="card-title mb-0">Daftar Laporan</p>

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
                                                <th>User</th>
                                            @endif
                                        @endauth
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
                                            @auth
                                                @if (Auth::user()->is_admin)
                                                    <td>{{ $lapor->user->nama ?? '-' }}</td>
                                                @endif
                                            @endauth
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
                                                <form action="{{ route('laporan.destroy', $lapor->id_laporan) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus laporan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
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
