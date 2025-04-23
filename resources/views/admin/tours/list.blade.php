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
                            <h5 class="card-title">Popular Tours<span class="text-muted fw-normal ms-2">(10)</span></h5>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                            @if (count($tours) < 3)
                            {{-- @if(auth('admin')->user()->can('Create-Users')) --}}
                                <div>
                                    <a href="#" data-bs-toggle="modal" data-bs-target=".add-new" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Add New</a>
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
                                            <th scope="col">S.No</th>
                                            <th scope="col" class="ps-4" style="width: 50px;">
                                                Banner Image
                                            </th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                     
                                          </tr>
                                    </thead>

                                    <tbody>

                                        
                                         @foreach ($tours as $key => $tour)
                                        <tr>
                                            <td scope="col" class="ps-4" style="width: 50px;">
                                                {{ $loop->index+1 }}
                                            </td>
                                            <td>
                                                <img src="{{  asset('Tours/'.$tour->Banner_Image) }}"  alt="" class="avatar-sm me-2">
                                            </td>
                                            <td>{{ $tour->Title }}</td>
                                            <td>{{$tour->Price}}</td>
                                            



                                            <td>
                                                @if ($tour->Status == 1)
                                                    <span class="badge badge-soft-success mb-0">Active</span>
                                                        
                                                    @else
                                                    <span class="badge badge-soft-danger mb-0">In Active</span>
                                                        
                                                    @endif
                                                
                                            </td>
                                            <td>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target=".update_tour_{{$tour->id}}">
                                                            <i class="bx bx-show-alt font-size-18"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                            <a href="{{ url('admin/tours-delete/'.$tour->id)}}" class="text-danger" onclick="return confirm('Are You Sure To Delte This ?')">
                                                            <i class="bx bx-trash-alt font-size-18"></i>
                                                        </a>
                                                    </li> 
                                            </ul>
                                        </tr>
                                        {{-- Modal Start --}}
                                        <div class="modal fade update_tour_{{$tour->id}}" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myExtraLargeModalLabel">Update Tour</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ url('admin/tours-update')}}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$tour->id}}">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="AddNew-banner_image">Banner Image</label>
                                                                        <input type="file" class="form-control" name="banner_image" placeholder="Select Img File" id="AddNew-banner_image">
                                                                         <img src="{{  asset('Tours/'.$tour->Banner_Image) }}"  alt="" class="avatar-sm me-2">
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="AddNew-title">Title</label>
                                                                        <input type="text" class="form-control" name="title" value="{{$tour->Title}}" placeholder="Enter Title" id="AddNew-title">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Status</label>
                                                                        <select class="form-select" name="status">
                                                                            <option value="1" @if($tour->status == 1) selected @endif>Active</option>
                                                                            <option value="0" @if($tour->status == 0) selected @endif>Disabled</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="AddNew-data">Price</label>
                                                                        <input type="number" class="form-control" name="price" value="{{$tour->Price}}" placeholder="Price" id="AddNew-price">
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


                



                
             
                <!-- end row -->

                <div class="row g-0 align-items-center pb-4">
                    <div class="col-sm-6">
                        <div>
                            <p class="mb-sm-0">Showing 1 to 10 of 57 entries</p>
                        </div>
                    </div>
                    
                </div>
                <!-- end row -->
                
            </div>


            <!--  Extra Large modal example -->
            <div class="modal fade add-new" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myExtraLargeModalLabel">Add New</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('/admin/tours-save') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="AddNew-banner_image">Banner Image</label>
                                            <input type="file" class="form-control" name="banner_image" placeholder="Select Img File" id="AddNew-banner_image">
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
                                            <label class="form-label">Status</label>
                                            <select class="form-select" name="status">
                                                <option value="1">Active</option>
                                                <option value="0">Disabled</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="AddNew-data">Price</label>
                                            <input type="number" class="form-control" name="price" placeholder="Price" id="AddNew-price">
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
