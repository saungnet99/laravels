@extends('admin.layouts.index', ['header' => true, 'nav' => true, 'demo' => true])

@section('content')
<div class="page-wrapper">
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        {{ __('Overview') }}
                    </div>
                    <h2 class="page-title">
                        {{ __('Update Category') }}
                    </h2>
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
                {{-- Save Category --}}
                <div class="col-sm-12 col-lg-12">
                    <form action="{{ route('admin.update.blog.category', request()->segment(3)) }}" method="post" class="card">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="row">

                                        {{-- Category Name --}}
                                        <div class="col-md-6 col-xl-6">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('Name') }}</label>
                                                <input type="text" class="form-control text-capitalize" name="category_name" id="category_name" maxlength="200" value="{{ $blogCategoryDetails->blog_category_title }}" placeholder="{{ __('Eg: Blog title') }}" required>
                                            </div>
                                        </div>

                                        {{-- Category Slug --}}
                                        <div class="col-md-6 col-xl-6">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('Slug') }}</label>
                                                <input type="text" class="form-control" name="category_slug" id="category_slug" maxlength="200" value="{{ $blogCategoryDetails->blog_category_slug }}" placeholder="{{ __('Eg: blog-url') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <div class="d-flex">
                                <a href="{{ route('admin.blog.categories') }}" class="btn btn-outline-primary btn-md">{{ __('Cancel') }}</a>
                                <button type="submit" class="btn btn-primary btn-md ms-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-plus" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    @include('admin.includes.footer')
</div>

{{-- Custom JS --}}
@section('scripts')
<script>
// Convert slug
$('#category_name').on("change keyup paste click", function() {
    "use strict";
    var Text = $(this).val();
    Text = Text.toLowerCase();
    Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
    $('#category_slug').val(Text);
});
</script>
@endsection
@endsection