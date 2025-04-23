<div class="card border shadow-none" style="">
    <div class="card-body" style="padding-bottom: 2px;">
        <div class="d-flex align-items-start border-bottom pb-3">
            <div class="me-4">
                @if($customer->image =='')
                    <img src="{{ asset('assets/admin-images/user2.png') }}" alt="" class="avatar-lg rounded">
                @else
                    <img src="{{ asset($customer->image) }}" alt="" class="avatar-lg rounded">
                @endif
            </div>
            <div class="flex-grow-1 align-self-center overflow-hidden">
                <div>
                    <h5 class="text-truncate font-size-18">
                        <a href="ecommerce-product-detail-2.html" class="text-dark">{{ $customer->name }}</a>
                    </h5>
                    @php
                        if(App\Models\User::$status[$customer->status] == 'Active')
                            $status = 'success';
                        else{
                            $status = 'danger';
                        }
                    @endphp
                    <p class="mb-0 mt-1">Status : <span class="fw-medium badge badge-soft-{{$status}}">
                        {{ App\Models\User::$status[$customer->status] }}
                    </span></p>
                    <p class="mb-0 mt-1">Created at: <span class="fw-medium">
                        {{ date('d M Y',strtotime($customer->created_at)) }}
                    </span></p>
                </div>
            </div>
            
        </div>
        <div>
            <div class="row">
                <div class="col-md-6">
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        @if(auth('admin')->user()->can('Read-Users'))
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/customer-detail/*') ? 'active' : '' }}" href="{{ route('admin.customer.view',[$customer->id]) }}" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">edit</span> 
                                </a>
                            </li>
                        @endif

                        @if(auth('admin')->user()->can('Read-Booking'))
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Bookings</span> 
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>