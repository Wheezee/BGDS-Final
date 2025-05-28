@props([
    'title' => null,
    'headerClass' => '',
    'bodyClass' => '',
    'footer' => null
])

<div class="card">
    @if($title)
        <div class="card-header {{ $headerClass }}">
            {{ $title }}
        </div>
    @endif
    <div class="card-body {{ $bodyClass }}">
        {{ $slot }}
    </div>
    @if($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div> 