@props(['id' => 'modal'])

<div class="modal-overlay" id="{{ $id }}" style="display: none;">
    <div class="modal-content">
        {{ $slot }}
    </div>
</div>
