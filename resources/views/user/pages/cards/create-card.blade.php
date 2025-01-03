@extends('user.layouts.index', ['header' => true, 'nav' => true, 'demo' => true, 'settings' => $settings])

{{-- Custom CSS --}}
@section('css')
<link href="{{ asset('css/cropper.min.css') }}" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.0.1/tinymce.min.js" integrity="sha512-KGtsnWohFUg0oksKq7p7eDgA1Rw2nBfqhGJn463/rGhtUY825dBqGexj8eP04LwfnsSW6dNAHAlOqKJKquHsnw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="{{ asset('css/all.css') }}" />
<style>
    .section-theme {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .theme-image {
        width: 70% !important;
        /* height: 70% !important; */
        margin-bottom: 1rem;
        border-radius: 32px;
    }

    .border-curve{
        border-radius: 16px;
    }


    .btn-choose-theme {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .avatar {
        --tblr-avatar-bg: #f6f8fb00;
    }

    .avatar-xl {
        --tblr-avatar-size: 10rem !important;
    }
</style>
@endsection

@php
$defaultImage = "";

foreach ($themes as $value => $theme) {
    $defaultImage = asset("img/vCards/premium-black.png");
    $themeId = "588969111086";
}
@endphp

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
                        {{ __('Create New Business Card') }}
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
                <div class="col-sm-12 col-lg-12">
                    <form action="{{ route('user.save.business.card') }}" method="post" enctype="multipart/form-data"
                        class="card">
                        @csrf
                        {{-- Create Card --}}
                        <div class="card-body">
                            <div class="row">
                                {{-- Themes --}}
                                <div class="col-md-4 col-xl-4 mb-5 text-center">
                                    <img src="{{ $defaultImage }}"
                                        class="object-contain theme-image" alt="" data-bs-toggle="modal"
                                        data-bs-target="#themeModal" >
                                    <a href="#" class="btn btn-primary btn-choose-theme" data-bs-toggle="modal"
                                        data-bs-target="#themeModal">
                                        {{ __('Choose a theme') }}
                                    </a>
                                </div>

                                {{-- Card details --}}
                                <div class="col-md-8 col-xl-8">
                                    <div class="row">
                                        <input type="hidden" class="form-control" name="theme_id" value="{{ $themeId }}">
                                        <input type="hidden" class="form-control" name="type" value="{{ Request::get('type') ? Request::get('type') : 'business' }}">

                                        <div class="{{ $plan_details->personalized_link ? 'col-md-6 col-xl-6' : 'col-md-8 col-xl-8' }}">
                                            <div class="mb-3">
                                                <label class="form-label required" for="card_lang">{{ __('Language') }}</label>
                                                <select name="card_lang" id="card_lang" class="form-control card_lang" required>
                                                    @foreach(config('app.languages') as $langLocale => $langName)
                                                    <option class="dropdown-item" value="{{ $langLocale }}" {{
                                                        $langLocale=='en' ? 'selected' : '' }}>
                                                        {{ $langName }} ({{ strtoupper($langLocale) }})
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xl-6">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('Sub Title') }}</label>
                                                <input type="text" class="form-control" name="subtitle"
                                                    value="{{ old('subtitle') }}"
                                                    placeholder="{{ __('Location / Job title') }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xl-6">
                                            <div class="mb-3">
                                                <div class="form-label required">{{ __('Cover type') }}</div>
                                                <select id="coverType" name="cover_type" class="form-control cover_type" required>

                                                    <option class="dropdown-item" value="youtube" selected >
                                                        {{ __('YouTube Video') }}
                                                    </option>

                                                    <option class="dropdown-item" value="youtube-ap" >
                                                        {{ __('YouTube Video - Autoplay') }}
                                                    </option>

                                                    <option class="dropdown-item" value="vimeo" >
                                                        {{ __('Vimeo Video') }}
                                                    </option>

                                                    <option class="dropdown-item" value="vimeo-ap" >
                                                        {{ __('Vimeo Video - Autoplay') }}
                                                    </option>

                                                    <option class="dropdown-item" value="photo" >
                                                        {{ __('Photo') }}
                                                    </option>

                                                    <option class="dropdown-item" value="none" >
                                                        {{ __('No cover') }}
                                                    </option>

                                                </select>

                                                <small>{{ __('Autoplay video will be muted due to browser policies')
                                                    }}</small>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xl-6" id="cover_url_col">
                                            <div class="mb-3">
                                                <label id="cover_url_label" class="form-label required">{{ __('Cover Video URL') }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text" id="cover_url_title" >
                                                       {{ __("https://www.youtube.com/watch?v=") }}
                                                    </span>
                                                    <input type="text" class="form-control" id="cover_url_input" name="cover_url" value="{{ old('cover_url') }}"
                                                        placeholder="{{ __('Video ID') }}" autocomplete="off"
                                                        minlength="3">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Cover Preview --}}
                                        <div class="col-md-6 col-xl-6 mb-3 d-none" id="coverNone">
                                            <span class="avatar avatar-xl w-100 me-3" id="coverPreview" style="background-position: left;border-radius:8px;"></span>
                                        </div>

                                        {{-- Logo Preview --}}
                                        <div class="col-md-6 col-xl-6 mb-3 d-none" id="logoNone">
                                            <span class="avatar avatar-xl w-100 me-3" id="logoPreview" style="background-size: contain; background-position: left;border-radius:8px;"></span>
                                        </div>

                                        <div class="col-md-6 col-xl-6" id="coverChooser">
                                            <div class="mb-3">
                                                <div class="form-label">{{ __('Cover') }}</div>
                                                <input type="file" class="form-control" id="cover"
                                                    placeholder="{{ __('Cover') }}"
                                                    accept=".jpeg,.jpg,.png,.gif,.svg" />
                                                <input type="hidden" class="form-control" name="cover">
                                                <small>{{ __('Recommended : 576 x 144 pixels')
                                                    }}</small>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xl-6">
                                            <div class="mb-3">
                                                <div class="form-label required">{{ __('Logo') }}</div>
                                                <input type="file" class="form-control" id="logo"
                                                    placeholder="{{ __('Logo') }}"
                                                    accept=".jpeg,.jpg,.png,.gif,.svg" required />
                                                <input type="hidden" class="form-control" name="logo">
                                                <small>{{ __('Recommended : 512 x 512 pixels') }}</small>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xl-6">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('Title') }}</label>
                                                <input type="text" class="form-control" name="title"
                                                    onload="convertToLink(this.value); checkLink()"
                                                    onkeyup="convertToLink(this.value); checkLink()"
                                                    value="{{ old('title') }}"
                                                    placeholder="{{ __('Business name / Your name') }}" required>
                                            </div>
                                        </div>

                                        @if ($plan_details->personalized_link)
                                        <div class="col-md-6 col-xl-6">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('Personalized Link') }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        {{ URL::to('/') }}
                                                    </span>
                                                    <input type="text" class="form-control" name="link"
                                                        placeholder="{{ __('Personalized Link') }}" autocomplete="off"
                                                        id="plink" onkeyup="checkLink()" value="{{ old('link') }}"
                                                        minlength="3" required>
                                                </div>
                                                <span id="status"></span>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="col-md-12 col-xl-12">
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('Description') }}</label>
                                                <textarea class="form-control" name="description" id="description"
                                                    data-bs-toggle="autosize"
                                                    placeholder="{{ __('About business / Bio') }}">{{ old('description') }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-xl-4 my-1">
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Submit') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('user.includes.footer')
</div>

{{-- Choose a theme modal --}}
<div class="modal modal-blur fade" id="themeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col">
                        <div class="input-group input-group-flat">
                            <input type="text" id="searchInput" class="form-control"
                                placeholder="{{ __('Search') }}">
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row" id="results">
                    @foreach ($themes as $theme)
                    <div class="col-lg-3 col-sm-3 col-md-3 col-6">
                        <label class="form-imagecheck mb-2">
                            <input type="radio" id="theme_id" value="{{ $theme->theme_id }}" onclick="chooseTheme(this, `{{ asset('img/vCards/'.$theme->theme_thumbnail) }}`)"
                                class="form-imagecheck-input theme_id" {{ $loop->first ? 'checked' : '' }} required />
                            <span class="text-center font-weight-bold">
                                <img src="{{ asset('img/vCards/'.$theme->theme_thumbnail) }}"
                                    class="object-cover border-curve" alt="{{ __($theme->theme_name) }}">
                                    <div class="text-center">
                                        <p class="badge bg-primary text-white m-1">
                                            {{ __($theme->theme_name) }}
                                        </p>
                                        @php
                                        $vidSupportedIds = ["588969111094","588969111095", "588969111093", "588969111092", "588969111091", "588969111090", "588969111089", "588969111088", "588969111087", "588969111086"];
                                        @endphp
                                        @if (in_array($theme->theme_id, $vidSupportedIds))
                                        <p class="badge bg-primary text-white m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Cover video supported for this theme') }}">
                                            <i class="fa-solid fa-video"></i>
                                        </p>
                                        @else
                                        <p class="badge bg-primary text-white m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Cover video not supported for this theme') }}">
                                            <i class="fa-solid fa-video-slash"></i>
                                        </p>
                                        @endif
                                    </div>
                            </span>
                        </label>

                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{--  Available theme for Cover image --}}
