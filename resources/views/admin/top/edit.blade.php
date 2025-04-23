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
                <h4>
                <a href="{{ url('destination') }}" class="btn btn-danger float-end">Back</a>
            </h4>
            </div>
            <div class="card-body">
                <form action="{{ url('destination-edit') }}" method="POST" enctype="multipart/form-data">
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
                    <label for="">From</label>
                    <input type="text" name="from" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">To</label>
                    <input type="text" name="to" class="form-control">
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection