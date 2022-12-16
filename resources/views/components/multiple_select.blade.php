<div class="col-lg-12 fv-row fv-plugins-icon-container">
    <label class="col-lg-8 col-form-label required fw-bold fs-6">{{$label}}</label>
    <select name={{$name}} class="form-select form-select-solid" data-control="select2" multiple>
        <option class="class='col-lg-8 col-form-label required fw-bold fs-6"> Select {{$label}} </option>
        @foreach ($key as $value)
            <option value="{{ $value->id }}">{{ $value->name }}</option>
        @endforeach
    </select>
</div>

@error($error)
    <div class="error text-danger">{{ $message }}</div>
@enderror