<div class="modal modal-blur fade" id="availableCoverImage" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">{{ __('Are you sure?') }}</div>
                <div>{{ __('Cover video not supported for this theme') }}</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ __('Continue') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Profile Image Cropping -->
<div id="cropModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Crop Image') }}</h4>
            </div>
            <div class="modal-body">
                <div class="cropper-container" style="width: 100%;">
                    <img id="croppedImage" style="max-width: 100%;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" id="crop">{{ __('Crop') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Profile cover Image Cropping -->
<div id="cropCoverModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Crop Image') }}</h4>
            </div>
            <div class="modal-body">
                <div class="cropper-container" style="width: 100%;">
                    <img id="croppedCoverImage" style="max-width: 100%;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-primary" id="coverCrop">{{ __('Crop') }}</button>
            </div>
        </div>
    </div>
</div>

{{-- Custom JS --}}
@push('custom-js')
<script type="text/javascript" src="{{ asset('js/tom-select.base.min.js') }}"></script>
<script src="{{ asset('js/cropper.min.js') }}"></script>
{{-- Profile image cropping --}}
<script>
    $(document).ready(function () {
        var cropper;
        var uploadedImageURL;

        // Initialize cropper when modal is shown
        $('#cropModal').on('shown.bs.modal', function () {
            cropper = new Cropper(document.getElementById('croppedImage'), {
                aspectRatio: 1, // Aspect ratio of 1:1
                viewMode: 3, // Set view mode to 3 (restrict the crop box to fit within the container, then scale the result image to fit exactly 512x512 pixels)
                autoCropArea: 1, // Auto crop the entire image
                cropBoxResizable: false, // Disable crop box resizing
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
        });

        // Handle image upload
        $('#logo').change(function (e) {
            var files = e.target.files;
            var reader = new FileReader();

            reader.onload = function (event) {
                uploadedImageURL = event.target.result;
                $('#croppedImage').attr('src', uploadedImageURL);
                $('#cropModal').modal('show');
            };

            reader.readAsDataURL(files[0]);
        });

        // Handle crop button click
        $('#crop').click(function () {
            var canvas = cropper.getCroppedCanvas({
                width: 512,
                height: 512,
            });

            canvas.toBlob(function (blob) {
                var formData = new FormData();
                formData.append('croppedImage', blob);

                // Include CSRF token in the AJAX request
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '{{ route("user.vcard.cropped.image") }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        // Optionally, close the modal after successful upload
                        $('#cropModal').modal('hide');

                        // Set the imageUrl in the #logo input field
                        $('input[name="logo"]').val(response.imageUrl);
                    },
                    error: function () {
                        console.log('Upload error');
                    }
                });
            });

            // Display cropped image preview in #logoPreview
            var croppedImageURL = cropper.getCroppedCanvas().toDataURL();
            $("#logoPreview").css('background-image', 'url(' + croppedImageURL + ')');
        });
    });
</script>

{{-- Profile cover image cropping --}}
<script>
    $(document).ready(function () {
        var cropper;
        var uploadedCoverImageURL;

        // Initialize cropper when modal is shown
        $('#cropCoverModal').on('shown.bs.modal', function () {
            cropper = new Cropper(document.getElementById('croppedCoverImage'), {
                aspectRatio: 16 / 4, // Aspect ratio of : 16:4
                viewMode: 3, // Set view mode to 3 (restrict the crop box to fit within the container, then scale the result image to fit exactly 512x512 pixels)
                autoCropArea: 1, // Auto crop the entire image
                cropBoxResizable: false, // Disable crop box resizing
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
        });

        // Handle image upload
        $('#cover').change(function (e) {
            var files = e.target.files;
            var reader = new FileReader();

            reader.onload = function (event) {
                uploadedCoverImageURL = event.target.result;
                $('#croppedCoverImage').attr('src', uploadedCoverImageURL);
                $('#cropCoverModal').modal('show');
            };

            reader.readAsDataURL(files[0]);
        });

        // Handle crop button click
        $('#coverCrop').click(function () {
            var canvas = cropper.getCroppedCanvas({
                width: 576,
                height: 192,
            });

            canvas.toBlob(function (coverBlob) {
                var formData = new FormData();
                formData.append('croppedImage', coverBlob);

                // Include CSRF token in the AJAX request
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '{{ route("user.vcard.cropped.image") }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        // Optionally, close the modal after successful upload
                        $('#cropCoverModal').modal('hide');

                        // Set the imageUrl in the #logo input field
                        $('input[name="cover"]').val(response.imageUrl);
                    },
                    error: function () {
                        console.log('Upload error');
                    }
                });
            });

            // Display cropped image preview in #coverPreview
            var croppedCoverImageURL = cropper.getCroppedCanvas().toDataURL();
            $("#coverPreview").css('background-image', 'url(' + croppedCoverImageURL + ')');
        });
    });
