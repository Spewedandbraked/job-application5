@props(['type' => 'button', 'variant' => 'primary', 'size' => ''])

<button {{ $attributes->merge([
    'type' => $type,
    'class' => 'btn btn-' . $variant . ' ' . ($size ? 'btn-' . $size : '')
]) }}>
    {{ $slot }}
</button>
