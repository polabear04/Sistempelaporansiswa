<x-MainHeader /><!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">

        <div class="row">
            <!-- Profile Card -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src="{{ Auth::user()->foto_profile ?? asset('img/profile.png') }}" alt="avatar"
                            class="rounded-circle img-fluid d-block mx-auto"
                            style="width: 100px; height: 100px; object-fit: cover;">

                        <h5 class="my-3">{{ Auth::user()->nama }}</h5>
                        <p class="text-muted mb-1">{{ ucfirst(Auth::user()->role) }}</p>


                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('info'))
                            <div class="alert alert-info">
                                {{ session('info') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif



                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf

                            <!-- Nama -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Nama lengkap</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nama"
                                        value="{{ Auth::user()->nama }}">
                                </div>
                            </div>
                            <!-- Email -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email', Auth::user()->email) }}"
                                        @if (Auth::user()->hasVerifiedEmail()) disabled @endif>

                                    @if (!Auth::user()->hasVerifiedEmail())
                                        <div class="mt-2">
                                            <small class="text-danger">Email belum diverifikasi.</small><br>
                                            <button type="submit" formaction="{{ route('verification.send') }}"
                                                class="btn btn-sm btn-warning mt-1">
                                                Kirim ulang verifikasi
                                            </button>
                                        </div>
                                    @else
                                        <div class="mt-2">
                                            <small class="text-success">Email sudah diverifikasi.</small>
                                        </div>
                                    @endif
                                </div>
                            </div>



                            <!-- Alamat -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="alamat"
                                        value="{{ Auth::user()->alamat }}">
                                </div>
                            </div>

                            <!-- Tombol Simpan -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>



                    </div>
                </div>
            </div>

        </div>

    </div>

    <x-MainFooter />

</div>