</script>
<script>
    function checkLink(){
    "use strict";
    var plink = $('#plink').val();

    if(plink.length > 0){
        $.ajax({
        url: "{{ route('user.check.link') }}",
        method: 'POST',
        data:{_token: "{{ csrf_token() }}", link: plink},
        }).done(function(res) {
            if(res.status == 'success') {
                $('#status').html("<span class='badge mt-2 bg-green text-white'>{{ __('Available') }}</span>");
            }else{
                $('#status').html("<span class='badge mt-2 bg-red text-white'>{{ __('Not available') }}</span>");
            }
        });
    }else{
        $('#status').html("");
    }
}

$(document).ready(function() {
   $(".modal").on("hidden.bs.modal", function() {
    $(".theme_id").prop('checked', false);
   });
 });

function chooseTheme(selectedTheme, thumbnail) {
    $("input[name='theme_id']").val(selectedTheme.value);
    $(".theme-image").attr("src", thumbnail);

    $("#themeModal").modal("hide");

    var vidSupportedIds = ["588969111094","588969111095", "588969111093", "588969111092", "588969111091", "588969111090", "588969111089", "588969111088", "588969111087", "588969111086"];
    if (vidSupportedIds.includes(selectedTheme.value)) {
       // Nothing to do.
    }else{
         $("#availableCoverImage").modal("show");
    }
}

