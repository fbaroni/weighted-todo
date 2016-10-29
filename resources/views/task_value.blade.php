
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2">
            <h2>{{ $title }}</h2>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            @if($valuation > 60.0)
                <h1 class="text-success">
            @elseif($valuation > 35.0)
                <h1 class="text-warning">
            @else
                <h1 class="text-danger">
            @endif
            {{ round($valuation, 2) }}&nbsp; %</h1>
        </div>
    </div>