@php
    $pageNameMode = trans('Settings::settings.main_information');
    $breadcrumbs[] = ['url' => '', 'name' => trans('Settings::settings.setting').' '.trans('Settings::settings.main_information')];
    $action = action('\Idib\Settings\Controllers\SettingsController@updateInformation');
    $submitButton = trans('admin.update');
@endphp
@extends('admin.master')
@section('title')
    {{ trans('Settings::settings.settings') }}: {{ $pageNameMode }}
@endsection
@section('header')

@endsection
@section('content')
    <!-- Form validation -->
    <div class="card">
        <div class="card-body">
            <form class="form-validate-jquery" method="POST" action="{{ $action }}" novalidate="novalidate">
                @csrf
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold">{{ $pageNameMode }}</legend>

                @include('Core::fields.input_text', [
                            'field_name' => 'name',
                            'name' => trans('Settings::settings.name'),
                            'value' => $name,
                            'required' => '',
                            'placeholder' => ''
                        ])

                @include('Core::fields.input_text', [
                    'field_name' => 'address',
                    'name' => trans('Settings::settings.paddress'),
                    'value' => $address,
                    'placeholder' => ''
                ])
                @include('Core::fields.input_text', [
                    'field_name' => 'email',
                    'name' => trans('Settings::settings.email'),
                    'value' => $email,
                    'placeholder' => ''
                ])
                @include('Core::fields.input_text', [
                    'field_name' => 'phone',
                    'name' => trans('Settings::settings.phone'),
                    'value' => $phone,
                    'placeholder' => ''
                ])

                @include('Core::fields.select', [
                    'field_name' => 'date_format',
                    'name' => 'Date Format',
                    'value' => $date_format,
                    'options' => [
                                    ['value' => '', 'name' => 'Select Date Format'],
                                    ['value' => 'Y-m-d', 'name' => date('Y-m-d')],
                                    ['value' => 'Y-m-d H:i:s', 'name' => date('Y-m-d H:i:s')],
                                    ['value' => 'd-m-Y', 'name' => date('d-m-Y')],
                                    ['value' => 'd-m-Y H:i:s', 'name' => date('d-m-Y H:i:s')],
                                    ['value' => 'F j, Y g:i a', 'name' => date('F j, Y g:i a')],
                                    ['value' => 'F j, Y g:i A', 'name' => date('F j, Y g:i A')],
                                    ['value' => 'm.d.y', 'name' => date('m.d.y')],
                                    ['value' => 'm.d.y H:i:s', 'name' => date('m.d.y H:i:s')],
                    ]
                ])

                @include('Core::fields.input_text', [
                    'field_name' => 'pagination',
                    'name' => 'Per Page Record',
                    'placeholder' => 'Per Page Record',
                    'value' => $pagination
                ])

                @include('Core::fields.select', [
                    'field_name' => 'is_multilingual',
                    'name' => trans('Settings::settings.is_multilingual'),
                    'value' => $is_multilingual,
                    'options' => [
                                    ['value' => '', 'name' => '-- '.trans('Core::operations.select').' --'],
                                    ['value' => 1, 'name' => trans('Core::operations.yes')],
                                    ['value' => 2, 'name' => trans('Core::operations.no')]
                    ]
                ])

                </fieldset>

                <div class="d-flex justify-content-end align-items-center">
                    <button type="reset" class="btn btn-danger legitRipple" id="reset">Reset <i class="icon-reload-alt ml-2"></i></button>
                    <button type="submit" class="btn btn-success ml-3 legitRipple">Submit <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- /form validation -->
@endsection
@section('footer')
    <!--page level js -->
    <!-- Theme JS files -->
    <script src="{{ url('/') }}/assets/js/plugins/forms/validation/validate.min.js"></script>
    <script src="{{ url('/') }}/assets/js/plugins/forms/inputs/touchspin.min.js"></script>
    <script src="{{ url('/') }}/assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="{{ url('/') }}/assets/js/plugins/forms/styling/switch.min.js"></script>
    <script src="{{ url('/') }}/assets/js/plugins/forms/styling/switchery.min.js"></script>
    <script src="{{ url('/') }}/assets/js/plugins/forms/styling/uniform.min.js"></script>

    <script src="{{ url('/') }}/assets/js/pages/form_validation.js"></script>
    <!--end of page level js-->
@endsection