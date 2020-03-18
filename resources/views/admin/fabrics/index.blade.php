@extends('admin.layouts.master')

@section('content')
    <main class="content-wrapper">
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                    <div class="mdc-card p-0">
                        <div class="col-12 row">
                            <h6 style="float: left;" class="card-title card-padding mb-0 p-3">Fabrics</h6>
                            <h6 style="float: right;" class="card-title card-padding mb-0 p-3">
                                <a href="{{ route('admin.fabrics.add', [$product_id]) }}" class="mdc-button mdc-button--raised icon-button mdc-ripple-upgraded" title="Add Fabric">
                                    <i class="material-icons mdc-button__icon">add</i>
                                </a>
                            </h6>
                        </div>
                        <div class="mdc-data-table">
                            <table class="mdc-data-table__table" aria-label="Dessert calories">
                                <thead>
                                <tr class="mdc-data-table__header-row">
                                    <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Name</th>
                                    {{--<th class="mdc-data-table__header-cell" role="columnheader" scope="col">Description</th>--}}
                                    <th class="mdc-data-table__header-cell" role="columnheader" scope="col">Image</th>
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
                                            <td class="mdc-data-table__cell">{{ $item->name }}</td>
                                            {{--<td class="mdc-data-table__cell" id="u0">{{ $item->description }}</td>--}}
                                            <td class="mdc-data-table__cell">
                                                <a href="{{ asset('tool/images/fabric/suit').'/'. $item->fabric_image }}" class="" target="_blank" >
                                                    <img src="{{ asset('tool/images/fabric/suit').'/'.$item->fabric_image }}" width="60" />
                                                </a>
                                            </td>
                                            <td class="mdc-data-table__cell">
                                                <button
                                                        class="mdc-button mdc-button--raised icon-button {{ ($item->status == 1 ? 'filled-button--primary' : 'filled-button--danger') }} mdc-ripple-upgraded"
                                                        title="{{ ($item->status == 1 ? 'Active' : 'In Active') }}"
                                                >
                                                    <i class="material-icons mdc-button__icon">{{ ($item->status == 1 ? 'radio_button_checked' : 'radio_button_unchecked') }}</i>
                                                </button>
                                            </td>
                                            <td class="mdc-data-table__cell">
                                                <a href="{{ route('admin.fabrics.edit', [$item->product_id, $item->id]) }}" class="mdc-button mdc-button--raised icon-button mdc-ripple-upgraded">
                                                    <i class="material-icons mdc-button__icon">edit</i>
                                                </a>
                                                {{--<button class="mdc-button mdc-button--raised icon-button filled-button--secondary mdc-ripple-upgraded">
                                                    <i class="material-icons mdc-button__icon">delete</i>
                                                </button>--}}
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
