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
            <form name="frm_add_fabric" method="post" action="{{ route('admin.fabrics.store', [$product_id]) }}" enctype="multipart/form-data">
                @csrf
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell--span-12">
                        <div class="mdc-card">
                            <h6 class="card-title">Add Fabric</h6>
                            <div class="template-demo">
                                <div class="mdc-layout-grid__inner">
                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
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
                                        @error('fabric_name')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg invalid-feedback" id="text-field-outlined-helper-text">{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                            <i class="material-icons mdc-text-field__icon">attach_money</i>
                                            <input type="number" min="0" step="any" class="mdc-text-field__input" id="fabric_price" name="fabric_price">
                                            <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch" style="">
                                                    <label for="fabric_price" class="mdc-floating-label" style="">Fabric Price</label>
                                                </div>
                                                <div class="mdc-notched-outline__trailing"></div>
                                            </div>
                                        </div>
                                        @error('fabric_price')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg invalid-feedback" id="text-field-outlined-helper-text">{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
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
                                        @error('fabric_thumb')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg invalid-feedback" id="text-field-outlined-helper-text">{{ $message }}</p>
                                        </div>
                                        @enderror
                                        <img id="thumb_image" style="padding: 2px;" src="#" alt=""/>
                                    </div>

                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
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
                                        @error('medium_thumb')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg invalid-feedback" id="text-field-outlined-helper-text">{{ $message }}</p>
                                        </div>
                                        @enderror
                                        <img id="medium_image" style="padding: 2px;" src="#" alt=""/>
                                    </div>

                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
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
                                        @error('large_thumb_image')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg invalid-feedback" id="text-field-outlined-helper-text">{{ $message }}</p>
                                        </div>
                                        @enderror
                                        <img id="large_image" style="padding: 2px;" src="#" alt=""/>
                                    </div>


                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-select demo-width-class mt-2" data-mdc-auto-init="MDCSelect">
                                            <input type="hidden" name="material_parent">
                                            <i class="mdc-select__dropdown-icon"></i>
                                            <div class="mdc-select__selected-text"></div>
                                            <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                <ul class="mdc-list">
                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="" aria-selected="true">
                                                    </li>
                                                    @if(isset($cat_arr['material']) && isset($cat_arr['material']->trans))
                                                        @foreach($cat_arr['material']->trans as $k => $item)
                                                            <li class="mdc-list-item" data-value="{{ $item->id }}">
                                                                {{ $item->name }}
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                            <span class="mdc-floating-label">Material Parent</span>
                                            <div class="mdc-line-ripple"></div>
                                        </div>
                                        @error('material_parent')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg invalid-feedback" id="text-field-outlined-helper-text">{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-select demo-width-class mt-2" data-mdc-auto-init="MDCSelect">
                                            <input type="hidden" name="pattern_parent">
                                            <i class="mdc-select__dropdown-icon"></i>
                                            <div class="mdc-select__selected-text"></div>
                                            <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                <ul class="mdc-list">
                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="" aria-selected="true">
                                                    </li>
                                                    @if(isset($cat_arr['pattern']) && isset($cat_arr['pattern']->trans))
                                                        @foreach($cat_arr['pattern']->trans as $k => $item)
                                                            <li class="mdc-list-item" data-value="{{ $item->id }}">
                                                                {{ $item->name }}
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                            <span class="mdc-floating-label">Pattern Parent</span>
                                            <div class="mdc-line-ripple"></div>
                                        </div>
                                        @error('pattern_parent')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg invalid-feedback" id="text-field-outlined-helper-text">{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-select demo-width-class mt-2" data-mdc-auto-init="MDCSelect">
                                            <input type="hidden" name="season_parent">
                                            <i class="mdc-select__dropdown-icon"></i>
                                            <div class="mdc-select__selected-text"></div>
                                            <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                <ul class="mdc-list">
                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="" aria-selected="true">
                                                    </li>
                                                    @if(isset($cat_arr['season']) && isset($cat_arr['season']->trans))
                                                        @foreach($cat_arr['season']->trans as $k => $item)
                                                            <li class="mdc-list-item" data-value="{{ $item->id }}">
                                                                {{ $item->name }}
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                            <span class="mdc-floating-label">Season Parent</span>
                                            <div class="mdc-line-ripple"></div>
                                        </div>
                                        @error('season_parent')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg invalid-feedback" id="text-field-outlined-helper-text">{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-select demo-width-class mt-2" data-mdc-auto-init="MDCSelect">
                                            <input type="hidden" name="color_parent">
                                            <i class="mdc-select__dropdown-icon"></i>
                                            <div class="mdc-select__selected-text"></div>
                                            <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                <ul class="mdc-list">
                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="" aria-selected="true">
                                                    </li>
                                                    @if(isset($cat_arr['color']) && isset($cat_arr['color']->trans))
                                                        @foreach($cat_arr['color']->trans as $k => $item)
                                                            <li class="mdc-list-item" data-value="{{ $item->id }}">
                                                                {{ $item->name }}
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                            <span class="mdc-floating-label">Color Parent</span>
                                            <div class="mdc-line-ripple"></div>
                                        </div>
                                        @error('color_parent')
                                        <div class="mdc-text-field-helper-line">
                                            <p class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg invalid-feedback" id="text-field-outlined-helper-text">{{ $message }}</p>
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6-desktop">
                                        <div class="mdc-select demo-width-class mt-2" data-mdc-auto-init="MDCSelect">
                                            <input type="hidden" name="category_parent">
                                            <i class="mdc-select__dropdown-icon"></i>
                                            <div class="mdc-select__selected-text"></div>
                                            <div class="mdc-select__menu mdc-menu-surface demo-width-class">
                                                <ul class="mdc-list">
                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="" aria-selected="true">
                                                    </li>
                                                    @if(isset($cat_arr['category']) && isset($cat_arr['category']->trans))
                                                        @foreach($cat_arr['category']->trans as $k => $item)
                                                            <li class="mdc-list-item" data-value="{{ $item->id }}">
                                                                {{ $item->name }}
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                            <span class="mdc-floating-label">Category Parent</span>
                                            <div class="mdc-line-ripple"></div>
                                        </div>
                                        @error('category_parent')
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