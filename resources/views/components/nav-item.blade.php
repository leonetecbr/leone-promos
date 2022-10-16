<li class="nav-item">
    <a href="{{ $isActive ? '#' : $url }}" {{ $attributes->class([
        'nav-link',
        'active' => $isActive
    ])->merge([
        'aria-current' => $isActive ? 'page' : null,
    ]) }}>
        {{ $title }}
    </a>
</li>
