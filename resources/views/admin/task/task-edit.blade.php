@extends('admin.layout.app')
@section('PageTitle')
    Edit-Task
@endsection
@section('PageHeader')
    <i class="fa fa-info-circle"></i> Edit-Task
@endsection
@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Edit Task</h3>

        </div>
        <!-- /.card-header -->
        <!-- form start -->
        @include('admin.layout.messages')
        <form class="form-horizontal" action="{{ route('task/update',$task->id) }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group row">                        
                    <div class="col-md-4">
                        <label for="name">Task Title</label>
                        <input type="text" name='name' class="form-control @error('name') is-invalid @enderror"
                            value="{{ $task->name}}">
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
                            value="{{ $task->start_date }}" min="<?= date('Y-m-d') ?>">
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
                            value="{{ $task->end_date }}" min="<?= date('Y-m-d') ?>">
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-4">
                        <label for="name">Choose Project:</label>
                        <select
                            class="form-control @error('category_id')
                        is-invalid
                    @enderror"
                            name="project_id" id="project_id">
                            <option value='0' disabled selected>Choose Project</option>
                            @foreach ($projects as $project)
                            <option value="{{ $project->id }}" {{ $task->project_id == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}</option>
                            @endforeach
                        </select>
                        @error('project_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4">
                        <label for="name">Assign To:</label>
                            <select class="form-control @error('employee_id') is-invalid @enderror" name="employee_id" id="employee_id">
                                <option value="0" disabled selected>Choose Employee</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ $task->employee_id == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->name }}
                                    </option>
                                @endforeach
                            </select>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4">
                        <label for="name">Task Status</label>
                        <select
                            class="form-control @error('status')
                        is-invalid
                    @enderror"
                            name="status" id="status">
                            <option value='0' disabled selected>Choose Status</option>
                            @foreach ($statusOptions as $value => $label)
                                <option value="{{ $value }}" @if ($task->status == $value) selected @endif>
                                    {{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4">
                        <label for="name">Task Priority</label>
                        <select
                            class="form-control @error('priority')
                        is-invalid
                    @enderror"
                            name="priority" id="priority">
                            <option value='0' disabled selected>Task Priority</option>
                            @foreach ($priorityOptions as $value => $label)
                                <option value="{{ $value }}" @if ($task->priority == $value) selected @endif>
                                    {{ $label }}</option>
                            @endforeach
                        </select>
                        @error('priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="name">Task Description</label>
                        <textarea class="form-control @error('description')
                        is-invalid
                    @enderror"
                            name="description" class="summernote" id="summernote">{{ $task->description }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-success col-12">Update</button>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>
@endsection
