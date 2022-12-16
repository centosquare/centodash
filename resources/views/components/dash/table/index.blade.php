<!--begin::Table-->
<table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 {{$tableClass ?? 'table-responsive'}}">
    <!--begin::Table head-->
    <thead>
    <tr class="fw-bold text-muted {{$tHeadRowClass ?? ''}}">
        @isset($th)
            @foreach($th as $th)
                <x-dash.table.th :class="$th['class'] ?? ''">{{$th['title'] ?? ''}}</x-dash.table.th>
            @endforeach
        @endisset
    </tr>
    </thead>
    <!--end::Table head-->
    <!--begin::Table body-->
    <tbody>
       {{$tBodyRow ?? ''}}
    </tbody>
    <!--end::Table body-->
</table>
<!--end::Table-->

