@extends('admin.layouts.app')

@section('styles')

@endsection

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="card">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        {{-- @if(auth('admin')->user()->can('Read-smtp')) --}}
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#smtp_tab" role="tab">
                                <i class="bx bx-mail-send font-size-20"></i>
                                <span class="d-none d-sm-block">APIS</span> 
                            </a>
                        </li>
                        {{-- @endif --}}
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#pgw_tab" role="tab">
                                <i class="bx bx-clipboard font-size-20"></i>
                                <span class="d-none d-sm-block">PGW</span> 
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#post" role="tab">
                                <i class="bx bx-image font-size-20"></i>
                                <span class="d-none d-sm-block">Post</span>   
                            </a>
                        </li>
                    </ul>
                    <!-- Tab content -->
                    <div class="tab-content p-4">
                        {{-- @if(auth('admin')->user()->can('Read-smtp')) --}}
                        <div class="tab-pane active" id="smtp_tab" role="tabpanel">
                            <div>
                                <div>
                                    <h5 class="font-size-16 mb-4">Smtp Management</h5>

                                    <ol class="activity-checkout mb-0 px-4 mt-3">
                                        @foreach ($smtp as $item)
                                            <li class="checkout-item">
                                                <div class="feed-item-list">
                                                    <div>
                                                        <div style="display: flex; justify-content: space-between;">
                                                            <div>
                                                                <h5 class="font-size-16 mb-1">{{ $item->name }}</h5>
                                                                <p class="text-muted text-truncate mb-2">{{ date('d-m-Y',strtotime($item->updated_at)) }} </p>
                                                            </div>
                                                            {{-- @if(auth('admin')->user()->can('Update-smtp')) --}}
                                                            <a href="{{ route('admin.setting.smtp.edit', ['smtp' => $item->id]) }}" class="icon-demo-content">
                                                                <i class="bx bx-pencil font-size-26" style="border-radius: 3rem"></i>
                                                            </a>
                                                            {{-- @endif --}}
                                                        </div>
                                                        <div class="mb-3">
                                                            @foreach ($item->data as $key => $fields)
                                                                <p>{{ $key }}: {{ $fields }}</p>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                        </div>
                        {{-- @endif --}}
                        <div class="tab-pane" id="pgw_tab" role="tabpanel">
                            
                        </div>

                        

                        <div class="tab-pane" id="post" role="tabpanel">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')

@endsection
