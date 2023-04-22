<?php

namespace App\Http\Controllers\admin;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    
    {
        if (auth()->user()->type == 'employee') {
            $tasks=Task::with(['project','employee'])
            ->where('employee_id','=',auth()->user()->id)
            ->paginate(10);
        }
        elseif(auth()->user()->type == 'Supervisor'){
            $tasks = Task::with(['project', 'employee'])
            ->join('projects', 'projects.id', '=', 'tasks.project_id')
            ->where('projects.manager_id', '=', auth()->user()->id)
            ->paginate(10);
        }
        else{
            $tasks=Task::with(['project','employee'])->paginate(10);
        }
        return view('admin.task.task-index',compact('tasks'));
    }

    public function getStatusOptions()
    {
        $enumOptions = DB::select(DB::raw("SHOW COLUMNS FROM tasks WHERE Field = 'status'"))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $enumOptions, $matches);
        $enumValues = array();
        foreach(explode(',', $matches[1]) as $value){
            $v = trim($value, "'");
            $enumValues[$v] = ucfirst($v);
        }
        return $enumValues;
    }
    public function getPriorityOptions()
    {
        $enumOptions = DB::select(DB::raw("SHOW COLUMNS FROM tasks WHERE Field = 'priority'"))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $enumOptions, $matches);
        $enumValues = array();
        foreach(explode(',', $matches[1]) as $value){
            $v = trim($value, "'");
            $enumValues[$v] = ucfirst($v);
        }
        return $enumValues;
    }

    public function create()
    {
        $this->authorize('create',Task::class);
        if (auth()->user()->type=='Supervisor') {
        $projects = Project::with('manager:id,name')
        ->where('projects.manager_id', '=', auth()->user()->id)
        ->select('id', 'name')
        ->get();
        $statusOptions = $this->getStatusOptions();
        $priorityOptions = $this->getPriorityOptions();
        $employees=User::where('type','=','employee')->get();
        }
        else{
            $projects = Project::with('manager:id,name')
            ->select('id', 'name')
            ->get();
            $statusOptions = $this->getStatusOptions();
            $priorityOptions = $this->getPriorityOptions();
            $employees=User::where('type','=','employee')
            ->get();
        }
        return view('admin.task.task-create',
        compact('projects','employees','statusOptions','priorityOptions'));
    }
    public function store(Request $request)
    {
        $validated=$request->validate([
            'name'=>'required| max:20|min:5', 
            'start_date'=>'required|date|after_or_equal:today', 
            'end_date'=>'required|date|after_or_equal:start_date',   
            'project_id'=>'required',
            'employee_id'=>'required',
            'status'=>'required',
            'priority'=>'required',
            'description'=>'required|min:10|max:50'
        ]);
        Task::create($validated);
        return back()->with('success','Task Added Successfuly');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $this->authorize('edit',Task::class);

        if (auth()->user()->type=='employee') {
            $statusOptions = $this->getStatusOptions();
            return view('admin.task.task-edit',compact('statusOptions'));
        }
        elseif (auth()->user()->type=='Supervisor'){
            $projects = Project::with('manager:id,name')
            ->where('projects.manager_id', '=', auth()->user()->id)
            ->select('id', 'name')
            ->get();
            $task=Task::with(['project:id,name,manager_id','employee:id,name'])->findOrFail($id);
            $employees = User::where('type','=','employee')->get(['name','id']);
            $priorityOptions = $this->getPriorityOptions();
            $statusOptions = $this->getStatusOptions();
            return view('admin.task.task-edit',compact('task','projects','employees','priorityOptions','statusOptions'));
        }else{
            $task=Task::with(['project:id,name,manager_id','employee:id,name'])->findOrFail($id);
            $projects=Project::with('manager:id,name')->get();
            $employees = User::where('type','=','employee')->get(['name','id']);
            $priorityOptions = $this->getPriorityOptions();
            $statusOptions = $this->getStatusOptions();
            return view('admin.task.task-edit',
            compact('task','projects','employees','priorityOptions','statusOptions'));
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required| max:20|min:5',  
            'start_date'=>'required|date|after_or_equal:today',  
            'end_date'=>'required|date|after_or_equal:start_date',   
            'project_id'=>'required',
            'employee_id'=>'required',
            'status'=>'required',
            'priority'=>'required',
            'description'=>'required|min:10|max:50'
        ]);
        Task::findOrFail($id)->update($request->except('_token'));
        return redirect(route('tasks'))->with('success','Task Updated Successfuly');
    }

    public function destroy($id)
    {
        $task=Task::FindOrFail($id);
        $task->delete();
        return back()->with('deleted','Task Deleted Successfuly');
    }
    public function trashed()
    {
        $tasks=Task::onlyTrashed()->paginate(10);
        return view('admin.task.task-archive',compact('tasks'));
    }
    public function restore($id)
    {
        $task=Task::withTrashed()->where('id','=',$id)->restore();
        return back()->with('success','Task Restored Successfuly');
        
    }
}