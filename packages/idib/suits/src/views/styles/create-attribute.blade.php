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
            <form name="frm_add_accent" method="post"
                  action="{{ route('admin.suits.accent-attributes.store', [$id]) }}"
                  enctype="multipart/form-data"
            >
                @csrf
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell--span-12">
                        <div class="mdc-card">
                            <h6 class="card-title">Add Accent Attribute</h6>
                            <div class="template-demo">
                                <div class="mdc-layout-grid__inner">

                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-text-field mdc-text-field--outlined">
                                            <input class="mdc-text-field__input" readonly id="accent_name" name="accent_name" value="{{ $accent->name }}" />
                                            <input type="hidden" id="accent_id" name="accent_id" value="{{ $accent->id }}" />
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
                                        <div class="mdc-text-field mdc-text-field--outlined">
                                            <input class="mdc-text-field__input" id="attribute_name" name="attribute_name" />
                                            <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch" style="">
                                                    <label for="attribute_name" class="mdc-floating-label" style="">Attribute Name</label>
                                                </div>
                                                <div class="mdc-notched-outline__trailing"></div>
                                            </div>
                                        </div>
                                        @error('attribute_name')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg invalid-feedback" id="text-field-outlined-helper-text">{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-text-field mdc-text-field--outlined">
                                            <input class="mdc-text-field__input" id="attribute_description" name="attribute_description" />
                                            <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch" style="">
                                                    <label for="attribute_description" class="mdc-floating-label" style="">Attribute Description</label>
                                                </div>
                                                <div class="mdc-notched-outline__trailing"></div>
                                            </div>
                                        </div>
                                        @error('attribute_description')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg invalid-feedback" id="text-field-outlined-helper-text">{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                            <i class="material-icons mdc-text-field__icon">attach_money</i>
                                            <input type="number" min="0" step="any" class="mdc-text-field__input" id="attribute_price" name="attribute_price">
                                            <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch" style="">
                                                    <label for="attribute_price" class="mdc-floating-label" style="">Attribute Price</label>
                                                </div>
                                                <div class="mdc-notched-outline__trailing"></div>
                                            </div>
                                        </div>
                                        @error('attribute_price')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg invalid-feedback" id="text-field-outlined-helper-text">{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
                                            <i class="material-icons mdc-text-field__icon">attachment</i>
                                            <input type="file" class="mdc-text-field__input accent-thumb-btn" id="attribute_image" name="attribute_image" />
                                            <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch" style="">
                                                    <label for="attribute_image" class="mdc-floating-label" style="">Attribute Image</label>
                                                </div>
                                                <div class="mdc-notched-outline__trailing"></div>
                                            </div>
                                        </div>
                                        @error('attribute_image')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg invalid-feedback" id="text-field-outlined-helper-text">{{ $message }}</p>
                                        </div>
                                        @enderror
                                        <img id="thread_thumb_disp" style="padding: 2px;" src="#" alt=""/>
                                    </div>


                                    <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-form-field">
                                            <div class="mdc-checkbox mdc-checkbox--secondary">
                                                <input
                                                        type="checkbox"
                                                        id="status"
                                                        name="status"
                                                        class="mdc-checkbox__native-control"
                                                        checked
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
        $("#thread_thumb_disp").hide();
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#thread_thumb_disp').attr('src', e.target.result)
                        .width('100px');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#attribute_image").change(function() {
            $("#thread_thumb_disp").show();
            readURL(this);
        });
        $(document).ready(function() {
            //$('#loader_IDIB').hide(3000);
            $('.dashboard').addClass('active');
            $('.product').removeClass('active');
            $('.drop-down-idib').removeClass('active');
        });
    </script>
@endsection