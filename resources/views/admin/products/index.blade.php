@extends('admin.layouts.master')

@section('content')
    <main class="content-wrapper">
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                    <div class="mdc-card p-0">
                        <h6 class="card-title card-padding pb-0">Products</h6>
                        <div class="mdc-data-table">
                            <table class="mdc-data-table__table" aria-label="Dessert calories">
                                <thead>
                                <tr class="mdc-data-table__header-row">
                                    {{--<th class="mdc-data-table__header-cell mdc-data-table__header-cell--checkbox" role="columnheader" scope="col">
                                        <div class="mdc-checkbox mdc-data-table__header-row-checkbox mdc-checkbox--selected">
                                            <input type="checkbox" class="mdc-checkbox__native-control" aria-label="Checkbox for header row selection"/>
                                            <div class="mdc-checkbox__background">
                                                <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                    <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                                                </svg>
                                                <div class="mdc-checkbox__mixedmark"></div>
                                            </div>
                                        </div>
                                    </th>--}}
                                    <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Name</th>
                                    <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Description</th>
                                    <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Logo</th>
                                    <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Status</th>
                                    <th class="mdc-data-table__header-cell" role="columnheader" scope="col">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="mdc-data-table__content">
                                @if(isset($items))
                                    @foreach($items as $k => $item)
                                        <tr data-row-id="u0" class="mdc-data-table__row">
                                            {{--<td class="mdc-data-table__cell mdc-data-table__cell--checkbox">
                                                <div class="mdc-checkbox mdc-data-table__row-checkbox">
                                                    <input type="checkbox" class="mdc-checkbox__native-control" aria-labelledby="u0"/>
                                                    <div class="mdc-checkbox__background">
                                                        <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                                            <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                                                        </svg>
                                                        <div class="mdc-checkbox__mixedmark"></div>
                                                    </div>
                                                </div>
                                            </td>--}}
                                            <td class="mdc-data-table__cell">{{ $item->name }}</td>
                                            <td class="mdc-data-table__cell" id="u0">{{ $item->description }}</td>
                                            <td class="mdc-data-table__cell">
                                                <a href="{{ $item->logo }}" class="" target="_blank" >
                                                    <img src="{{ $item->logo }}" width="40" />
                                                </a>
                                            </td>
                                            <td class="mdc-data-table__cell">{{ $item->status }}</td>
                                            <td class="mdc-data-table__cell">
                                                <button class="mdc-button mdc-button--raised icon-button mdc-ripple-upgraded">
                                                    <i class="material-icons mdc-button__icon">edit</i>
                                                </button>
                                                <button class="mdc-button mdc-button--raised icon-button filled-button--secondary mdc-ripple-upgraded">
                                                    <i class="material-icons mdc-button__icon">delete</i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
