<div class="progress-card">

    <div class="progress-header">

        <div>

            <h4>{{ $title }}</h4>

            <small>{{ $subtitle }}</small>

        </div>

        <h2>{{ $percent }}%</h2>

    </div>

    <div class="progress modern-progress">

        <div
            class="progress-bar"
            style="width: {{ $percent }}%">
        </div>

    </div>

</div>