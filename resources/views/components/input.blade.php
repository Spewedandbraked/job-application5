@props(['label' => '', 'name' => '', 'type' => 'text', 'value' => '', 'required' => false])

<div class="form-group">
    @if($label)
        <label for="{{ $name }}" class="form-label">{{ $label }} @if($required) * @endif</label>
    @endif
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'form-input']) }}
    />
    @error($name)
        <div class="form-error">{{ $message }}</div>
    @enderror
</div>
