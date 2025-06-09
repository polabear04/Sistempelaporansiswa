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
                            <p class="card-title mb-0">List akun terdaftar</p>
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#exampleModal">
                                Daftarkan akun
                            </button>
                        </div>
                        <form method="GET" action="{{ url('akun') }}"
                            class="d-flex gap-4 align-items-center flex-wrap">
                            <input type="text" name="search" placeholder="Cari berdasarkan nama / NIS"
                                value="{{ request('search') }}" class="form-input px-3 py-1 border rounded"
                                style="flex: 1 1 200px; min-width: 150px;" />

                            <select name="filter_role" class="form-select px-3 py-1 border rounded"
                                style="flex: 1 1 150px; min-width: 150px;">
                                <option value="" {{ request('filter_role') == '' ? 'selected' : '' }}>Semua
                                    Role</option>
                                <option value="admin" {{ request('filter_role') == 'admin' ? 'selected' : '' }}>Admin
                                </option>
                                <option value="guru" {{ request('filter_role') == 'guru' ? 'selected' : '' }}>Guru
                                </option>
                                <option value="murid" {{ request('filter_role') == 'murid' ? 'selected' : '' }}>Murid
                                </option>
                            </select>

                            <button type="submit" class="btn btn-primary px-4 py-2 mx-2"
                                style="height: 33px; border-radius: 4px; flex: 0 0 auto;">Cari</button>
                        </form>
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
                                        @if ($errors->any())
                                            <div class="alert alert-danger mt-2">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <form action="{{ URL::to('addAkun') }}" method="POST"
                                            enctype="multipart/form-data">
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
                                                <input type="text" class="form-control" id="posisi" name="posisi"
                                                    placeholder="Masukkan Posisi" required>
                                            </div>

                                            <!-- Alamat -->
                                            <div class="form-group">
                                                <label for="alamat">Alamat</label>
                                                <input type="text" class="form-control" id="alamat" name="alamat"
                                                    placeholder="Masukkan Alamat" required>
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

                                            <!-- Role -->
                                            <div class="form-group">
                                                <label for="role">Role</label>
                                                <select class="form-control" id="role" name="role" required>
                                                    <option value="" disabled selected>Pilih Role</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="guru">Guru</option>
                                                    <option value="murid">Murid</option>
                                                </select>
                                            </div>

                                            <!-- Foto Profil -->
                                            <div class="form-group">
                                                <label for="foto_profile">Foto Profil</label>
                                                <input type="file" class="form-control-file" id=""
                                                    name="file" accept="image/*" required>
                                            </div>

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

                            @if (session('error'))
                                <div class="alert alert-danger mb-3">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <table class="table table-striped table-borderless">
                                <thead>
                                    <tr>
                                        <th>NIS/NIP</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
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
                                            <td>{{ $user->alamat }}</td>
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
                                                <!-- Tombol Edit -->
                                                <button type="button" class="btn btn-warning btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#editUserModal{{ $user->id }}">
                                                    Edit
                                                </button>

                                                <!-- Form Hapus -->
                                                <form action="{{ route('akun.delete', $user->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus akun ini?');"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit User (DI LUAR <tr>) -->
                                        <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="editUserModalLabel{{ $user->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <form action="{{ route('akun.update', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="editUserModalLabel{{ $user->id }}">Edit Data
                                                                User</h5>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">


                                                            <!-- Form Input -->
                                                            <div class="mb-3">
                                                                <label for="nis{{ $user->id }}"
                                                                    class="form-label">NIS</label>
                                                                <input type="text" name="NIS"
                                                                    class="form-control" id="nis{{ $user->id }}"
                                                                    value="{{ $user->NIS }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nama{{ $user->id }}"
                                                                    class="form-label">Nama</label>
                                                                <input type="text" name="nama"
                                                                    class="form-control" id="nama{{ $user->id }}"
                                                                    value="{{ $user->nama }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="email{{ $user->id }}"
                                                                    class="form-label">Email</label>
                                                                <input type="email" name="email"
                                                                    class="form-control"
                                                                    id="email{{ $user->id }}"
                                                                    value="{{ $user->email }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="password{{ $user->id }}"
                                                                    class="form-label">Password (opsional)</label>
                                                                <input type="password" name="password"
                                                                    class="form-control"
                                                                    id="password{{ $user->id }}">
                                                                <small class="text-muted">Kosongkan jika tidak ingin
                                                                    mengganti password</small>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="role{{ $user->id }}"
                                                                    class="form-label">Role</label>
                                                                <select name="role" id="role{{ $user->id }}"
                                                                    class="form-control" required>
                                                                    <option value="admin"
                                                                        {{ $user->role == 'admin' ? 'selected' : '' }}>
                                                                        Admin</option>
                                                                    <option value="guru"
                                                                        {{ $user->role == 'guru' ? 'selected' : '' }}>
                                                                        Guru</option>
                                                                    <option value="murid"
                                                                        {{ $user->role == 'murid' ? 'selected' : '' }}>
                                                                        Murid</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="alamat{{ $user->id }}"
                                                                    class="form-label">Alamat</label>
                                                                <textarea name="alamat" class="form-control" id="alamat{{ $user->id }}" rows="3" required>{{ $user->alamat }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan
                                                                Perubahan</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
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