/* Encode string to link */
function convertToLink( str ) {
    "use strict";
    //replace all special characters | symbols with a space
    str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ')
             .toLowerCase();

    // trim spaces at start and end of string
    str = str.replace(/^\s+|\s+$/gm,'');

    // replace space with dash/hyphen
    str = str.replace(/\s+/g, '-');
    document.getElementById("plink").value = str;
    //return str;
}

// Preview Cover
$(document).ready(() => {
    "use strict";

    const coverInp = $("#cover");
    let imgURL;

    coverInp.change(function (e) {
        $("#logoNone").removeClass('d-none');
        $("#coverNone").removeClass('d-none');

        imgURL = URL.createObjectURL(e.target.files[0]);
        $("#coverPreview").css('background-image', 'url(' + imgURL + ')');
    });
});

// Preview logo
$(document).ready(() => {
    "use strict";

    const logoInp = $("#logo");
    let imgURL;

    logoInp.change(function (e) {
        $("#logoNone").removeClass('d-none');
        $("#coverNone").removeClass('d-none');

        imgURL = URL.createObjectURL(e.target.files[0]);
        $("#logoPreview").css('background-image', 'url(' + imgURL + ')');
    });


    $("#coverType").change( function (){

        if(this.value == "vimeo-ap" || this.value == "vimeo"){
            $("#cover_url_title").text("https://vimeo.com/");
            $("#cover_url_label").attr("class", "form-label required");
            $("#cover_url_input").prop("required", true);
            $("#coverNone").addClass('d-none');
            // $("#logoNone").addClass('d-none');
            $("#coverChooser").addClass('d-none');
            $("#cover").prop("required", false);
            $("#cover_url_col").css("visibility", "visible");
        }

        if(this.value == "youtube-ap" || this.value == "youtube"){
            $("#cover_url_title").text("https://www.youtube.com/watch?v=");
            $("#cover_url_label").attr("class", "form-label required");
            $("#cover_url_input").prop("required", true);
            $("#coverNone").addClass('d-none');
            // $("#logoNone").addClass('d-none');
            $("#coverChooser").addClass('d-none');
            $("#cover").prop("required", false);
            $("#cover_url_col").css("visibility", "visible");
        }

        if(this.value == "photo"){
            $("#cover_url_label").attr("class", "form-label");
            $("#cover_url_input").prop("required", false);
            $("#cover").prop("required", true);
            // $("#logoNone").removeClass('d-none');
            $("#coverNone").removeClass('d-none');
            $("#coverChooser").removeClass('d-none');
            $("#cover_url_col").css("visibility", "hidden");
        }

        if(this.value == "none"){
            $("#cover_url_label").attr("class", "form-label");
            $("#cover_url_input").prop("required", false);
            $("#coverNone").addClass('d-none');
            $("#coverChooser").addClass('d-none');
            $("#cover_url_col").css("visibility", "hidden");
            $("#cover").prop("required", false);
        }

    });

    $("#coverType").val("youtube-ap").change();

});

