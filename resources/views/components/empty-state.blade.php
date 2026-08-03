<div class="empty-state">

    <i class="bi bi-folder2-open display-1 text-primary"></i>

    <h4 class="mt-3">

        {{ $title }}

    </h4>

    <p class="text-muted">

        {{ $description }}

    </p>

    @isset($button)

        {!! $button !!}

    @endisset

</div>