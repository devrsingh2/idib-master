@extends('admin.layouts.master')
@section('header')
    <style>
        .accent-thumb-btn {
            position:absolute;
            width:100%;
            height:40px;
            /*margin-top:-40px;*/
            z-index:10;
            opacity:0;
        }
    </style>
@endsection
@section('content')
    <main class="content-wrapper">
        <div class="mdc-layout-grid">
            <form name="frm_add_accent" method="post" action="{{ route('admin.suits.accents.update', [$item->id]) }}" enctype="multipart/form-data">
                @csrf
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell--span-12">
                        <div class="mdc-card">
                            <h6 class="card-title">Edit Accent</h6>
                            <div class="template-demo">
                                <div class="mdc-layout-grid__inner">
                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                                        <div type="text" class="mdc-text-field mdc-text-field--outlined">
                                            <input class="mdc-text-field__input" id="accent_name" name="accent_name" value="{{ $item->name }}" />
                                            <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch" style="">
                                                    <label for="accent_name" class="mdc-floating-label" style="">Accent Name</label>
                                                </div>
                                                <div class="mdc-notched-outline__trailing"></div>
                                            </div>
                                        </div>
                                        @error('accent_name')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg invalid-feedback" id="text-field-outlined-helper-text">{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                                        <div type="text" class="mdc-text-field mdc-text-field--outlined">
                                            <input class="mdc-text-field__input" id="accent_description" name="accent_description" value="{{ $item->description }}" />
                                            <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch" style="">
                                                    <label for="accent_description" class="mdc-floating-label" style="">Accent Description</label>
                                                </div>
                                                <div class="mdc-notched-outline__trailing"></div>
                                            </div>
                                        </div>
                                        @error('accent_description')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg invalid-feedback" id="text-field-outlined-helper-text">{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                            <i class="material-icons mdc-text-field__icon">attach_money</i>
                                            <input type="number" min="0" step="any" class="mdc-text-field__input" id="accent_price" name="accent_price" value="{{ $item->price }}" />
                                            <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch" style="">
                                                    <label for="accent_price" class="mdc-floating-label" style="">Accent Price</label>
                                                </div>
                                                <div class="mdc-notched-outline__trailing"></div>
                                            </div>
                                        </div>
                                        @error('accent_price')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg invalid-feedback" id="text-field-outlined-helper-text">{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    {{--<div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
                                            <i class="material-icons mdc-text-field__icon">attachment</i>
                                            <input type="file" class="mdc-text-field__input accent-thumb-btn" id="accent_thumb" name="accent_thumb" />
                                            <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch" style="">
                                                    <label for="accent_thumb" class="mdc-floating-label" style="">Accent Image (100 x 100)</label>
                                                </div>
                                                <div class="mdc-notched-outline__trailing"></div>
                                            </div>
                                        </div>
                                        @error('accent_thumb')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg invalid-feedback" id="text-field-outlined-helper-text">{{ $message }}</p>
                                        </div>
                                        @enderror
                                        --}}{{--<img id="thumb_image" style="padding: 2px;" src="#" alt=""/>--}}{{--
                                        <img id="thumb_image" style="padding: 2px; width: 64px; height: 64px;" src= "{{asset('tool/images/accent/suit')}}/{{$item->accent_image}}">
                                    </div>--}}

                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-form-field">
                                            <div class="mdc-checkbox mdc-checkbox--secondary">
                                                <input
                                                        type="checkbox"
                                                        id="status"
                                                        name="status"
                                                        class="mdc-checkbox__native-control"
                                                        {{ ($item->status === 1) ? 'checked' : '' }}
                                                />
                                                <div class="mdc-checkbox__background">
                                                    <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                        <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59"></path>
                                                    </svg>
                                                    <div class="mdc-checkbox__mixedmark"></div>
                                                </div>
                                            </div>
                                            <label for="status" id="basic-disabled-checkbox-label">Status</label>
                                        </div>
                                    </div>

                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop justify-content-end">

                                    </div>
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop justify-content-end">
                                        <button class="mdc-button mdc-button--unelevated mdc-ripple-upgraded filled-button--secondary">
                                            <i class="material-icons mdc-button__icon">send</i>
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection
@section('footer')
    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#thumb_image')
                        .attr('src', e.target.result)
                        .width('64px')
                        .height('64px');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        function readMediumThumbURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#medium_image')
                        .attr('src', e.target.result)
                        .width('64px')
                        .height('64px');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        function readLargeThumbURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#large_image')
                        .attr('src', e.target.result)
                        .width('64px')
                        .height('64px');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        //
        $(document).ready(function () {
//            $('#thumb_image').hide();
            $("#accent_thumb").change(function() {
//                $('#thumb_image').show();
                readURL(this);
            });
//            $('#medium_image').hide();
            $("#medium_thumb").change(function() {
//                $('#medium_image').show();
                readMediumThumbURL(this);
            });
//            $('#large_image').hide();
            $("#large_thumb_image").change(function() {
//                $('#large_image').show();
                readLargeThumbURL(this);
            });
        });
    </script>
@endsection