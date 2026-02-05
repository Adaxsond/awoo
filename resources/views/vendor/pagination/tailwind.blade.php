@if ($paginator->hasPages())
    <nav class="d-flex justify-content-center mt-4">
        <ul class="pagination">

            {{-- Tombol panah kiri --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&larr;</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">&larr;</a></li>
            @endif

            {{-- Tombol halaman --}}
            @foreach ($elements as $element)
                {{-- Tanda titik-titik jika perlu --}}
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Nomor halaman --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol panah kanan --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">&rarr;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&rarr;</span></li>
            @endif
        </ul>
    </nav>
@endif
