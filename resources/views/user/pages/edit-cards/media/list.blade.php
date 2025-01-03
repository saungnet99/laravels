{{-- Alert message --}}
<div id="showAlert"></div>
            
{{-- Media images --}}
<div class="row" id="mediaCardsContainer"></div>

{{-- Empty media --}}
<div class="row" id="noImagesFound">
    <div class="col-sm-12 col-lg-12">
        <div class="container-xl d-flex flex-column justify-content-center">
            <div class="empty">
                <div class="empty-img">
                    <img id="empty" src="{{ asset('img/empty.svg') }}" height="128" alt="">
                </div>
                <p class="empty-title">{{ __('No images found') }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Pagination --}}
<div class="card pagination-card" id="showPagination">
    <div class="card-footer pagination-card-footer d-flex align-items-center" id="paginationLinks">
        <p class="m-0 text-muted">{{ __('') }} <span id="paginationStartIndex"></span> {{ __('to') }}
            <span id="paginationEndIndex"></span> {{ __('of') }} <span id="paginationTotalCount"></span> {{ __('results') }}
        </p>
        <nav class="custom-nav">
            <ul class="pagination">
                <li class="btn btn-sm btn-primary li-link" id="prevPageBtn" onclick="loadPreviousPage()">{{ __('Previous') }}</li>
                <li class="btn btn-sm btn-primary li-link" id="nextPageBtn" onclick="loadNextPage()">{{ __('Next') }}</li>
            </ul>
        </nav>
    </div>
</div>

{{-- Delete --}}
<div class="modal modal-blur fade" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">{{ __('Are you sure?')}}</div>
                <div id="delete_status"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary btn-md me-auto" data-bs-dismiss="modal">{{
                    __('Cancel')}}</button>
                <a class="btn btn-danger btn-md" id="delete_id">{{ __('Yes, proceed')}}</a>
            </div>
        </div>
    </div>
</div>