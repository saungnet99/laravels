@php
// Page content
use Illuminate\Support\Facades\DB;

$config = DB::table('config')->get();
$supportPage = DB::table('pages')->where('page_name', 'footer')->orWhere('page_name', 'contact')->get();

// Default
$navbar = true;
$footer = true;

if ($config[38]->config_value == "no") { 
    // $navbar = false;
    $footer = false;
}
@endphp

@extends('layouts.index', ['nav' => $navbar, 'banner' => false, 'footer' => $footer, 'cookie' => false, 'setting' => true, 'title' => true, 'title' => 'Confirmation Password'])

@section('custom-script')
<link rel="icon" href="{{ asset($settings->favicon) }}" sizes="96x96" type="image/png" />
@endsection

@section('content')
{{-- Confirm page --}}
<section class="pt-12 lg:pb-20 overflow-hidden">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap items-center -m-6">
            <div class="w-full md:w-1/2 p-6 lg:block hidden">
                <div class="p-1 mx-auto max-w-max overflow-hidden rounded-full">
                    <img class="object-cover rounded-full" src="{{ asset($config[13]->config_value) }}" alt="{{ $config[0]->config_value }}">
                </div>
            </div>
            <div class="w-full md:w-1/2 p-6">
                <div class="md:max-w-md">
                    <h2 class="mb-8 font-heading font-bold text-6xl sm:text-7xl">{{ __('Confirm Password') }}</h2>
                    <p class="mb-8 text-lg">{{ __('Please confirm your password before continuing.') }}</p>

                    {{-- Reset form --}}
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf
                        <div class="flex flex-wrap -m-2 mb-6">
                            {{-- Password --}}
                            <div class="w-full p-2">
                                <p class="mb-2.5 font-medium text-base">{{ __('Password') }}</p>
                                <div
                                    class="p-px bg-gradient-to-r from-{{ $config[11]->config_value }}-400 to-{{ $config[11]->config_value }}-500 focus-within:ring-4 focus-within:ring-indigo-500 rounded-lg">
                                    <input class="w-full px-6 py-4 placeholder-gray-500 text-base outline-none rounded-lg @error('password') is-invalid @enderror"
                                        type="password" placeholder="********" name="password" id="password" value="{{ old('password') }}" required autocomplete="current-password">
                                </div>
                            </div>

                            {{-- Show password --}}
                            <div class="mb-4">
                                <a class="ml-2 text-xs text-gray-800 font-medium float-right cursor-pointer" title="Show password"
                                    data-bs-toggle="tooltip" onclick="showPassword()">{{ __('Show / Hide Password')}}</a>
                            </div>
                            @error('password')
                            <span class="invalid-feedback mx-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="group relative md:max-w-max mb-5">
                            <div
                                class="absolute top-0 left-0 w-full h-full bg-gradient-to-r from-{{ $config[11]->config_value }}-400 to-{{ $config[11]->config_value }}-500 opacity-0 group-hover:opacity-50 rounded-full transition ease-out duration-300">
                            </div>
                            <button
                                class="p-1 w-full font-heading font-semibold text-xs text-white uppercase tracking-px overflow-hidden rounded-full">
                                <div class="relative py-5 px-14 bg-gradient-to-r from-{{ $config[11]->config_value }}-400 to-{{ $config[11]->config_value }}-500 overflow-hidden rounded-full">
                                    <div
                                        class="absolute top-0 left-0 transform -translate-y-full group-hover:-translate-y-0 h-full w-full bg-white transition ease-in-out duration-500">
                                    </div>
                                    <p class="relative z-10 group-hover:text-gray-900">{{ __('Confirm Password') }}</p>
                                </div>
                            </button>
                        </div>

                        {{-- Request password --}}
                        @if (Route::has('password.request'))
                        <p class="mt-16 mb-8 text-lg"><a class="underline hover:text-gray-500" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }} </a></p>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Custom JS --}}
@section('custom-js')
<script>
function showPassword() {
    "use strict";
    var password = document.getElementById("password");
    if (password.type === "password") {
        password.type = "text";
    } else {
        password.type = "password";
    }
}
</script>
@endsection
@endsection
