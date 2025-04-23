@extends('admin.layouts.app')

@section('styles')

@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <h5 class="card-title">Why Choose Us<span class="text-muted fw-normal ms-2"></span></h5>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                            @if (count($choose) < 4)
                                {{-- @if(auth('admin')->user()->can('Create-Users')) --}}
                                    <div>
                                        <a href="#" data-bs-toggle="modal" data-bs-target=".add-new" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Add New </a>
                                    </div>
                                {{-- @endif --}}
                            @endif
                            
                        </div>

                    </div>
                </div>

                <!-- end row -->

                <div class="row" >
                    <div class="col-lg-16">
                        <div class="">
                            <div class="table-responsive">
                                <table class="table project-list-table table-nowrap align-middle table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col" class="ps-4" style="width: 50px;">
                                                Icon
                                            </th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                     
                                          </tr>
                                    </thead>

                                    <tbody>

                                        
                                         @foreach ($choose as $key => $choose)
                                        <tr>
                                            <td scope="col" class="ps-4" style="width: 50px;">
                                                {{ $loop->index+1 }}
                                            </td>
                                            <td>
                                                <img src="{{  asset('Choose/'.$choose->icon) }}"  alt="" class="avatar-sm me-2">
                                            </td>
                                            <td>{{ $choose->title }}</td>
                                            <td>{{$choose->description}}</td>
                                            



                                            <td>
                                                @if ($choose->status == 1)
                                                    <span class="badge badge-soft-success mb-0">Active</span>
                                                @else
                                                    <span class="badge badge-soft-danger mb-0">In Active</span>
                                                @endif
                                                
                                            </td>
                                            <td>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="{{ url('choose-edit/'.$choose->id) }}" data-bs-toggle="modal" data-bs-target=".update_choose_{{$choose->id}}">
                                                            <i class="bx bx-show-alt font-size-18"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                            <a href="{{ url('admin/choose-delete/'.$choose->id)}}" class="text-danger" onclick="return confirm('Are You Sure To Delte This ?')">
                                                            <i class="bx bx-trash-alt font-size-18"></i>
                                                        </a>
                                                    </li> 
                                            </ul>
                                        </tr>
                                        {{-- Modal Start --}}
                                        <div class="modal fade update_choose_{{$choose->id}}" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myExtraLargeModalLabel">Update Choose</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ url('admin/choose-update')}}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$choose->id}}">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        
                                                                        <label class="form-label" for="AddNew-icon">Icon</label>
                                                                        <input type="file" class="form-control" name="icon" placeholder="Select Icon File" id="AddNew-icon">
                                                                         <img src="{{  asset('Choose/'.$choose->icon) }}"  alt="" class="avatar-sm me-2">
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="AddNew-title">Title</label>
                                                                        <input type="text" class="form-control" name="title" value="{{$choose->title}}" placeholder="Enter Title" id="AddNew-title">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="AddNew-description">Description</label>
                                                                        <input type="description" class="form-control" name="description" value="{{$choose->description}}" placeholder="description" id="AddNew-description">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Status</label>
                                                                        <select class="form-select" name="status">
                                                                            <option value="1" @if($choose->status == 1) selected @endif>Active</option>
                                                                            <option value="0" @if($choose->status == 0) selected @endif>Disabled</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                        
                                                            </div>
                                                            <div class="row mt-2">
                                                                <div class="col-12 text-end">
                                                                    <button type="button" class="btn btn-danger me-1" data-bs-dismiss="modal"><i class="bx bx-x me-1"></i> Cancel</button>
                                                                    <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#success-btn" id="btn-save-event"><i class="bx bx-check me-1"></i> Confirm</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div>
                                    {{-- Modal End --}}
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

            <!--  Extra Large modal example -->
            <div class="modal fade add-new" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myExtraLargeModalLabel">Add New Icon</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('/admin/choose-save') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="AddNew-icon">Icon</label>
                                            <input type="file" class="form-control" name="icon" placeholder="Select Icon File" id="AddNew-icon">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="AddNew-title">Title</label>
                                            <input type="text" class="form-control" name="title" placeholder="Enter Title" id="AddNew-title">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="AddNew-data">Description</label>
                                            <input type="text" class="form-control" name="description" placeholder="description" id="AddNew-description">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" name="status">
                                                <option value="1">Active</option>
                                                <option value="0">Disabled</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                            
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-danger me-1" data-bs-dismiss="modal"><i class="bx bx-x me-1"></i> Cancel</button>
                                        <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#success-btn" id="btn-save-event"><i class="bx bx-check me-1"></i> Confirm</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
    </div>
@endsection

@section('scripts')

@endsection
