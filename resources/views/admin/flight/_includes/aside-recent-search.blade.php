<div class="user-sidebar">
                    
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Recent Searches</h4>
        </div>
        @foreach ($RecentSearch as $item)
        
            <div class="card-fly" data-originairport="{{ $item->data['origin'] }} - {{ AirportByCode($item->data['origin']) }}" data-origin="{{ $item->data['origin'] }}" data-departdate="{{ $item->data['departureDate'] }}" data-destinationairport="{{ $item->data['destination'] }} - {{ AirportByCode($item->data['destination']) }}" data-destination="{{ $item->data['destination'] }}" data-returndate="{{ $item->data['returnDate'] }}">
                <span>
                    <i class="fa fa-plane-departure departure-color"></i>
                    <h6>{{ $item->data['origin'] }}</h6>
                    <p>{{ $item->data['departureDate'] }}</p>
                </span>
                <span class="card-fly-fa">
                    <i class="fa fa-plane-arrival"></i>
                    <h6>{{ $item->data['destination'] }}</h6>
                    <p>{{ $item->data['returnDate'] }}</p>
                </span>
            </div>
        @endforeach
        
    </div>
    
</div>