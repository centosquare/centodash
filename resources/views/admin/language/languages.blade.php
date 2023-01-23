<x-layout.master>
    <x-slot name="header">
        <x-layout.header />
    </x-slot>
    <x-slot name="left_side_nav">
        <x-layout.left_side_nav />
    </x-slot>
    <x-slot name="content">
        <meta name="csrf-token" content="{{ csrf_token() }}" />


        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" />

        <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css"
            rel="stylesheet" />

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js">
        </script>

        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
            <div class="p-5">
                @if (Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                @endif
                @if (Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                <div class="card mb-5 mb-xl-8" style="user-select: auto;">
                    <!--begin::Body-->
                    <div class="card-body pt-3" style="user-select: auto;">
                        <!--begin::Table container-->
                        <div class="table-responsive" style="user-select: auto;">
                            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                                <div class="p-5">
                                    <div class="card mb-5 mb-xl-8" style="user-select: auto;">
                                        <div class="card-body pt-3" style="user-select: auto;">
                                            <div class="container">

                                                <div class='text-center'>

                                                    <a href="{{ route('newlyConfig') }}" class="btn btn-info">Sync
                                                        New
                                                        Config</a>

                                                    <a href="{{ route('addLanguage') }}" class="btn btn-info">Add
                                                        New
                                                        Language</a>

                                                </div>
                                                <form method="POST" action="{{ route('translations.create') }}">

                                                    @csrf

                                                    <div class="row my-10">

                                                        <div class="col-md-4">

                                                            <label>Key:</label>

                                                            <input type="text" name="key" class="form-control"
                                                                placeholder="Enter Key...">

                                                        </div>

                                                        <div class="col-md-4">

                                                            <label>Value:</label>

                                                            <input type="text" name="value" class="form-control"
                                                                placeholder="Enter Value...">

                                                        </div>

                                                        <div class="col-md-4">

                                                            <button type="submit"
                                                                class="btn btn-success my-5 ">Add</button>

                                                        </div>
                                                    </div>

                                                </form>

                                                <table class="table table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="ps-7">Key</th>
                                                            @if ($languages->count() > 0)
                                                                @foreach ($languages as $language)
                                                                    <th>{{ $language->name }}({{ $language->code }})
                                                                        <a href="{{ route('delete', $language->id) }}"
                                                                            class='bi bi-trash fs-4'> Delete </a>
                                                                    </th>
                                                                @endforeach
                                                            @endif
                                                            <th width="80px;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($columnsCount > 0)
                                                            @foreach ($columns[0] as $columnKey => $columnValue)
                                                                <tr>
                                                                    <td><a href="#" class="translate-key"
                                                                            data-title="Enter Key" data-type="text"
                                                                            data-pk="{{ $columnKey }}"
                                                                            data-url="{{ route('translation.update.json.key') }}">{{ $columnKey }}</a>
                                                                    </td>
                                                                    @for ($i = 1; $i <= $columnsCount; ++$i)
                                                                        <td><a href="#"
                                                                                data-title="Enter Translate"
                                                                                class="translate"
                                                                                data-code="{{ $columns[$i]['lang'] }}"
                                                                                data-type="textarea"
                                                                                data-pk="{{ $columnKey }}"
                                                                                data-url="{{ route('translation.update.json') }}">{{ isset($columns[$i]['data'][$columnKey]) ? $columns[$i]['data'][$columnKey] : '' }}</a>
                                                                        </td>
                                                                    @endfor
                                                                    <td>

                                                                            <a href="{{ route('translations.destroy', $columnKey) }}" class="btn btn-icon btn-danger btn-sm">
                                                                                <i class="bi bi-trash fs-4"></i>
                                                                            </a>
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
                        </div>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                $.ajaxSetup({

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    }

                });

                $('.translate').editable({

                    params: function(params) {

                        params.code = $(this).data('code');

                        return params;

                    }

                });


                $('.translate-key').editable({

                    validate: function(value) {

                        if ($.trim(value) == '') {

                            return 'Key is required';

                        }

                    }

                });
            </script>
    </x-slot>
    <x-slot name="footer">
        <x-layout.footer />
    </x-slot>
</x-layout.master>
