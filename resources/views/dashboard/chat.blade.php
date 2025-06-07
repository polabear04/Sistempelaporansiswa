<x-MainHeader />

<div class="main-panel">
    <div class="content-wrapper">

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Daftar Chat</h4>

                        {{-- 🔍 FORM PENCARIAN --}}
                        <form method="GET" action="{{ route('chats.index') }}" class="d-flex gap-2 mb-4"
                            style="flex-wrap: wrap;">
                            <input type="text" name="search" placeholder="Cari nama" value="{{ request('search') }}"
                                class="form-input px-3 py-1 border rounded"
                                style="flex: 1 1 200px; min-width: 150px;" />

                            <select name="filter_date" class="form-select px-3 py-1 border rounded"
                                style="flex: 1 1 150px; min-width: 150px;">
                                <option value="">Semua data</option>
                                <option value="today" {{ request('filter_date') == 'today' ? 'selected' : '' }}>Hari
                                    Ini</option>
                                <option value="yesterday" {{ request('filter_date') == 'yesterday' ? 'selected' : '' }}>
                                    Kemarin</option>
                                <option value="last_7_days"
                                    {{ request('filter_date') == 'last_7_days' ? 'selected' : '' }}>7 Hari Terakhir
                                </option>
                            </select>

                            <button type="submit" class="btn btn-primary px-4 py-2"
                                style="height: 33px; border-radius: 4px;">Cari</button>
                        </form>

                        {{-- DAFTAR CHAT --}}
                        @if ($chats->isEmpty())
                            <p>Tidak ada chat.</p>
                        @else
                            <ul class="list-group">
                                @foreach ($chats as $chat)
                                    <li class="list-group-item">
                                        @if (auth()->user()->role == 'guru')
                                            <a href="{{ route('chats.show', $chat->id) }}">
                                                Chat dengan Murid: {{ $chat->murid->nama }},
                                                dengan kasus {{ $chat->laporan->deskripsi }}
                                            </a>
                                        @else
                                            <a href="{{ route('chats.show', $chat->id) }}">
                                                Chat dengan Guru: {{ $chat->guru->nama }},
                                                dengan kasus {{ $chat->laporan->deskripsi }}
                                            </a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>

                            {{-- PAGINATION --}}
                            <div class="mt-4">
                                {{ $chats->links() }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

    </div>
    <x-MainFooter />
</div>
