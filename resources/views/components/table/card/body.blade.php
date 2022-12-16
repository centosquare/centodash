 @props([
    'headers' => [],
])
 <!--begin::Body-->
 <div class="card-body py-3">
     <!--begin::Table container-->
     <div class="table-responsive">
         <!--begin::Table-->
         <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
             <!--begin::Table head-->
             <thead>
                 <tr class="fw-bold text-muted">
                     @foreach ($headers as $th)
                         <x-table.th>{{ $th }}</x-table.th>
                     @endforeach
                 </tr>
             </thead>
             <!--end::Table head-->
             <!--begin::Table body-->
             <tbody>
                 {{ $tr ?? '' }}
             </tbody>
             <!--end::Table body-->
         </table>
         <!--end::Table-->
     </div>
     <!--end::Table container-->
 </div>
 <!--begin::Body-->
