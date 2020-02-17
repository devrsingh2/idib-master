@extends('admin.layouts.master')

@section('content')
    <main class="content-wrapper">
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell--span-12">
                    <div class="mdc-card">
                        <h6 class="card-title">Add Fabric</h6>
                        <div class="template-demo">
                            <div class="mdc-layout-grid__inner">
                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                    <div class="mdc-text-field mdc-ripple-upgraded" style="--mdc-ripple-fg-size:267px; --mdc-ripple-fg-scale:1.71413; --mdc-ripple-fg-translate-start:224.5px, -118.5px; --mdc-ripple-fg-translate-end:89.2031px, -111px;">
                                        <input class="mdc-text-field__input" id="text-field-hero-input">
                                        <div class="mdc-line-ripple" style="transform-origin: 358px center;"></div>
                                        <label for="text-field-hero-input" class="mdc-floating-label">Name</label>
                                    </div>
                                </div>
                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                    <div class="mdc-text-field mdc-text-field--outlined">
                                        <input class="mdc-text-field__input" id="text-field-hero-input">
                                        <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch" style="">
                                                <label for="text-field-hero-input" class="mdc-floating-label" style="">Name</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-leading-icon">
                                        <i class="material-icons mdc-text-field__icon">favorite</i>
                                        <input class="mdc-text-field__input" id="text-field-hero-input">
                                        <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch" style="">
                                                <label for="text-field-hero-input" class="mdc-floating-label" style="">Name</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                    <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--with-trailing-icon">
                                        <i class="material-icons mdc-text-field__icon">visibility</i>
                                        <input class="mdc-text-field__input" id="text-field-hero-input">
                                        <div class="mdc-notched-outline mdc-notched-outline--upgraded">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch" style="">
                                                <label for="text-field-hero-input" class="mdc-floating-label" style="">Name</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
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
        </div>
    </main>
@endsection
