<x-MainHeader /><!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Selamat datang {{ Auth::user()->nama }}</h3>

                        <h6 class="font-weight-normal mb-0">Ini adalah laporan dari akun anda
                        </h6>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card tale-bg">
                    <div class="card-people mt-auto">
                        <img src="dashboard/images/dashboard/people.svg" alt="people">
                        <div class="weather-info">
                            <div class="d-flex">
                                <div class="d-flex" id="weather-info">
                                    <div>
                                        <h2 class="mb-0 font-weight-normal" id="temperature"><i
                                                class="icon-sun mr-2"></i>--<sup>°C</sup></h2>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin transparent">
                <div class="row">
                    @if (Auth::user()->role == 'admin')
                        <div class="col-md-6 mb-4 stretch-card transparent">
                            <div class="card card-tale">
                                <div class="card-body">
                                    <p class="mb-4">Akun terdaftar :</p>
                                    <p class="fs-30 mb-2">{{ $totalUsers }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4 stretch-card transparent">
                            <div class="card card-dark-blue">
                                <div class="card-body">
                                    <p class="mb-4">Jumlah laporan masuk :</p>
                                    <p class="fs-30 mb-2">{{ $totalLaporan }}</p>
                                </div>
                            </div>
                        </div>
                    @elseif(Auth::user()->role == 'guru')
                        <div class="col-md-6 mb-4 stretch-card transparent">
                            <div class="card card-tale">
                                <div class="card-body">
                                    <p class="mb-4">Jumlah laporan yang diterima / ditolak :</p>
                                    <p class="fs-30 mb-2">{{ $laporanDisetujui }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4 stretch-card transparent">
                            <div class="card card-dark-blue">
                                <div class="card-body">
                                    <p class="mb-4">Jumlah laporan yang belum disetujui :</p>
                                    <p class="fs-30 mb-2">{{ $laporanDiajukan }}</p>
                                </div>
                            </div>
                        </div>
                    @elseif(Auth::user()->role == 'murid')
                        <div class="col-md-6 mb-4 stretch-card transparent">
                            <div class="card card-tale">
                                <div class="card-body">
                                    <p class="mb-4">Laporan Anda yang disetujui guru :</p>
                                    <p class="fs-30 mb-2">{{ $laporanSayaDisetujui }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4 stretch-card transparent">
                            <div class="card card-dark-blue">
                                <div class="card-body">
                                    <p class="mb-4">Jumlah laporan yang anda ajukan :</p>
                                    <p class="fs-30 mb-2">{{ $laporanSaya }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>

    <x-MainFooter />
