@props(['label' => '', 'name' => '', 'options' => [], 'required' => false])

<div class="form-group">
    @if($label)
        <label for="{{ $name }}" class="form-label">{{ $label }} @if($required) * @endif</label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        class="form-select"
        x-model="form.{{ $name }}"
        {{ $required ? 'required' : '' }}
    >
        @foreach($options as $value => $text)
            <option value="{{ $value }}">{{ $text }}</option>
        @endforeach
    </select>
</div>
