@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img src="{{ url('img/logo-smk.png') }}" alt="Sistem Pelaporan Siswa" class="logo">
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
