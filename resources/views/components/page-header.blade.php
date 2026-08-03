<div class="page-header mb-4">

    <div>

        <h2 class="page-title">

            {{ $title }}

        </h2>

        @isset($subtitle)

        <p class="page-subtitle">

            {{ $subtitle }}

        </p>

        @endisset

    </div>

    @isset($action)

    <div>

        {!! $action !!}

    </div>

    @endisset

</div>