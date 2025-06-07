<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sispes</title>

    {{-- CSS Skydash --}}
    <link rel="stylesheet" href="{{ asset('dashboard/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/vertical-layout-light/style.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/chats.css') }}">
    <link rel="shortcut icon" href="{{ asset('dashboard/images/favicon.png') }}" />


</head>

<body>
    <div class="container-scroller">

        {{-- Navbar --}}
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo mr-5" href="{{ URL::to('/index') }}">
                    <img src="{{ asset('dashboard/images/sispes_final.svg') }}" class="mr-2" alt="logo" />
                </a>
                <a class="navbar-brand brand-logo-mini" href="{{ URL::to('/index') }}">
                    <img src="{{ asset('dashboard/images/sispes_final.svg') }}" alt="logo" />
                </a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>

                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            <img src="{{ Auth::user()->foto ? asset('img/' . Auth::user()->foto) : asset('img/profile.png') }}"
                                alt="profile" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="{{ URL::to('profile') }}">
                                <i class="ti-settings text-primary"></i> Profile
                            </a>
                            <a class="dropdown-item" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="ti-power-off text-primary"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
            </div>
        </nav>

        <div class="container-fluid page-body-wrapper chat-container">

            {{-- Sidebar --}}
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">

                    {{-- Chat Room --}}
                    @if (in_array(Auth::user()->role, ['guru', 'murid']))
                        <li class="nav-item ">
                            <a class="nav-link no-auto-active" aria-expanded="false" href="{{ url('/chats') }}">
                                <i class="icon-skip-back menu-icon"></i>
                                <span class="menu-title">Kembali ke chat room</span>
                            </a>
                        </li>
                    @endif


                    {{-- User Pages --}}

                </ul>
            </nav>


            {{-- Chat Content --}}
            <div class="chat-content" style="flex: 1; padding: 2rem; background-color: #f5f7ff;">
                <div class="card" style="border-radius: 1.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    <div class="card-body" style="padding: 2rem;">
                        <h4 class="mb-4" style="font-weight: 600;">Chat</h4>

                        <p style="font-size: 1rem; color: #333;">
                            @if (auth()->user()->role == 'guru')
                                Chat dengan Murid: <strong>{{ $chat->murid->nama }}</strong>
                            @else
                                Chat dengan Guru: <strong>{{ $chat->guru->nama }}</strong>
                            @endif
                        </p>

                        <div class="chat-box"
                            style="border-radius: 0.75rem; background: #f1f4ff; padding: 1rem; height: 350px; overflow-y: auto; margin-top: 1rem; margin-bottom: 1.5rem;">
                            @foreach ($chat->messages as $message)
                                <div class="chat-message {{ $message->sender_id == auth()->id() ? 'text-right' : '' }}"
                                    style="margin-bottom: 1rem;">
                                    <div
                                        style="display: inline-block; padding: 0.75rem 1rem; border-radius: 1rem; background-color: {{ $message->sender_id == auth()->id() ? '#d1e7ff' : '#ffffff' }}; max-width: 70%;">
                                        <div style="font-weight: 600; margin-bottom: 0.25rem;">
                                            {{ $message->sender->nama }}</div>
                                        <div>{{ $message->message }}</div>
                                        <small
                                            style="display: block; margin-top: 0.25rem; font-size: 0.75rem; color: #666;">{{ $message->created_at->format('d M Y H:i') }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <form action="{{ route('chats.message.send', $chat->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <textarea name="message" rows="3" class="form-control" placeholder="Tulis pesan..."
                                    style="border-radius: 0.75rem; padding: 1rem;" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3"
                                style="border-radius: 0.5rem; padding: 0.5rem 1.5rem;">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>


        </div>

    </div>

    {{-- JS Skydash --}}
    <script src="{{ asset('dashboard/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('dashboard/js/off-canvas.js') }}"></script>
    <script src="{{ asset('dashboard/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('dashboard/js/template.js') }}"></script>
</body>

</html>
