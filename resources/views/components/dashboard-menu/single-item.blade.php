<li class="nav-item">
    <a href="{{ $route }}" class="nav-link {{ mark_active($routes) }}">
        <i class="nav-icon {{ $iconStyle }} {{ $iconClass }}"></i>
        <p>{{ $slot }}</p>
    </a>
</li>
