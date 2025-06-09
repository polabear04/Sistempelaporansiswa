<x-MainHeader />
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">



        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <!-- Header: Judul + Tombol di kanan -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <p class="card-title mb-0">List akun guru</p>
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#exampleModal">
                                Daftarkan akun
                            </button>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">

                                    <!-- Header -->
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambahkan akun baru</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <!-- Body dengan Form -->
                                    <div class="modal-body">

                                        <form action="{{ URL::to('addAkun') }}" method="POST">
                                            @csrf
                                            <!-- NIS/NIP -->
                                            <div class="form-group">
                                                <label for="NIS">NIS/NIP</label>
                                                <input type="text" class="form-control" id="NIS" name="NIS"
                                                    placeholder="Masukkan NIS" required>
                                            </div>

                                            <!-- Nama -->
                                            <div class="form-group">
                                                <label for="nama">Nama</label>
                                                <input type="text" class="form-control" id="nama" name="nama"
                                                    placeholder="Masukkan Nama" required>
                                            </div>

                                            <!-- Posisi -->
                                            <div class="form-group">
                                                <label for="posisi">Posisi</label>
                                                <input type="posisi" class="form-control" id="posisi" name="posisi"
                                                    placeholder="Masukkan posisi" required>
                                            </div>


                                            <!-- Email -->
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="Masukkan Email" required>
                                            </div>

                                            <!-- Password -->
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" id="password"
                                                    name="password" placeholder="Masukkan Password" required>
                                            </div>
                                            <select class="form-control" id="role" name="role" required>
                                                <option value="" disabled selected>Pilih Role</option>
                                                <option value="admin">Admin</option>
                                                <option value="guru">Guru</option>
                                                <option value="murid">Murid</option>
                                            </select>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            @if (session('success'))
                                <div class="alert alert-success mb-3">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <table class="table table-striped table-borderless">
                                <thead>
                                    <tr>
                                        <th>NIS/NIP</th>
                                        <th>Nama</th>
                                        <th>Posisi</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th>Role</th>
                                        <th>Verifikasi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            <td>{{ $user->NIS }}</td>
                                            <td>{{ $user->nama }}</td>
                                            <td>{{ $user->posisi }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>********</td>
                                            <td class="fw-bold">{{ $user->role }}</td>
                                            <td>
                                                @if ($user->email_verified_at)
                                                    <span class="badge bg-success">Terverifikasi</span>
                                                @else
                                                    <span class="badge bg-danger">Belum Terverifikasi</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('akun.delete', $user->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus laporan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">Tidak ada akun yang terdaftar</td>
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
