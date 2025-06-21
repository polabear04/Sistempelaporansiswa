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
                        <form action="{{ route('password.updateLogin') }}" method="POST">
                            @csrf

                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
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

                            @php
                                $fields = [
                                    ['label' => 'Password Lama', 'name' => 'old_password'],
                                    ['label' => 'Password Baru', 'name' => 'new_password'],
                                    ['label' => 'Konfirmasi Password Baru', 'name' => 'new_password_confirmation'],
                                ];
                            @endphp

                            @foreach ($fields as $index => $field)
                                <div class="row mb-3 position-relative">
                                    <label class="col-sm-3 col-form-label">{{ $field['label'] }}</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="password" class="form-control password-input"
                                                name="{{ $field['name'] }}" id="password{{ $index }}" required>
                                            <span class="input-group-text toggle-password" style="cursor: pointer">
                                                <i class="bi bi-eye-fill" data-index="{{ $index }}"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <button type="submit" class="btn btn-primary">Ubah Password</button>
                        </form>



                    </div>
                </div>
            </div>

        </div>

    </div>

    <x-MainFooter />

</div>
