@extends('user.layouts.index', ['header' => true, 'nav' => true, 'demo' => true, 'settings' => $settings])

@section('content')
<div class="page-wrapper">
    <!-- Page title -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        {{ __('Overview') }}
                    </div>
                    <h2 class="page-title">
                        {{ __('Categories') }}
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <a href="{{ route('user.create.category') }}" class="btn btn-icon btn-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ __('Create new') }}">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon d-lg-none d-inline" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        <span class="d-lg-inline d-none">{{ __('Create new') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            {{-- Failed --}}
            @if(Session::has("failed"))
            <div class="alert alert-important alert-danger alert-dismissible mb-2" role="alert">
                <div class="d-flex">
                    <div>
                        {{Session::get('failed')}}
                    </div>
                </div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
            @endif

            {{-- Success --}}
            @if(Session::has("success"))
            <div class="alert alert-important alert-success alert-dismissible mb-2" role="alert">
                <div class="d-flex">
                    <div>
                        {{Session::get('success')}}
                    </div>
                </div>
                <a class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
            @endif
            
            <div class="row row-deck row-cards">
                <div class="col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table" id="categoriesTable">
                                <thead>
                                    <tr>
                                        <th>{{ __('S.No') }}</th>
                                        <th>{{ __('Created At') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th class="w-1">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('user.includes.footer')
</div>

{{-- Status --}}
<div class="modal modal-blur fade" id="statusModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">{{ __('Are you sure?')}}</div>
                <div>{{ __('If you proceed, you will enabled/disabled this category.')}}</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary me-auto" data-bs-dismiss="modal">{{
                    __('Cancel')}}</button>
                <a class="btn btn-danger" id="category_id">{{ __('Yes, proceed')}}</a>
            </div>
        </div>
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
                <button type="button" class="btn btn-outline-primary me-auto" data-bs-dismiss="modal">{{
                    __('Cancel')}}</button>
                <a class="btn btn-danger" id="delete_id">{{ __('Yes, proceed')}}</a>
            </div>
        </div>
    </div>
</div>

{{-- Custom JS --}}
@section('scripts')
<script>
    $(document).ready(function() {
        "use strict";
        
        $('#categoriesTable').DataTable({
            processing: false,
            serverSide: true,
            ajax: '{{ route('user.categories') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'created_at', name: 'created_at' },
                { data: 'category_name', name: 'category_name' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });

    function updateStatus(id) {
        "use strict";

        $("#statusModal").modal("show");
        var link = document.getElementById("category_id");
        link.getAttribute("href");
        link.setAttribute("href", "{{ route('user.status.category') }}?id=" + id);
    }

    function deleteCategory(id, action) {
        "use strict";

        $("#delete-modal").modal("show");
        var delete_status = document.getElementById("delete_status");
        delete_status.innerHTML = "<?php echo __('If you proceed, you will') ?> " + action + " <?php echo __('this category and your products assosicated with this category may not show in your store page.') ?>"
        var delete_link = document.getElementById("delete_id");
        delete_link.getAttribute("href");
        delete_link.setAttribute("href", "{{ route('user.delete.category') }}?id=" + id);
    }
</script>
@endsection
@endsection