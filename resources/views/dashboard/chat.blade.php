<x-MainHeader />

<div class="main-panel">
    <div class="content-wrapper">

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Daftar Chat</h4>

                        @if ($chats->isEmpty())
                            <p>Tidak ada chat.</p>
                        @else
                            <ul class="list-group">
                                @foreach ($chats as $chat)
                                    <li class="list-group-item">
                                        @if (auth()->user()->role == 'guru')
                                            <a href="{{ route('chats.show', $chat->id) }}">
                                                Chat dengan Murid: {{ $chat->murid->nama }}
                                            </a>
                                        @else
                                            <a href="{{ route('chats.show', $chat->id) }}">
                                                Chat dengan Guru: {{ $chat->guru->nama }}
                                            </a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- content-wrapper ends -->
    <x-MainFooter />
</div>
