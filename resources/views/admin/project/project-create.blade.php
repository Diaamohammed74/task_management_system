@extends('admin.layout.app')
@section('PageTitle')
    Create-Project
@endsection
@section('PageHeader')
    <i class="fa fa-plus-circle"></i> Create-Project
@endsection
@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Create Project</h3>

        </div>
        <!-- /.card-header -->
        <!-- form start -->
        @include('admin.layout.messages')
        <form class="form-horizontal" action="{{ route('project/store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="name">Project Title</label>
                        <input type="text" name='name' class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="col-4">
                        <label for="name">Start Date</label>
                        <input type="date" name="start_date" id="start_date"
                            class="form-control @error('start_date')
                        is-invalid
                    @enderror"
                            value="{{ old('start_date') }}" min="<?= date('Y-m-d') ?>">

                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-4">
                        <label for="name">End Date</label>
                        <input type="date" name="end_date" id="end_date"
                            class="form-control @error('end_date')
                        is-invalid
                    @enderror"
                            value="{{ old('end_date') }}" min="<?= date('Y-m-d') ?>">

                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                </div>



                <div class="form-group row">
                    <div class="col-4">
                        <label for="name">Choose a category:</label>
                        <select
                            class="form-control @error('category_id')
                        is-invalid
                    @enderror"
                            name="category_id" id="category_id">
                            <option value='0' disabled selected>Choose Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if (old('category_id') == $category->id) selected @endif>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4">
                        <label for="name">Project Manager:</label>
                        <select
                            class="form-control @error('manager_id')
                        is-invalid
                    @enderror"
                            name="manager_id" id="manager_id">
                            <option value='0' disabled selected>Project Manager</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" @if (old('manager_id') == $employee->id) selected @endif>
                                    {{ $employee->name }}</option>
                            @endforeach
                        </select>
                        @error('manager_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-4">
                        <label for="name">Project Status</label>
                        <select
                            class="form-control @error('status')
                        is-invalid
                    @enderror"
                            name="status" id="status">
                            <option value='0' disabled selected>Project Status</option>
                            @foreach ($statusOptions as $value => $label)
                                <option value="{{ $value }}" @if (old('status') == $value) selected @endif>
                                    {{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="name">Project Description</label>
                        <textarea class="form-control @error('description')
                        is-invalid
                    @enderror"
                            name="description" class="summernote" id="summernote">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-success col-12">Create</button>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>
@endsection
