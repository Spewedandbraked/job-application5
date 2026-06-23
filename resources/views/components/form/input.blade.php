@props(['label' => '', 'name' => '', 'type' => 'text', 'required' => false])

<div class="form-group">
    @if($label)
        <label for="{{ $name }}" class="form-label">{{ $label }} @if($required) * @endif</label>
    @endif

    @if($type === 'textarea')
        <textarea
            name="{{ $name }}"
            id="{{ $name }}"
            class="form-input"
            x-model="form.{{ $name }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes }}
        ></textarea>
    @else
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            class="form-input"
            x-model="form.{{ $name }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes }}
        />
    @endif
</div>
