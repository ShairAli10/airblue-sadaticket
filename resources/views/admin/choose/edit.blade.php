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
                <a href="{{ url('why-choose-us') }}" class="btn btn-danger float-end">Back</a>
            </h4>
            </div>
            <div class="card-body">
                <form action="{{ url('why-choose-us/edit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="">Icon</label>
                    <input type="file" name="icon" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label for="">Title</label>
                    <input type="text" name="title" class="form-control">

                </div>
                <div class="form-group mb-3">
                    <label for="">Description</label>
                    <input type="number" name="description">
                </div>
                
                </form>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection