<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $card_details->title }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ url($business_card_details->profile) }}" sizes="512x512" type="image/png" />
    <link rel="apple-touch-icon" href="{{ url($business_card_details->profile) }}">

    <meta name="theme-color" content="#ffffff" />

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="application-name" content="{{ $card_details->title }}">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-title" content="{{ $card_details->title }}">

    <!-- Tile for Win8 -->
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ url($business_card_details->profile) }}">

    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}

    <!-- CSS files -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    {{-- <link rel="stylesheet" href="{{ url('app/css/tailwind.min.css') }}"> --}}
    <script src="{{ url('js/app.js') }}"></script>
    <link rel="stylesheet" href="{{ url('css/fontawesome.min.css') }}" />
    <link rel="stylesheet" href="{{ url('app/css/style.css') }}" />
    <link rel="stylesheet" href="{{ url('templates/css/gobiz-vcard-styles.css') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <script type="text/javascript" src="{{ url('js/sweetalert.min.js') }}"></script>

    <!-- Include the qrious library -->
    <script src="{{ url('js/qrious.min.js') }}"></script>

    <!-- Flatpickr CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    {{-- Check business details --}}
    @if ($business_card_details != null)
        <style>
            {!! $business_card_details->custom_css !!} .heading {
                font-family: 'Poppins', sans-serif;
                font-size: 26px !important;
            }

            .bg-custom {
                background: #D31027;
                /* fallback for old browsers */
                background: -webkit-linear-gradient(to right, #EA384D, #D31027);
                /* Chrome 10-25, Safari 5.1-6 */
                background: linear-gradient(to right, #EA384D, #D31027);
                /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            }

            .sub-heading {
                font-family: 'Poppins', sans-serif;
            }

            #content {
                display: none;
            }

            .z-index-9999 {
                z-index: 9999;
            }
        </style>
    @endif

    {{-- Check PWA --}}
    @if ($plan_details != null)
        @if ($plan_details['pwa'] == 1)
            @laravelPWA

            <!-- Web Application Manifest -->
            <link rel="manifest" href="{{ $manifest }}">
        @endif
    @endif
</head>

@php
    use Illuminate\Support\Facades\Session;
    $business_card_details->theme_color = 'red-600';
@endphp

<body class="antialiased bg-grey-lighter text-body font-body"
    dir="{{ App::isLocale('ar') || App::isLocale('ur') || App::isLocale('he') ? 'rtl' : 'ltr' }}">
    {{-- Page loader --}}
    <div id="preloader" class="fixed top-0 left-0 w-screen h-screen flex justify-center items-center bg-gray-900 z-50">
        <div class="animate-spin rounded-full h-32 w-32 border-t-2 border-b-2 border-gray-100"></div>
    </div>

    <div id="content" class="hidden">
        {{-- Check password protected --}}
        @if ($business_card_details->password == null || Session::get('password_protected') == true)
            @if ($business_card_details != null)
                <div id="profile" class="leading-tight min-h-screen lg:bg-cover lg:bg-scroll shadow-xl">

                    <div class="lg:p-2"></div>

                    <div
                        class="max-w-xl w-full mx-auto bg-white border-2 overflow-hidden border-black relative {{ $business_card_details->cover ? '' : 'pt-48' }}">


                        {{-- Cover Photo --}}
                        @if ($business_card_details->cover_type == 'photo')
                            <div class="bottom-style-100">
                                <div class="bg-cover bg-center h-48"
                                    style="background-image: url('{{ url($business_card_details->cover) }}'); "></div>
                            </div>
                        @endif

                        {{-- Cover Vimeo AP --}}
                        @if ($business_card_details->cover_type == 'vimeo-ap')
                            <div class="bottom-style-100">
                                <div class="bg-cover bg-center h-60">

                                    <iframe id="vid-player"
                                        src="https://player.vimeo.com/video/{{ $business_card_details->cover }}?autoplay=1&loop=1&autopause=0&muted=1&controls=0"
                                        frameborder="0" allow="autoplay;"></iframe>

                                </div>
                            </div>
                        @endif

                        {{-- Language Switcher --}}
                        @include('templates.includes.language-switcher')

                        {{-- Cover Vimeo --}}
                        @if ($business_card_details->cover_type == 'vimeo')
                            <div class="bottom-style-100">
                                <div class="bg-cover bg-center h-60">

                                    <iframe id="vid-player"
                                        src="https://player.vimeo.com/video/{{ $business_card_details->cover }}?autoplay=0&loop=1&autopause=0&muted=0&controls=1"
                                        frameborder="0" allow="autoplay;"></iframe>

                                </div>
                            </div>
                        @endif


                        {{-- Cover YouTube AP --}}
                        @if ($business_card_details->cover_type == 'youtube-ap')
                            <div class="bottom-style-100">
                                <div class="bg-cover bg-center h-60">

                                    <iframe id="vid-player"
                                        src="https://www.youtube.com/embed/{{ $business_card_details->cover }}?autoplay=1&mute=1&controls=0&loop=1"
                                        frameborder="0" allow="autoplay;"></iframe>

                                </div>
                            </div>
                        @endif


                        {{-- Cover YouTube --}}
                        @if ($business_card_details->cover_type == 'youtube')
                            <div class="bottom-style-100">
                                <div class="bg-cover bg-center h-60">

                                    <iframe id="vid-player"
                                        src="https://www.youtube.com/embed/{{ $business_card_details->cover }}?autoplay=0&mute=0&controls=1&loop=1"
                                        frameborder="0" allow="autoplay;"></iframe>

                                </div>
                            </div>
                        @endif




                        <div class="border-b mt-2 px-4 pt-3 flex flex-row">

                            <div class="text-center bg-white p-2 sm:text-left sm:flex mb-2  w-1/2">
                                <img class="rounded-full h-24 w-24 border-2 border-white mr-4 md:ml-24 lg:ml-12 profile"
                                    src="{{ url($business_card_details->profile) }}"
                                    alt="{{ $business_card_details->title }}" />
                            </div>

                            <div class="w-full p-2 bg-white">
                                <div class="pt-2 pb-3">

                                    <div class="inline">

                                        <h3 class="font-bold inline heading text-gray-800 text-2xl mb-1">
                                            {{ $business_card_details->title }}

                                        </h3>

                                        <img class="inline h-5 w-5 mb-2"
                                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAEqUlEQVR4nO2Z20+aZxzH3/ZiHmACShFQDjarnduF+wOWmEjVeqoKyFFRwHTJbvYnkIjDQ1cQFZSqYFtbrIebJo12m96ZLNnabBfatOnU9GKRddU168WatfkuD7Or1sPLC7zYC77Jc/1+vg+/53l+vy8UlVZaaSVdirC1Wh5uW5CF27cLw5Zt2U3LQsGkpZp636UI20vkt6x35FPtkIfbIQu3QXbTgsIbFhROtkJ63bwonTR9dtycVOG0Pbdo1t6jnLE9UMzYnyunbVBMW6G4ZcVh8AXXW/5b18yQXjVDOmGCJGR4LgkaV8VBQ7fcbxKkBP709EV50VzHhnLWDuWMHXHDTxghCRkhDhogHjdANKpblwb1MnbpHY6Tyjn7crLh88f0yB/TQTTavEy+wRp/0WyHnT14HURXmiEMaGyswBffvihUzNgibMKLAloIA9qIJGAUJo8c1AnlXIdFMWPbZBv+FFkjGgj96mdCn/qrhMuJHFh2a163H344agB5vibkDTUtC3wNsvivShZum5jhfU3IHWpE7mDjGs9fy/yKLZrr6H0P4CEYaIBg4IKLsQHySKUEflgDoU8N4Q74AfDg99evxGHA/oJ1eL8aEo8aX9zuw2mvHnmDjfvgBd4L4Hnq/mJsQDFte8k2vNjdhPlHP4Do0R9PcHbQjFxvwx54fn89+O66v+MwYH3F6s671fju8Y/Yrfu/PQS/t2YvvKcOPHfdP4zglVPW0lTDvzVQ/S48eO5a8C/Xlsa++1PWb2nhr5ogDZogDcVfNrv18OkTFHsNEHjq98HnXK7Fh5eql2IfRujgQyZ8PNaOL+fdkI0YIBk3JLTzq5F1fNSvPxQ+55saYoAs+qGITFJ08J+O2bD6dCP68aWN+5D5dBCP6lnZ+Zy38OD2nV+gNUDGwKNqXuxvxi+bj/dAfL/2EwoGm5FPoNnZeXD7zoPTW/UnrYGdGfbQAyv2afHzOwbemJAOaCEa0bICz+2tAqencov+F7jROn/kbTNuwCej7f+X0G4trd1DgVcTfV2TWDYg8NyeKnC6K+ZpDZD0gPaqHNOjJNB2oInFtXuQ9mtYgK9Edk9FbMlGwbWWu7T3/BUdSgKWA02QkklW2XDfwLsqF2OC3zFQGtMjFWjGWX8rVn9f3webzJ3nEAPdlbE/ZETSCfOrmF7YYQ2KfS1YOcJEwvCuCmatBJEkZHrJ5IUtHjJjJbLOBjyyu1TMmzlJyPCC0TAy1IQzA8Y9JpIC//U5ZHWdY95Oi4OGB4wnqcFGnPEao00ZWfEeWM5eeGR1qpgPNCTui2sM9DZEW+JoV5kMeKcKGU5VF2MDJKskcV+cM+yBLXE88JnO8l953Z/Hl5uSrJLEfccFn9GpWs5ylBVSCQnUiVPDWotwRLOZKvhMZ/mzDzrLEw+2dovEfXnDmkgK4CNcR1kSo8VdEvrU9hSUjY1iTQ7HSRL3sVnzFJvxOhHJKkncx8Ztk5XwgY1RJKskcR9JzPie+i2+p/Y1c3jV60ynaos8UhnOchfPUcanjltcT01JzqWaO0e1xNldFcf/Jx+dSHpABnBOT9U2p7tqm+OqXIh5GEkrrbQoJvoXZTdWgBhNh8sAAAAASUVORK5CYII=">


                                    </div>

                                    <p class="text-gray-800">{{ $card_details->sub_title }}</p>

                                </div>
                            </div>
                        </div>

                        @if ($business_card_details->description != null || $business_card_details->address != null)
                            <div class="pb-3 pt-3 text-left px-5 text-gray-800 border-b">
                                {!! $business_card_details->description !!}
                            </div>
                        @endif


                        <div class="grid grid-cols-1">

                            @foreach ($feature_details as $feature)
                                @if ($feature->type != 'iframe' && $feature->type != 'youtube' && $feature->type != 'map' && $feature->type != 'text')
                                    <ul
                                        class="bg-white transition ease-in-out border-2 border-black m-3 hover:bg-red-400 hover:transition-all">
                                        @if ($feature->type == 'email')
                                            <a class="break-word" href="mailto:{{ $feature->content }}">
                                        @endif

                                        @if ($feature->type == 'tel')
                                            <a class="break-word" href="tel:{{ $feature->content }}">
                                        @endif

                                        @if ($feature->type == 'wa')
                                            <a class="break-word" href="http://wa.me/{{ $feature->content }}"
                                                rel="noopener nofollow noreferrer" target="_blank">
                                        @endif

                                        @if (
                                            $feature->type == 'url' ||
                                                $feature->type == 'facebook' ||
                                                $feature->type == 'instagram' ||
                                                $feature->type == 'x-twitter' ||
                                                $feature->type == 'linkedin' ||
                                                $feature->type == 'pinterest' ||
                                                $feature->type == 'reddit' ||
                                                $feature->type == 'tiktok' ||
                                                $feature->type == 'threads' ||
                                                $feature->type == 'snapchat' ||
                                                $feature->type == 'wechat' ||
                                                $feature->type == 'telegram' ||
                                                $feature->type == 'tumblr' ||
                                                $feature->type == 'qq' ||
                                                $feature->type == 'discord' ||
                                                $feature->type == 'quora')
                                            <a class="break-all"
                                                href="https://{{ str_replace('https://', '', $feature->content) }}"
                                                rel="noopener nofollow noreferrer" target="_blank">
                                        @endif


                                        <li>
                                            <div class="flex place-content-center items-center">

                                                <div class="mx-5 my-2">
                                                    <p
                                                        class="font-semibold text-gray-800 break-word text-lg sub-heading">
                                                        <i class="{{ $feature->icon }}"></i> &nbsp;
                                                        {{ $feature->label }}
                                                    </p>
                                                    <p class="font-semibold text-gray-800 break-word text-sm">
                                                        {{ $feature->content }}</p>
                                                </div>
                                            </div>
                                        </li>

                                        @if (
                                            $feature->type == 'url' ||
                                                $feature->type == 'facebook' ||
                                                $feature->type == 'instagram' ||
                                                $feature->type == 'x-twitter' ||
                                                $feature->type == 'linkedin' ||
                                                $feature->type == 'pinterest' ||
                                                $feature->type == 'reddit' ||
                                                $feature->type == 'tiktok' ||
                                                $feature->type == 'threads' ||
                                                $feature->type == 'snapchat' ||
                                                $feature->type == 'wechat' ||
                                                $feature->type == 'telegram' ||
                                                $feature->type == 'tumblr' ||
                                                $feature->type == 'qq' ||
                                                $feature->type == 'discord' ||
                                                $feature->type == 'quora' ||
                                                $feature->type == 'wa' ||
                                                $feature->type == 'tel' ||
                                                $feature->type == 'email')
                                            </a>
                                        @endif

                                    </ul>
                                @endif
                            @endforeach
                        </div>

                        {{-- Custom Text --}}
                        @if ($customTexts != null && !$customTexts->isEmpty())
                            @foreach ($customTexts as $customText)
                                <div class="bg-custom w-full mt-4 mb-4 flex justify-center align-middle py-2">
                                    <p class="heading font-black text-white text-xl px-4 py-2">
                                        {{ __($customText->label) }}</p>
                                </div>

                                <div class="px-5 py-2">
                                    <div class="w-full">
                                        <p class="pb-3 pt-3 text-gray-800">
                                            {{ $customText->content }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        {{-- Services --}}
                        @if ($service_details != null && !$service_details->isEmpty())
                            <div class="bg-custom w-full mt-4 mb-4 flex justify-center align-middle py-2">
                                <p class="heading font-black text-white text-xl px-4 py-2">{{ __('Services') }}</p>
                            </div>

                            <div class="px-5 py-4 grid grid-cols-2 gap-2">
                                @foreach ($service_details as $service_detail)
                                    <div class="mb-3">
                                        <div class="w-full overflow-hidden border-2 border-black">
                                            <a href="{{ url($service_detail->service_image) }}"
                                                data-toggle="lightbox" data-gallery="gallery" class="col-md-4">
                                                <img class="w-full" src="{{ url($service_detail->service_image) }}"
                                                    alt="{{ $service_detail->service_name }}" style="width: 100%; height: 200px; object-fit: cover;" />
                                            </a>
                                            <div class="px-5 py-3">
                                                <div class="mb-2">
                                                    <div class="text-gray-800 font-semibold text-lg mb-2 sub-heading">
                                                        {{ $service_detail->service_name }}
                                                    </div>
                                                    <p class="text-grey-800 text-base">
                                                        {{ $service_detail->service_description }}
                                                    </p>
                                                </div>

                                                @if ($enquiry_button != null)
                                                    @if (($whatsAppNumberExists == true && $whatsAppNumberExists == true) && $service_detail->enable_enquiry == 'Enabled')
                                                        <div class="mt-5 mb-2">
                                                            <a href="https://wa.me/{{ $enquiry_button }}?text={{ __('Hi, I am interested in your product/service:') }} {{ $service_detail->service_name }}. {{ __('Please provide more details.') }}"
                                                                rel="noopener nofollow noreferrer" target="_blank"
                                                                class="sub-heading w-full block text-center bg-{{ $business_card_details->theme_color }} font-semibold hover:bg-{{ $business_card_details->theme_color }} text-white antialiased px-4 py-2">
                                                                {{ __('Make Inquiry') }}
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Products --}}
                        @if ($product_details != null && !$product_details->isEmpty())

                            <div class="bg-custom w-full mt-4 mb-4 flex justify-center align-middle py-2">
                                <p class="heading font-black text-white text-xl px-4 py-2">{{ __('Products') }}</p>
                            </div>

                            <div class="px-1 py-1 bg-cover bg-scroll grid grid-cols-2">
                                @foreach ($product_details as $product_detail)
                                    <div class="w-full lg:w-full p-2">
                                        <div class="p-4 bg-white border-2 border-black">
                                            <div class="w-full mb-2">
                                                <img class="rounded-lg pb-2"
                                                    id="{{ $product_detail->product_id }}_product_image"
                                                    src="{{ url($product_detail->product_image) }}"
                                                    alt="{{ $product_detail->product_name }}" style="width: 100%; height: 200px; object-fit: cover;">
                                            </div>
                                            <b
                                                class="py-1 px-2 bg-red-600 rounded text-white">{{ $product_detail->badge }}</b>

                                            <div class="mb-2 mt-3 justify-between  w-full items-center">
                                                <div class="text-gray-800 font-semibold text-lg mb-2">
                                                    <h3 id="{{ $product_detail->product_id }}_product_name"
                                                        class="sub-heading">
                                                        {{ $product_detail->product_name }}</h3>
                                                </div>
                                                <p class="text-grey-800 text-base">
                                                    <span
                                                        id="{{ $product_detail->product_id }}_subtitle">{{ $product_detail->product_subtitle }}</span>
                                                </p>
                                            </div>


                                            <div class="w-full mb-1 justify-between items-center">
                                                <h4 class="lg:text-xl text-md font-black mb-3 text-dark mt-2 flex">
                                                    <p class="lg:text-xl text-sm font-black lg:mr-3 mr-1">
                                                        <span
                                                            id="{{ $product_detail->product_id }}_currency">{{ $product_detail->currency }}</span>
                                                        <span
                                                            id="{{ $product_detail->product_id }}_price">{{ $product_detail->sales_price }}</span>
                                                    </p>
                                                    @if ($product_detail->sales_price != $product_detail->regular_price)
                                                        <p
                                                            class="lg:text-xl text-sm font-black line-through text-red-500 float-right">
                                                            {{ $product_detail->currency }}
                                                            {{ $product_detail->regular_price }}
                                                        </p>
                                                    @endif
                                                </h4>
                                                @if ($enquiry_button != null)
                                                    @if ($product_detail->product_status == 'instock')
                                                        <div class="mt-3 mb-2">
                                                            <a href="https://wa.me/{{ $enquiry_button }}?text={{ __('Hi, I am interested in your product:') }} {{ $product_detail->product_name }}. {{ __('Please provide more details.') }}"
                                                                rel="noopener nofollow noreferrer" target="_blank"
                                                                class="sub-heading w-full block text-center flex-1 bg-{{ $business_card_details->theme_color }} font-semibold hover:bg-{{ $business_card_details->theme_color }} text-white antialiased px-4 py-2">
                                                                {{ __('Make Inquiry') }}
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Galleries --}}
                        @if ($galleries_details != null && !$galleries_details->isEmpty())
                            <div class="bg-custom w-full mt-4 mb-4 flex justify-center align-middle py-2">
                                <p class="heading font-black text-white text-xl px-4 py-2">{{ __('Gallery') }}</p>
                            </div>

                            <div id="gallery" class="px-5 py-4 bg-cover bg-scroll grid grid-cols-2 gap-2">
                                @foreach ($galleries_details as $galleries_detail)
                                    <div class="mb-3">
                                        <div class="w-full overflow-hidden bg-white border-2 border-black">
                                            <a href="{{ url($galleries_detail->gallery_image) }}"
                                                data-toggle="lightbox" data-gallery="gallery" class="col-md-4">
                                                <img class="w-full" src="{{ url($galleries_detail->gallery_image) }}"
                                                    alt="{{ $galleries_detail->caption }}" style="width: 100%; height: 270px; object-fit: cover;" />
                                            </a>
                                            <div class="px-5 py-3">
                                                <div class="mb-2">
                                                    <div class="text-gray-800 font-semibold sub-heading">
                                                        {{ $galleries_detail->caption }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>                            
                        @endif

                        {{-- Testimonials --}}
                        @if ($testimonials != null && !$testimonials->isEmpty())
                            <div class="bg-custom w-full mt-4 mb-4 flex justify-center align-middle py-2">
                                <p class="heading font-black text-white text-xl px-4 py-2">{{ __('Testimonials') }}
                                </p>
                            </div>

                            <section class="px-4 py-4">
                                <div class="mb-3">
                                    <!-- Slider main container -->
                                    <div class="swiper z-[0] testimonials">
                                        <!-- Additional required wrapper -->
                                        <div class="swiper-wrapper mb-3">
                                            <!-- Slides -->
                                            @foreach ($testimonials as $testimonial)
                                                <div class="swiper-slide">
                                                    <section class="py-2 overflow-hidden">
                                                        <div class="container mx-auto">
                                                            <div class="bg-white rounded-3xl">
                                                                <div class="px-8 md:max-w-3xl mx-auto text-center">
                                                                    <p class="mt-6 mb-10 text-xl font-bold">
                                                                        "{{ $testimonial->review }}"</p>
                                                                    <img class="mb-3 w-20 h-20 mx-auto rounded-full"src="{{ url($testimonial->reviewer_image) }}"
                                                                        alt="{{ $testimonial->reviewer_name }}">
                                                                    <h3
                                                                        class="font-heading mb-2 text-xl text-gray-900 font-black capitalize sub-heading">
                                                                        {{ $testimonial->reviewer_name }}</h3>
                                                                    <p
                                                                        class="text-sm text-gray-500 font-bold capitalize">
                                                                        {{ $testimonial->review_subtext }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </section>
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- If we need pagination -->
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>
                                </div>
                            </section>
                        @endif

                        @if ($feature_details != null && !$feature_details->isEmpty())
                            @foreach ($feature_details as $feature)
                                @if ($feature->type == 'youtube')
                                    <div class="bg-custom w-full mt-4 mb-4 flex justify-center align-middle py-2">
                                        <p class="heading font-black text-white text-xl px-4 py-2">{{ __('Videos') }}
                                        </p>
                                    </div>

                                    <div id="youtube" class="px-5 py-4 ">
                                        <div class="mb-3">
                                            <div class="w-full overflow-hidden  border-2 border-black">
                                                <iframe class="w-full h-64 text-white"
                                                    src="https://www.youtube.com/embed/{!! $feature->content !!}"
                                                    title="{{ $feature->label }}" frameborder="0"
                                                    allowfullscreen></iframe>
                                                <div class="px-5 py-3">
                                                    <div class="mb-2">
                                                        <div class="text-gray-800 font-semibold text-lg sub-heading">
                                                            {{ $feature->label }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif

                        {{-- iframes --}}
                        @if ($iframes != null && !$iframes->isEmpty())
                            @foreach ($iframes as $iframe)
                                <div class="bg-custom w-full mt-4 mb-4 flex justify-center align-middle py-2">
                                    <p class="heading font-black text-white text-xl px-4 py-2">
                                        {{ __($iframe->label) }}
                                    </p>
                                </div>

                                <div id="youtube" class="px-5 py-4 ">
                                    <div class="mb-3">
                                        <div class="w-full overflow-hidden  border-2 border-black">
                                            <iframe class="w-full h-64 text-white" src="{{ $iframe->content }}"
                                                frameborder="0"></iframe>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        @if (count($payment_details) > 0)

                            <div class="bg-custom w-full mt-4 mb-4 flex justify-center align-middle py-2">
                                <p class="heading font-black text-white text-xl px-4 py-2">{{ __('Payment Methods') }}
                                </p>
                            </div>

                            @foreach ($payment_details as $payment)
                                <ul class="grid grid-flow-col grid-cols-1 grid-rows-1 mb-1">

                                    @if ($payment->type == 'url')
                                        <a href="https://{{ str_replace('https://', '', $payment->content) }}"
                                            rel="noopener nofollow noreferrer" target="_blank">
                                    @endif

                                    <li>
                                        <div class="flex items-center w-full px-5 ">
                                            <div
                                                class="flex justify-center items-center content-center bg-{{ $business_card_details->theme_color }}  h-12 w-12 rounded-full fill-current text-white">
                                                <i class="{{ $payment->icon }}"></i>
                                            </div>
                                            @if ($payment->type != 'upi')
                                                <div class="w-3/4 mx-5 my-6">
                                                    <p
                                                        class="font-semibold break-word text-gray-800 text-lg sub-heading">
                                                        {{ $payment->label }}</p>
                                                    <p class="font-medium text-gray-800 pt-1 break-word text-base">
                                                        <pre class="whitespace-break-spaces text-sm">{!! $payment->content !!}</pre>
                                                    </p>
                                                </div>
                                            @endif
                                            @if ($payment->type == 'upi')
                                                <div class="w-3/4 mx-5 my-6">
                                                    <p
                                                        class="font-semibold break-word text-gray-800 text-lg sub-heading">
                                                        {{ $payment->label }}</p>
                                                    <canvas class="upi_qr"></canvas>
                                                    <p
                                                        class="font-medium text-gray-800 pt-1 break-word text-base upi_id hidden">
                                                        {{ $payment->content }}</p>
                                                </div>
                                            @endif
                                    </li>
                                    @if ($payment->type == 'url')
                                        </a>
                                    @endif
                                </ul>
                            @endforeach
                        @endif

                        {{-- Show appointment slots in the calendar --}}
                        {{-- Show appointment slots in the calendar --}}
                            @if ($business_card_details->type == 'business' && isset($plan_details['appointment']) == 1)
                                @include('templates.includes.appointment')
                            @endif
                        
                        {{-- Business Hours --}}
                        @if ($plan_details['business_hours'] == 1)
                            @if ($business_hours != null && $business_hours->is_display != 0)

                                <div class="bg-custom w-full mt-4 mb-4 flex justify-center align-middle py-2">
                                    <p class="heading font-black text-white text-xl px-4 py-2">
                                        {{ __('Business Hours') }}</p>
                                </div>


                                <div class="px-5 py-4">

                                    @if ($business_hours->is_always_open != 'Opening')
                                        <div>
                                            <div class="grid grid-cols-2 gap-2 sub-heading">

                                                <div class="w-full">
                                                    {{ __('Monday') }}
                                                </div>

                                                <div class="w-full">
                                                    {{ __($business_hours->monday) }}
                                                </div>


                                                <div class="w-full">
                                                    {{ __('Tuesday') }}
                                                </div>

                                                <div class="w-full">
                                                    {{ __($business_hours->tuesday) }}
                                                </div>

                                                <div class="w-full">
                                                    {{ __('Wednesday') }}
                                                </div>

                                                <div class="w-full">
                                                    {{ __($business_hours->wednesday) }}
                                                </div>

                                                <div class="w-full">
                                                    {{ __('Thursday') }}
                                                </div>

                                                <div class="w-full">
                                                    {{ __($business_hours->thursday) }}
                                                </div>

                                                <div class="w-full">
                                                    {{ __('Friday') }}
                                                </div>

                                                <div class="w-full">
                                                    {{ __($business_hours->friday) }}
                                                </div>

                                                <div class="w-full">
                                                    {{ __('Saturday') }}
                                                </div>

                                                <div class="w-full">
                                                    {{ __($business_hours->saturday) }}
                                                </div>

                                                <div class="w-full">
                                                    {{ __('Sunday') }}
                                                </div>

                                                <div class="w-full">
                                                    {{ __($business_hours->sunday) }}
                                                </div>

                                            </div>
                                        </div>
                                    @else
                                        <div>
                                            <p
                                                class="pt-2 py-4 font-semibold text-{{ $business_card_details->theme_color }}">
                                                {{ __('Always Open') }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endif

                        {{-- Contact form --}}
                        @if ($plan_details['contact_form'] == 1)
                            @if ($business_card_details->enquiry_email != null)

                                <div class="bg-custom w-full mt-4 mb-4 flex justify-center align-middle py-2">
                                    <p class="heading font-black text-white text-xl px-4 py-2">{{ __('Contact us') }}
                                    </p>
                                </div>

                                <section class="py-5 lg:py-8 border-b">
                                    <div class="container mx-auto">
                                        <div class="max-w-xl mx-auto">
                                            @if (Session::has('message'))
                                                <div class="px-4 bg-{{ $business_card_details->theme_color }} border-t-4 border-{{ $business_card_details->theme_color }} rounded-b text-{{ $business_card_details->theme_color }} px-4 py-3 shadow-md mb-3"
                                                    role="alert">
                                                    <div class="flex">
                                                        <div class="py-1"><svg
                                                                class="fill-current h-6 w-6 text-white mr-4"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 20 20">
                                                                <path
                                                                    d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                                                            </svg></div>
                                                        <div>
                                                            <p class="font-bold text-white">
                                                                {{ Session::get('message') }}</p>
                                                            <p class="text-sm text-white">
                                                                {{ __('Please wait for the reply to be sent.') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <form class="px-4" action="{{ route('sent.enquiry') }}"
                                                method="POST">
                                                @csrf
                                                <div class="flex flex-wrap -mx-2">
                                                    <div class="mb-3 w-full lg:w-1/2 px-2">
                                                        <input
                                                            class="w-full p-4 text-xs bg-gray-50 outline-none font-semibold rounded"
                                                            type="hidden"
                                                            value="{{ $business_card_details->card_id }}"
                                                            name="card_id" />
                                                        <input
                                                            class="w-full p-4 bg-gray-100 font-semibold outline-none rounded"
                                                            type="text" placeholder="{{ __('Name') }} *"
                                                            name="name" required />
                                                    </div>
                                                    <div class="mb-3 w-full lg:w-1/2 px-2">
                                                        <input
                                                            class="w-full p-4 bg-gray-100 font-semibold outline-none rounded"
                                                            type="email" placeholder="{{ __('Email') }} *"
                                                            name="email" required />
                                                    </div>
                                                </div>
                                                <div class="mb-3 flex p-4 bg-gray-100 rounded">
                                                    <input class="w-full bg-gray-100 font-semibold outline-none"
                                                        type="number" placeholder="{{ __('Mobile Number') }}"
                                                        name="phone" />
                                                </div>
                                                <div class="mb-6 flex p-4 bg-gray-100 rounded">
                                                    <textarea class="w-full h-20 font-semibold bg-gray-100 rounded outline-none" type="text"
                                                        placeholder="{{ __('Message') }} *" name="message" required></textarea>
                                                </div>
                                                <div class="text-center">
                                                    <button
                                                        class="mb-2 sub-heading w-full py-4 bg-{{ $business_card_details->theme_color }} font-bold text-gray-50 transition duration-200">
                                                        {{ __('Send') }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </section>
                            @endif
                        @endif

                        @if ($feature_details != null && !$feature_details->isEmpty())
                            <div id="youtube" class="py-4">
                                @foreach ($feature_details as $feature)
                                    @if ($feature->type == 'map')
                                        <div class="bg-custom w-full mt-4 mb-4 flex justify-center align-middle py-2">
                                            <p class="heading font-black text-white  text-xl px-4 py-2">
                                                {{ __('Location') }}</p>
                                        </div>


                                        <div id="youtube" class="px-5 py-4">
                                            <div class="mb-3">
                                                <div class="w-full overflow-hidden border-2 border-black">
                                                    <iframe
                                                        src="https://www.google.com/maps/embed?{!! $feature->content !!}"
                                                        class="w-full h-64" style="border:0;" allowfullscreen=""
                                                        loading="lazy"
                                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                    <div class="px-5 py-3">
                                                        <div class="mb-2">
                                                            <div class="text-gray-800 font-semibold text-lg">
                                                                {{ $feature->label }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif



                        <div class="lg:block hidden w-full pl-6 pb-3 mx-auto pt-3 border-b">
                            <ul class="grid grid-flow-col grid-cols-6 grid-rows-1">
                                {{-- Send vCard --}}
                                <li class="flex send-modal-open cursor-pointer items-center">
                                    <div
                                        class="flex justify-center items-center content-center bg-{{ $business_card_details->theme_color }}  h-16 w-16 rounded-full fill-current text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-send" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <line x1="10" y1="14" x2="21" y2="3">
                                            </line>
                                            <path
                                                d="M21 3l-6.5 18a0.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a0.55 .55 0 0 1 0 -1l18 -6.5">
                                            </path>
                                        </svg>
                                    </div>
                                </li>

                                {{-- Scan QR --}}
                                <li class="flex qr-modal-open cursor-pointer items-center">
                                    <div
                                        class="flex justify-center items-center content-center bg-{{ $business_card_details->theme_color }} h-16 w-16 rounded-full fill-current text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                        </svg>
                                    </div>
                                </li>

                                {{-- Download vCard --}}
                                <li class="flex items-center cursor-pointer">
                                    <a href="{{ route('download.vCard', $business_card_details->card_id) }}">
                                        <div
                                            class="flex justify-center items-center content-center bg-{{ $business_card_details->theme_color }} h-16 w-16 rounded-full fill-current text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>



                        <div id="share" class="bg-custom w-full mt-4 mb-4 flex justify-center align-middle py-2">
                            <p class="font-black text-white text-xl px-4 py-2 heading">{{ __('Share on') }}</p>
                        </div>

                        <div class="w-full pl-6 pb-3 mx-auto border-t pt-3">
                            <ul class="grid grid-flow-col lg:grid-cols-8 grid-cols-6 grid-rows-1">

                                <a target="_blank" rel="noopener nofollow noreferrer"
                                    href="{{ $shareComponent['facebook'] }}">
                                    <li class="flex cursor-pointer items-center">
                                        <div
                                            class="flex justify-center items-center content-center bg-{{ $business_card_details->theme_color }} h-12 w-12 rounded-full fill-current text-white">
                                            <i class="fab fa-facebook"></i>
                                        </div>
                                    </li>
                                </a>

                                <a target="_blank" rel="noopener nofollow noreferrer"
                                    href="{{ $shareComponent['twitter'] }}">
                                    <li class="flex cursor-pointer items-center">
                                        <div
                                            class="flex justify-center items-center content-center bg-{{ $business_card_details->theme_color }} h-12 w-12 rounded-full fill-current text-white">
                                            <i class="fab fa-twitter"></i>
                                        </div>
                                    </li>
                                </a>

                                <a target="_blank" rel="noopener nofollow noreferrer"
                                    href="{{ $shareComponent['linkedin'] }}">
                                    <li class="flex cursor-pointer items-center">
                                        <div
                                            class="flex justify-center items-center content-center bg-{{ $business_card_details->theme_color }} h-12 w-12 rounded-full fill-current text-white">
                                            <i class="fab fa-linkedin"></i>
                                        </div>
                                    </li>
                                </a>

                                <a target="_blank" rel="noopener nofollow noreferrer"
                                    href="{{ $shareComponent['telegram'] }}">
                                    <li class="flex cursor-pointer items-center">
                                        <div
                                            class="flex justify-center items-center content-center bg-{{ $business_card_details->theme_color }} h-12 w-12 rounded-full fill-current text-white">
                                            <i class="fab fa-telegram"></i>
                                        </div>
                                    </li>
                                </a>

                                <a target="_blank" rel="noopener nofollow noreferrer"
                                    href="{{ $shareComponent['whatsapp'] }}">
                                    <li class="flex cursor-pointer items-center">
                                        <div
                                            class="flex justify-center items-center content-center bg-{{ $business_card_details->theme_color }} h-12 w-12 rounded-full fill-current text-white">
                                            <i class="fab fa-whatsapp"></i>
                                        </div>
                                    </li>
                                </a>

                            </ul>
                        </div>


                        @if ($plan_details['hide_branding'] == 1)
                            <div class="pb-1">
                                <div
                                    class="flex pb-5 px-3 m-auto pt-5 font-semibold text-dark text-sm flex-col md:flex-row max-w-6xl">
                                    <div class="mt-2">
                                        {{ __('Copyright') }} &copy;
                                        <a class="text-{{ $business_card_details->theme_color }}"
                                            href="{{ url($card_details->card_url) }}"> {{ $card_details->title }}
                                        </a>
                                        <span id="year"></span>{{ __('. All Rights Reserved.') }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="pb-1">
                                <div
                                    class="flex pb-5 px-3 m-auto pt-5 font-semibold border-t text-gray-800 text-sm flex-col md:flex-row max-w-6xl">
                                    <div class="mt-2">
                                        {{ __('Made with') }}
                                        <a class="text-{{ $business_card_details->theme_color }}"
                                            href="{{ env('APP_URL') }}"> {{ config('app.name') }} </a>
                                        <span id="year"></span>{{ __('. All Rights Reserved.') }}
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="p-8"></div>

                </div>

                <div
                    class="lg:hidden bg-{{ $business_card_details->theme_color }} fixed bottom-0 w-full border-t border-gray-200 flex z-10">
                    <a href="#profile"
                        class="flex flex-grow items-center justify-center p-2 text-gray-50 hover:text-gray-50 bg-{{ $business_card_details->theme_color }}">
                        <div class="text-center">
                            <span class="block h-8 grid justify-items-center text-3xl leading-8">
                                <svg class="h-6 w-6 text-grey mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>
                            </span>
                            <span class="block text-xs leading-none">{{ __('Profile') }}</span>
                        </div>
                    </a>

                    {{-- Send vCard --}}
                    <a href="#"
                        class="flex send-modal-open flex-grow items-center justify-center p-2 text-gray-50 hover:text-gray-50 bg-{{ $business_card_details->theme_color }}">
                        <div class="text-center">
                            <span class="block h-8 grid justify-items-center text-3xl leading-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <line x1="10" y1="14" x2="21" y2="3">
                                    </line>
                                    <path
                                        d="M21 3l-6.5 18a0.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a0.55 .55 0 0 1 0 -1l18 -6.5">
                                    </path>
                                </svg>
                            </span>
                            <span class="block text-xs leading-none">{{ __('Send') }}</span>
                        </div>
                    </a>

                    {{-- Scan QR --}}
                    <a href="#"
                        class="flex qr-modal-open flex-grow items-center justify-center p-2 text-gray-50 hover:text-gray-50 bg-{{ $business_card_details->theme_color }}">
                        <div class="text-center">
                            <span class="block h-8 grid justify-items-center text-3xl leading-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                            </span>
                            <span class="block text-xs leading-none">{{ __('Scan QR') }}</span>
                        </div>
                    </a>

                    {{-- Save Contact --}}
                    <a href="{{ route('download.vCard', $business_card_details->card_id) }}"
                        class="flex flex-grow items-center justify-center p-2 text-gray-50 hover:text-gray-50 bg-{{ $business_card_details->theme_color }}">
                        <div class="text-center">
                            <span class="block h-8 grid justify-items-center text-3xl leading-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </span>
                            <span class="block text-xs leading-none">{{ __('Save Contact') }}</span>
                        </div>
                    </a>

                    <a href="#share"
                        class="flex flex-grow items-center justify-center p-2 text-gray-50 hover:text-gray-50 bg-{{ $business_card_details->theme_color }}">
                        <div class="text-center">
                            <span class="block h-8 grid justify-items-center text-3xl leading-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                            </span>
                            <span class="block text-xs leading-none">{{ __('Share') }}</span>
                        </div>
                    </a>
                </div>

                {{-- Send vCard --}}
                <div
                    class="send-modal opacity-0 transition duration-300 ease-in-out pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-index-9999">
                    <div class="send-modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
                    <div class="modal-container bg-white w-full md:max-w-md mx-auto rounded z-50 overflow-y-auto">
                        <div class="modal-content py-4 text-left px-6">
                            <div class="justify-between items-center">
                                <div class="text-left">
                                    <label class=" block text-gray-700 heading font-bold mb-6"
                                        for="phone_number">{{ __('WhatsApp Number') }}</label>
                                    <input id="phone_number" type="number"
                                        class="appearance-none border rounded w-full py-3 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <small>{{ __('Including country code') }}</small>
                                </div>
                                <button
                                    class="mt-6 block w-full sub-heading content-center bg-{{ $business_card_details->theme_color }} py-2 px-8 fill-current text-white"
                                    onclick="sendVcard()">
                                    {{ __('Send') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- QR --}}
                <div
                    class="qr-modal opacity-0 transition duration-300 ease-in-out  pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-index-9999">
                    <div class="qr-modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
                    <div
                        class="modal-container bg-white w-auto md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
                        <div class="modal-content py-4 text-left px-6">
                            <div class="justify-between items-center px-6 qr-code"></div>
                            <a id="download"
                                onclick="downloadQr('{{ route('dynamic.card', $business_card_details->card_id) }}', 500)"
                                class="flex justify-center items-center content-center bg-{{ $business_card_details->theme_color }} mt-3 cursor-pointer h-16 w-16 rounded-full fill-current text-white qr-code-download">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Include PWA modal -->
                @if ($plan_details != null)
                    {{-- Check PWA --}}
                    @if ($plan_details['pwa'] == 1)
                        @include('vendor.laravelpwa.pwa_modal')
                    @endif
                @endif
            @else
                <div id="profile" class="leading-tight min-h-screen bg-grey-lighter p-1">
                    <br>
                    <h4>{{ __('403') }}</h4>
                    <h6>{{ __('Oops! Basic details are missing.') }}</h6>
                </div>
            @endif
        @endif
    </div>

    {{-- Check password protected --}}
    @if ($business_card_details->password != null && Session::get('password_protected') == false)
        <div class="bg-{{ $business_card_details->theme_color }} p-4 flex items-center justify-center h-screen">
            <div x-data="{ showModal: true }">
                <!-- Modal -->
                <div x-show="showModal" class="fixed inset-0 flex items-center justify-center z-50 p-3">
                    <div class="bg-white rounded-lg p-6 w-96 max-w-full shadow-lg transform transition-all duration-300"
                        x-show.transition.opacity="showModal">
                        <!-- Modal Header -->
                        <div class="flex justify-between items-center border-b-2 border-gray-200 pb-4">
                            <h2 class="text-2xl font-semibold">{{ __('Password Protected') }}</h2>
                        </div>

                        <!-- Modal Content -->
                        <div class="mt-6 space-y-4">
                            <form action="{{ route('check.pwd', $business_card_details->card_id) }}" method="post">
                                @csrf
                                <p class="text-lg mt-2 mb-4 text-gray-600">{{ __('Enter your vcard password') }}:</p>
                                <div class="flex">
                                    <input type="password" name="password"
                                        class="rounded rounded-r-lg bg-gray-50 border text-gray-800 focus:ring-blue-100 focus:border-blue-100 block flex-1 min-w-0 w-full text-sm border-gray-100 p-2.5"
                                        placeholder="{{ __('Password') }}" autofocus required>
                                </div>

                                {{-- Message --}}
                                @if (Session::has('message'))
                                    <div class="flex items-center p-4 my-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                                        role="alert">
                                        <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                        </svg>
                                        <span class="sr-only">{{ __('Failed') }}</span>
                                        <div>
                                            <span class="font-medium">{{ Session::get('message') }}</span>
                                        </div>
                                    </div>
                                @endif

                                <div class="flex flex-col space-y-4 mt-3">
                                    <button type="submit"
                                        class="bg-{{ $business_card_details->theme_color }} text-white px-4 py-2 mt-2 rounded-lg hover:bg-{{ $business_card_details->theme_color }} transition duration-300">{{ __('Password') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="{{ url('js/smooth-scroll.polyfills.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('app/js/footer.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/jquery-qrcode.min.js') }}"></script>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
        // Assuming $appointment_slots contains data like: {"monday": [...], "tuesday": [...], ...}
        const disableSlots = {!! $appointment_slots !!}; // Outputting the time slots
        
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#appointment-date", {
                dateFormat: "Y-m-d",
                minDate: "today",
                disable: [
                    function(date) {
                        const day = date.toLocaleString('en-us', { weekday: 'long' }).toLowerCase();
                        return !disableSlots[day] || disableSlots[day].length === 0;
                    }
                ],
                onChange: function(selectedDates) {
                    const selectedDate = selectedDates[0];
                    const day = selectedDate.toLocaleString('en-us', { weekday: 'long' }).toLowerCase();
                    // Get available time slots in Send data to Laravel route using fetch API
                    generateOption(selectedDate, day);
                }
            });
        });
    </script>

    <script>
        // Toggle the modal visibility
        function toggleModal() {
            const modal = document.getElementById('appointmentModal');
            modal.classList.toggle('hidden');
        }

        // Validate appointment date and time slot
        function validateAndShowModal() {
            const appointmentDate = document.getElementById('appointment-date').value;
            const timeSlotSelect = document.getElementById('time-slot-select').value;
            const errorMessage = document.getElementById('errorMessage');
            const successMessage = document.getElementById('successMessage');

            if (appointmentDate && timeSlotSelect) {
                // If both fields are not empty, show the modal
                toggleModal();
                errorMessage.classList.add('hidden'); // Hide any previous error message
            } else {
                // If either field is empty, show an error message
                errorMessage.classList.remove('hidden');
            }
        }

        // Handle form submission
        document.getElementById('appointmentForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const errorMessage = document.getElementById('errorMessage');
            const successMessage = document.getElementById('successMessage');

            // Gather form data
            const formData = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                notes: document.getElementById('notes').value,
                date: document.getElementById('appointment-date').value,
                time_slot: document.getElementById('time-slot-select').value,
                price: document.getElementById('price').value,
                card: `{{ $business_card_details->card_id }}`
            };

            // Send data to Laravel route using fetch API
            fetch("{{ route('book.appointment') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
                },
                body: JSON.stringify(formData)
            })
            .then(data => {
                // Handle success or error response from the server
                if (data.status == 200) {
                    // Reset the form fields
                    document.getElementById('email').value = "";
                    document.getElementById('phone').value = "";
                    document.getElementById('name').value = "";
                    document.getElementById('notes').value = "";
                    document.getElementById('price').value = "";

                    // Get available time slots in Send data to Laravel route using fetch API
                    generateOption("", "");

                    successMessage.classList.remove('hidden'); // Hide any previous success message
                    toggleModal(); // Close the modal on success
                } else {
                    // If either field is empty, show an success message
                    errorSubmitMessage.classList.remove('hidden');
                    toggleModal(); // Close the modal on error
                }
            });
        });
    </script>

    <script>
        function generateOption(selectedDate, day) 
        {
            fetch('/get-available-time-slots', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({
                    card: `{{ $business_card_details->card_id }}`,
                    choose_date: selectedDate,
                    day: day
                })
            }).then(response => response.json())
            .then(data => {
                // Set available time slots in select option
                document.getElementById('time-slot-select').innerHTML = `<option value="">{{ __('Select a time slot') }}`;
                // Available time slots in JSON.parse(data.available_time_slots)
                var available_time_slots = JSON.parse(data.available_time_slots);
                
                available_time_slots.forEach(time_slot => {
                    document.getElementById('time-slot-select').innerHTML += `<option value="${time_slot}">${time_slot}</option>`;
                });

                // Set price
                const priceElement = document.getElementById('price');
                priceElement.value = data.price;
            });
        }
    </script>

    {{-- Custom JS --}}
    @yield('custom-js')

    {{-- Check business details --}}
    @if ($business_card_details != null)
        <script>
            {!! $business_card_details->custom_js !!}
        </script>
    @endif

    <script>
        function sendVcard() {
            "use strict";
            var phone_number = $('#phone_number').val();
            window.open('https://api.whatsapp.com/send/?phone=' + phone_number + '&text=' + `{{ $shareContent }}`,
                '_blank');
            return false;
        }

        var swiper = new Swiper(".testimonials", {
            slidesPerView: 1,
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });

        window.onload = function() {
            "use strict";

            updateQr(`{{ route('dynamic.card', $business_card_details->card_id) }}`);
        };
    </script>
    <script>
        window.addEventListener("load", function() {
            const preloader = document.getElementById("preloader");
            const content = document.getElementById("content");

            setTimeout(() => {
                preloader.style.display = "none";
                content.style.display = "block";
            }, 2000); // Adjust the time as needed, here set to 2 seconds
        });
    </script>
    <script>
        // UPI Link
        (function() {
            "use strict";

            // Select all .upi_qr elements
            var upiQrElements = document.querySelectorAll('.upi_qr');
            // Select all .upi_id elements
            var upiIdElements = document.querySelectorAll('.upi_id');

            // Ensure both NodeLists have the same length
            if (upiQrElements.length !== upiIdElements.length) {
                console.error('Mismatch in number of .upi_qr and .upi_id elements');
            } else {
                // Loop through each pair of .upi_qr and .upi_id elements
                for (var j = 0; j < upiQrElements.length; j++) {
                    var upiQrElement = upiQrElements[j];
                    var upiIdElement = upiIdElements[j];
                    var UPIAddress = upiIdElement.innerText;

                    if (upiQrElement && upiIdElement) {
                        // Create the QRious instance for each pair
                        new QRious({
                            element: upiQrElement,
                            value: `upi://pay?pa=${UPIAddress.replace(/\s+/g, '')}&pn={{ preg_replace('/\s+/', '', $business_card_details->title) }}&cu=INR`,
                            size: 200
                        });
                    } else {
                        console.error('Error: Element pair not found');
                    }
                }
            }

            // Additional logic can be added here as needed
        })();
    </script>
</body>

</html>
