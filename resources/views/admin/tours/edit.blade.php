@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
    <div class="col-md-12">
        @if (session('status'))
        <h6>{{ session('status') }}</h6>
        @endif
        <div class="card">
            <div class="card-header">
                <h4>Edit Student With Image
                <a href="{{ url('students') }}" class="btn btn-danger float-end">Back</a>
            </h4>
            </div>
            <div class="card-body">
                <form action="{{ url('tours-edit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="">Banner Image</label>
                    <input type="file" name="banner_image" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label for="">Title</label>
                    <input type="text" name="title" class="form-control">

                </div>
                <div class="form-group mb-3">
                    <label for="">Price</label>
                    <input type="number" name="price">
                </div>
                
                </form>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection