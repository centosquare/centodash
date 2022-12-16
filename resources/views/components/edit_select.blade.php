<div class="col-lg-12 fv-row fv-plugins-icon-container">
    <label class="col-lg-8 col-form-label required fw-bold fs-6">{{ $label }}</label>
    <select name="{{ $name }}" class="btn btn-secondary dropdown-toggle col-md-12 text-right">
        <option value=""> Select {{ $label }} </option>
        @foreach ($key as $value)
            <option value="{{ $value->id }}"{{ $route->$name == $value->id ? 'selected' : '' }}>
                {{ $value->name }}</option>
        @endforeach
    </select>
</div>
@error($error)
    <div class="error text-danger">{{ $message }}</div>
@enderror
