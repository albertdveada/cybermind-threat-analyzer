@props(['message', 'type' => 'error'])

@if ($message)
<div class="alert-container {{ $type == 'success' ? 'alert-success' : 'alert-error' }}" role="alert">
    <div class="alert-content">
        @if ($type == 'success')
            <i class="fas fa-check-circle alert-icon"></i>
        @else
            <i class="fas fa-times-circle alert-icon"></i>
        @endif
        <p class="alert-message">{!! $message !!}</p>
    </div>
    <button type="button" class="alert-close">
        <i class="fas fa-times"></i>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const closeButton = document.querySelector('.alert-close');
        const alertContainer = document.querySelector('.alert-container');

        if (closeButton && alertContainer) {
            closeButton.addEventListener('click', function() {
                alertContainer.style.opacity = '0';
                alertContainer.style.height = '0';
                alertContainer.style.padding = '0';
                alertContainer.style.margin = '0';
                setTimeout(() => alertContainer.remove(), 300);
            });
        }
    });
</script>
@endif
