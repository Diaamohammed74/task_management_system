@extends('admin.layout.app')

@section('PageHeader')
    Archived-Projects
@endsection

@section('PageTitle')
Archived-Projects
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
                            <th>Name</th>
                            <th>Category</th>
                            <th>Manager</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($projects as $project)
                            <tr>
                                <td>{{ $projects->firstItem() + $loop->index }}</td>
                                <td>{{ $project->name }}</td>

                                <td>
                                    {{optional($project->category)->name??'UnKnown'}}
                                </td>

                                <td >
                                    {{optional($project->manager)->name ??'UnKnown'}}
                                </td>
                                <td>
                                    {{$project->start_date}}<br>
                                    {{$project->end_date}}
                                
                                </td> {{--duration--}}

                                <td>
                                <span class=" @if ($project->status=='completed')
                                    badge badge-success
                                    @else
                                    badge badge-warning
                                @endif ">{{$project->status}}</span>

                                </td> {{--status--}}
                                <td>{{$project->created_at->diffForHumans()}}</td> {{--created at--}}
                                <td>
                                    <div class="btn-group manage-button" title="Group Management">
                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{route('project/restore',$project->id)}}">
                                                <i class="fas fa-edit"></i> Restore
                                            </a>
                                            <a class="dropdown-item" href="{{route('project/edit',$project->id)}}">
                                                <i class="fas fa-edit"></i> Update
                                            </a>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="alert alert-warning text-center" role="alert">
                                        <div>
                                            <b style="color: black"> There is no projects archived yet </b>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {!! $projects->links() !!}
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
