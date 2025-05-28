@props(['title'])

<div class="info-section">
    <h4 class="info-section-title">{{ $title }}</h4>
    {{ $slot }}
</div> 