@props(['title'])

<div class="form-section">
    <h4 class="form-section-title">{{ $title }}</h4>
    {{ $slot }}
</div> 