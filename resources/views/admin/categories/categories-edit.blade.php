@extends('admin.layout.app')

@section('PageHeader')
    Edit-Category
@endsection

@section('PageTitle')
    Edit-Category
@endsection

@section('content')
    <div class="p-1">
        <a href="{{ route('categories') }}" class="btn btn-outline-primary col-2" role="button" aria-pressed="true">Back to
            Categories</a>
    </div>
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Edit Category</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        @include('admin.layout.messages')
        
        <form class="form-horizontal" action="{{ route('categories/update',$category->id) }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-12">Category Name</label>
                    <div class="col-10">
                        <input type="text" name='name'
                            class="form-control @error('name')
                    is-invalid
                @enderror"
                            value="{{ $category->name }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Update</button>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>
@endsection
