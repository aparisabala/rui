@if ($paginator->hasPages())
    <div class="row mt-30">
        <div class="col-md-6 text-start">
            <div class="text-start">
                <p class="small text-muted m-0 p-0">
                    Showing
                    <span class="fw-semibold">{{ $paginator->perPage() }}</span>
                    to
                    <span class="fw-semibold">{{ $paginator->currentPage() }}</span>
                    of
                    <span class="fw-semibold">{{ $paginator->total() }}</span>
                    results
                </p>
            </div>
        </div>
        <div class="col-md-6">
           <div class="d-flex flex-row justify-content-end align-items-center">
            <nav aria-label="navigation text-right">
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-left"></i></a></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous"><i class="fas fa-angle-left"></i></a></li>
                    @endif
    
                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                        @endif
    
                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active"><a class="page-link" href="#">{{ $page }}</a></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
    
                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next"><i class="fas fa-angle-right"></i></a></li>
                    @else
                        <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-angle-right"></i></a></li>
                    @endif
                </ul>
            </nav>
           </div>
        </div>
    </div>
@endif
