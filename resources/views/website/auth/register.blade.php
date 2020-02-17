@extends('website.layouts.login')
@section('header')
    <style>
        .invalid-feedback {
            width: 260px;
            color: #ff0000;
            font-size: 12px;
        }
    </style>
@endsection
@section('content')
    <div class="page-wrapper full-page-wrapper d-flex align-items-center justify-content-center">
        <main class="auth-page">
            <div class="mdc-layout-grid">
                <div class="mdc-layout-grid__inner">
                    <div class="stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-1-tablet"></div>
                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-6-tablet">
                        <div class="mdc-card">
                            <h4 class="justify-content-center">Create Your Account</h4>
                            @error('name')
                            <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
                            @enderror
                            @error('email')
                            <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
                            @enderror
                            @error('password')
                            <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
                            @enderror
                            @error('password_confirmation')
                            <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
                            @enderror
                            <form method="post" action="{{ route('submit-signup') }}" autocomplete="off">
                                @csrf
                                <div class="mdc-layout-grid">
                                    <div class="mdc-layout-grid__inner">
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                            <div class="mdc-text-field w-100">
                                                <input
                                                        type="text"
                                                        class="mdc-text-field__input @error('name') is-invalid @enderror"
                                                        id="text-field-hero-input"
                                                        name="name"
                                                        value="{{ old('name') }}"
                                                />
                                                <div class="mdc-line-ripple"></div>
                                                <label for="text-field-hero-input" class="mdc-floating-label">Name</label>
                                            </div>
                                        </div>
                                        {{--@error('name')
                                        <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
                                        @enderror--}}

                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                            <div class="mdc-text-field w-100">
                                                <input
                                                        type="text"
                                                        class="mdc-text-field__input @error('email') is-invalid @enderror"
                                                        id="text-field-hero-input"
                                                        name="email"
                                                        value="{{ old('email') }}"
                                                />
                                                <div class="mdc-line-ripple"></div>
                                                <label for="text-field-hero-input" class="mdc-floating-label">Email</label>
                                            </div>
                                        </div>
                                        {{--@error('email')
                                        <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
                                        @enderror--}}

                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                            <div class="mdc-text-field w-100">
                                                <input
                                                        class="mdc-text-field__input @error('password') is-invalid @enderror"
                                                        type="password"
                                                        id="text-field-hero-input"
                                                        name="password"
                                                />
                                                <div class="mdc-line-ripple"></div>
                                                <label for="text-field-hero-input" class="mdc-floating-label">Password</label>
                                            </div>
                                        </div>
                                        {{--@error('password')
                                        <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
                                        @enderror
                                        <br/>--}}
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                            <div class="mdc-text-field w-100">
                                                <input
                                                        class="mdc-text-field__input @error('password_confirmation') is-invalid @enderror"
                                                        type="password"
                                                        id="text-field-hero-input"
                                                        name="password_confirmation"
                                                />
                                                <div class="mdc-line-ripple"></div>
                                                <label for="text-field-hero-input" class="mdc-floating-label">Confirm Password</label>
                                            </div>
                                        </div>
                                        {{--@error('password_confirmation')
                                        <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
                                        @enderror
                                        <br/>--}}

                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                            <div class="mdc-form-field">
                                                <div class="mdc-checkbox">
                                                    <input type="checkbox"
                                                           class="mdc-checkbox__native-control"
                                                           id="checkbox-1"/>
                                                    <div class="mdc-checkbox__background">
                                                        <svg class="mdc-checkbox__checkmark"
                                                             viewBox="0 0 24 24">
                                                            <path class="mdc-checkbox__checkmark-path"
                                                                  fill="none"
                                                                  d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                                                        </svg>
                                                        <div class="mdc-checkbox__mixedmark"></div>
                                                    </div>
                                                </div>
                                                <label for="checkbox-1">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop d-flex align-items-center justify-content-end">
                                            <a href="{{ route('login') }}">Login</a>
                                        </div>
                                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                            <button type="submit" class="mdc-button mdc-button--raised w-100">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-1-tablet"></div>
                </div>
            </div>
        </main>
    </div>
@endsection
