@if ($paginator->lastPage() > 1)
    <div class="d-flex justify-content-center">
        <ul class="pagination">
            <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
                @if ($paginator->currentPage() == 1)
                    <span><</span>
                @else
                    <a href="{{ $paginator->url($paginator->currentPage()-1) }}"><</a>
                @endif
            </li>
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                    <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
                @if ($paginator->currentPage() == $paginator->lastPage())
                    <span>></span>
                @else
                    <a href="{{ $paginator->url($paginator->currentPage()+1) }}">></a>
                @endif
            </li>
        </ul>
    </div>
@endif
