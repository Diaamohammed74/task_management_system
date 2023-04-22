@extends('admin.layout.app')

@section('PageHeader')
    Archived-Tasks
@endsection

@section('PageTitle')
Archived-Tasks
@endsection

@section('content')
@include('admin.layout.messages')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"></h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right " placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Task</th>
                            <th>Description</th>
                            <th>Project Name</th>
                            <th>Project Manager</th>
                            <th>Assigned To</th>

                            <th>Priority</th>
                            <th>Status</th>

                            <th>Duration</th>
                            <th>Created At</th>
                            <th>Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tasks as $task)
                            <tr>
                                <td>{{ $tasks->firstItem() + $loop->index }}</td>

                                <td>{{ $task->name }}</td>

                                <td>{!! $task->description !!}</td>

                                <td>
                                    @if ($task->project_id != null)
                                        {{ $task->project->name }} 
                                @else
                                    None
                                @endif
                                </td>

                                



                                    <td >

                                    @if ($task->project_id !=null)
                                            {{ $task->project->manager->name }} 
                                    @else
                                        None
                                    @endif
                                </td>
                                <td>
                                    @if ($task->employee_id!=null)
                                    {{$task->employee->name}}
                                    @else
                                        None
                                    @endif
                                </td>

                                <td>{{$task->priority}}</td>

                                <td>
                                    <span class=" @if ($task->status=='completed' || $task->status=='success')
                                        badge badge-success
                                        @elseif($task->status=='new')
                                        badge badge-info
                                        @elseif($task->status=='rejected')
                                        badge badge-danger
                                        @elseif($task->status=='inprogress')
                                        badge badge-warning
                                    @endif ">{{$task->status}}</span>
                                    </td> 
                                <td>
                                    {{$task->start_date}}<br>
                                    {{$task->end_date}}
                                
                                </td> {{--duration--}}





                                <td>{{$task->created_at->diffForHumans()}}</td> {{--created at--}}
                                <td>
                                    <div class="btn-group manage-button" title="Group Management">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{route('task/restore',$task->id)}}">
                                                <i class="fas fa-edit"></i> Restore
                                            </a>



                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11">
                                    <div class="alert alert-warning text-center" role="alert">
                                        <div>
                                            <b style="color: black"> There is no Projects added yet </b>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {!! $tasks->links() !!}
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
