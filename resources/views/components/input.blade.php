<label class="col-lg-8 col-form-label fw-bold fs-6">{{ $label }}</label>
<div class="col-lg-12 fv-row fv-plugins-icon-container">
    <input type="{{ $type }}" name="{{ $name }}" value="{{$value}}"
        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0">
    <div class="fv-plugins-message-container invalid-feedback"></div>
</div>

@error($error)
    <div class="text-danger">{{$message}}</div>
@enderror
