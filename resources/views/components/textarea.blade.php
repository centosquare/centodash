<div {{$attributes->merge(['class' => $class.'container'])}} >
    <label class="col-lg-8 col-form-label required fw-bold fs-6">{{ $label }}</label>
    <textarea type="{{ $type }}" name="{{ $name }}"  rows="5"
        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0">{{$value}}</textarea>
    <div class="fv-plugins-message-container invalid-feedback"></div>
</div>
@error($error)
    <span class="text-danger">{{ $message }}</span>
@enderror
