@extends('admin.layouts.app')

@section('styles')
    <style>
        .nav-tabs .nav-link {
            margin-bottom: -1px;
            background: 0 0;
            border: 1px solid transparent;
            border-top-left-radius: 0.3rem;
            border-top-right-radius: 0.3rem;
        }
        .nav-tabs-custom {
            border-bottom: none;
        }
    </style>
@endsection

@section('content')
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-12">
                    @include('admin.customers.includes.customer-top')
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title text-muted">Edit Customer Details</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.customer.update') }}" method="POST" class="needs-validation" novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <input type="hidden" name="id" value="{{ $customer->id }}">
                                            <label for="formrow-firstname-input" class="form-label text-muted">First Name</label>
                                            <input type="text" class="form-control" name="first_name" value="{{ $customer->first_name}}" required id="formrow-firstname-input">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="formrow-lastname-input" class="form-label text-muted">Last Name</label>
                                            <input type="text" class="form-control" name="last_name" value="{{ $customer->last_name}}" required id="formrow-lastname-input">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="formrow-email-input" class="form-label text-muted">Email</label>
                                            <input type="email" class="form-control" name="email" value="{{ $customer->email}}" required id="formrow-email-input">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="formrow-inputState" class="form-label text-muted">Status</label>
                                            <select id="formrow-inputState" class="form-select" name="status">
                                                {{-- <option value="Active" {{ ($customer->status == 1) ? 'selected' : ''}}>Active</option>
                                                <option value="Inactive" {{ ($customer->status == 0) ? 'selected' : ''}}>Inactive</option> --}}
                                                <option value="Active" {{ (App\Models\User::$status[$customer->status] == 'Active') ? 'selected' : ''}}>Active</option>
                                                <option value="Inactive" {{ (App\Models\User::$status[$customer->status] == 'Inactive') ? 'selected' : ''}}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    
                                </div>
                                @if(auth('admin')->user()->can('Update-Customers'))
                                <div class="d-flex align-items-start gap-3 mt-4">
                                    <button type="submit" class="btn btn-primary w-md ms-auto">Submit</button>
                                </div>
                                @endif
                            </form>
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







