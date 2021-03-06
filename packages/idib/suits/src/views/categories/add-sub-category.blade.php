@extends('admin.layouts.master')
@section('header')
    <style>
        .fabric-thumb-btn {
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
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell--span-12">
                    <div class="mdc-card">
                        <h6 class="card-title">Add Sub Category</h6>
                        <div class="template-demo">
                            <form name="frm_edit_category" method="post" action="{{ route('admin.suits.categories.sub-categories.submit', [$item->id]) }}">
                                @csrf
                                <input type="hidden" class="mdc-text-field__input" id="parent_id" name="parent_id" readonly value="{{ $item->id }}"/>
                                <input type="hidden" class="mdc-text-field__input" id="category_id" name="category_id" readonly value="{{ $item->id }}"/>
                                <div class="mdc-layout-grid__inner">
                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-text-field mdc-text-field--outlined">
                                            <input type="text" class="mdc-text-field__input" id="category" name="category" readonly value="{{ $item->name }}"/>
                                            <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch" style="">
                                                    <label for="category" class="mdc-floating-label" style="">Category</label>
                                                </div>
                                                <div class="mdc-notched-outline__trailing"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-text-field text-field mdc-text-field--outlined">
                                            {{--<i class="material-icons mdc-text-field__icon">attach_money</i>--}}
                                            <input class="mdc-text-field__input" id="category_name" name="category_name" />
                                            <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch" style="">
                                                    <label for="category_name" class="mdc-floating-label" style="">Name</label>
                                                </div>
                                                <div class="mdc-notched-outline__trailing"></div>
                                            </div>
                                        </div>
                                        @error('category_name')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg invalid-feedback" id="text-field-outlined-helper-text">{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-text-field mdc-text-field--outlined">
                                            <input class="mdc-text-field__input" id="category_description" name="category_description" />
                                            <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch" style="">
                                                    <label for="category_description" class="mdc-floating-label" style="">Description</label>
                                                </div>
                                                <div class="mdc-notched-outline__trailing"></div>
                                            </div>
                                        </div>
                                        @error('category_description')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg invalid-feedback" id="text-field-outlined-helper-text">{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>
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
                                        <a href="{{ route('admin.suits.categories.sub-categories', [$item->id]) }}" class="mdc-button mdc-button--raised filled-button--secondary mdc-ripple-upgraded">
                                            <i class="material-icons mdc-button__icon">arrow_back</i>
                                            Cancel
                                        </a>
                                        &nbsp;
                                        &nbsp;
                                        <button class="mdc-button mdc-button--raised filled-button--primary mdc-ripple-upgraded">
                                            <i class="material-icons mdc-button__icon">update</i>
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
            $('#thumb_image').hide();
            $("#fabric_thumb").change(function() {
                $('#thumb_image').show();
                readURL(this);
            });
            $('#medium_image').hide();
            $("#medium_thumb").change(function() {
                $('#medium_image').show();
                readMediumThumbURL(this);
            });
            $('#large_image').hide();
            $("#large_thumb_image").change(function() {
                $('#large_image').show();
                readLargeThumbURL(this);
            });
        });
    </script>
@endsection