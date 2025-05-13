<x-MainHeader /><!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">

        <div class="row">
            <!-- Profile Card -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src="{{ Auth::user()->foto ? asset('img/' . Auth::user()->foto) : asset('img/profile.png') }}"
                            alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
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
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Nama lengkap</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nama"
                                        value="{{ Auth::user()->nama }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="posisi"
                                        value="{{ Auth::user()->posisi }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="email"
                                        value="{{ Auth::user()->email }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="alamat"
                                        value="{{ Auth::user()->alamat }}">
                                </div>
                            </div>

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
