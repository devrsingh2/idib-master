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
                        <h6 class="card-title">Add Category</h6>
                        <div class="template-demo">
                            <div class="mdc-layout-grid__inner">
                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                    <div class="mdc-text-field mdc-text-field--outlined">
                                        <input class="mdc-text-field__input" id="fabric_name" name="fabric_name" />
                                        <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch" style="">
                                                <label for="fabric_name" class="mdc-floating-label" style="">Fabric Name</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                        <i class="material-icons mdc-text-field__icon">attach_money</i>
                                        <input class="mdc-text-field__input" id="fabric_price" name="fabric_price">
                                        <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch" style="">
                                                <label for="fabric_price" class="mdc-floating-label" style="">Fabric Price</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
                                        <i class="material-icons mdc-text-field__icon">attachment</i>
                                        <input type="file" class="mdc-text-field__input fabric-thumb-btn" id="fabric_thumb" name="fabric_thumb" />
                                        <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch" style="">
                                                <label for="fabric_thumb" class="mdc-floating-label" style="">Fabric Image (100 x 100)</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                    </div>
                                    <img id="thumb_image" style="padding: 2px;" src="#" alt=""/>
                                </div>

                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                        <i class="material-icons mdc-text-field__icon">attachment</i>
                                        <input type="file" class="mdc-text-field__input fabric-thumb-btn" id="medium_thumb" name="medium_thumb" />
                                        <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch" style="">
                                                <label for="medium_thumb" class="mdc-floating-label" style="">Medium Image (360 x 360)</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                    </div>
                                    <img id="medium_image" style="padding: 2px;" src="#" alt=""/>
                                </div>

                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
                                        <i class="material-icons mdc-text-field__icon">attachment</i>
                                        <input type="file" class="mdc-text-field__input fabric-thumb-btn" id="large_thumb_image" name="large_thumb_image" />
                                        <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch" style="">
                                                <label for="large_thumb_image" class="mdc-floating-label" style="">Large Image (100 x 100)</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                    </div>
                                    <img id="large_image" style="padding: 2px;" src="#" alt=""/>
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