var APP_URL = '{{ config('app.url') }}';

$(document).ready(function() {
"use strict";

$('#searchInput').on('keyup', function() {
    "use strict";

    let query = $(this).val();
    let type = 'vCard';

    $.ajax({
        url: '{{ route('user.search.theme') }}',
        type: 'GET',
        data: {
            query: query, type: type
        },
        dataType: 'json',
        success: function(response) {
            let output = '';
            if (response.length === 0) {
                output = '<div class="alert alert-warning">{{ __("No themes found.") }}</div>';
            } else {
                $.each(response, function(index, card) {
                    output += `<div class="col-lg-3 col-sm-3 col-md-3 col-6">
                                                        <label class="form-imagecheck mb-2">
                                                            <input type="radio" id="theme_id" value="${card.theme_id}" onclick="chooseTheme(this, '${APP_URL}/img/vCards/${card.theme_thumbnail}')" class="form-imagecheck-input theme_id" required />
                                                            <span class="form-imagecheck-figure text-center font-weight-bold">
                                                                <img src="${APP_URL}/img/vCards/${card.theme_thumbnail}"
                                                                    class="object-cover" alt="${card.theme_name}">
                                                            </span>
                                                        </label>
                                                        <div class="text-center">
                                                            <h2 class="badge bg-primary text-white mt-2">${card.theme_name}</h2>
                                                        </div>
                                                    </div>`;
                        });
                    }
                    $('#results').html(output);
                }
            });
        });
    });

    // Tiny MCE
    tinymce.init({
        selector: 'textarea#description',
        plugins: 'preview importcss searchreplace autolink autosave save directionality visualblocks visualchars link charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount charmap quickbars emoticons',
        menubar: 'file edit view insert format tools',
        toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | preview save print | insertfile link anchor | ltr rtl',
        content_style: 'body { font-family:Times New Roman,Arial,sans-serif; font-size:16px }',
        height : "200",
        menubar: false,
        statusbar: false,
    });
</script>
<script>
    // Array of element selectors
    var elementSelectors = ['.card_lang', '.cover_type'];

    // Function to initialize TomSelect and enforce the "required" attribute
    function initializeTomSelectWithRequired(el) {
        new TomSelect(el, {
            copyClassesToDropdown: false,
            dropdownClass: 'dropdown-menu ts-dropdown',
            optionClass: 'dropdown-item',
            controlInput: '<input>',
            maxOptions: null,
            render: {
                item: function(data, escape) {
                    if (data.customProperties) {
                        return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
                option: function(data, escape) {
                    if (data.customProperties) {
                        return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                    }
                    return '<div>' + escape(data.text) + '</div>';
                },
            },
        });
    
        // Ensure the "required" attribute is enforced
        el.addEventListener('change', function() {
            if (el.value) {
                el.setCustomValidity('');
            } else {
                el.setCustomValidity('This field is required');
            }
        });
    
        // Trigger validation on load
        el.dispatchEvent(new Event('change'));
    }

    // Loop through each element ID
    elementSelectors.forEach(function(id) {
        // Check if the element exists
        var elements = document.querySelectorAll(id);
        if (elements) {
            // Apply TomSelect and enforce the "required" attribute
            elements.forEach(function(el) {
                initializeTomSelectWithRequired(el);
            });
        }
    });
</script>
@endpush
@endsection