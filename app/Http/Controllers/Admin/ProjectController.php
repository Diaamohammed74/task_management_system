<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{

    public function index()
    {
        $this->authorize('index',Project::class);
        // $this->authorize('viewAny',Project::class);
        if (auth()->user()->type=='Supervisor') {
            $projects=Project::with(['category','manager'])->where('manager_id','=',auth()->user()->id)->paginate(10);
            return view('admin.project.projects-index',compact('projects'));
        }
        $projects=Project::with(['category','manager'])->paginate(10);
        return view('admin.project.projects-index',compact('projects'));
    }

    public function getStatusOptions()
    {
        $enumOptions = DB::select(DB::raw("SHOW COLUMNS FROM projects WHERE Field = 'status'"))[0]->Type;
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
        $this->authorize('create',Project::class);
        $statusOptions = $this->getStatusOptions();
        $categories=Category::get();
        $employees=User::where('type','Supervisor')->get();
        return view('admin.project.project-create',compact('categories','employees','statusOptions'));
    }


    public function store(Request $request)
    {
        // dd($request);
        $validated=$request->validate([
            'name'=>'required| max:50|min:5|unique:projects,name',
            'start_date'=>'required|date|after_or_equal:today',
            'end_date'=>'required|date|after:start_date',
            'category_id'=>'required',
            'manager_id'=>'required',
            'status'=>'required',
            'description'=>'required|min:10|max:50'
        ]);
        Project::create($validated);
        return back()->with('success','Project Added Successfuly');
    }


    public function show(Project $project)
    {
        //
    }

    public function edit($id)
    {
        $this->authorize('edit',Project::class);
        $project=Project::findOrFail($id);
        if ($project->manager_id != auth()->user()->id && !in_array(auth()->user()->type, ['admin', 'super_admin']) ) {
            return redirect(route('projects'))->with('permission','Sorry You Don`t have permission');
        }
        $categories=Category::get();
        $manager=User::where('type','=','Supervisor')->get();
        $statusOptions = $this->getStatusOptions();
        return view('admin.project.project-edit',
        compact('project','categories','manager','statusOptions'));
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update',Project::class);
        if (auth()->user()->type == 'Supervisor') {
            $request->validate([
                'name'=>'required| max:50|min:5',
                'start_date'=>'required|date|after_or_equal:today',
                'end_date'=>'required|date|after:start_date',
                'status'=>'required',
                'description'=>'required|min:10|max:50'
            ]);
        } elseif(auth()->user()->type == 'admin')
        {
            $request->validate([
                'name'=>'required| max:50|min:5',
                'start_date'=>'required|date|after_or_equal:today',
                'end_date'=>'required|date|after:start_date',
                'status'=>'required',
                'description'=>'required|min:10|max:50',
                'category_id'=>'required'
                ]);
        }
            else {
            $request->validate([
                'name'=>'required| max:50|min:5',
                'start_date'=>'required|date|after_or_equal:today',
                'end_date'=>'required|date|after:start_date',
                'status'=>'required',
                'description'=>'required|min:10|max:50',
                'category_id'=>'required',
                'manager_id'=>'required'
            ]);
        }
        
        Project::findOrFail($id)->update($request->all());
        return redirect(route('projects'))->with('success','Project Updated Successfuly');
    }

    public function destroy($id)
    {
        $this->authorize('destroy',Project::class);
        $project=Project::findOrFail($id);
        $project->delete();
        return back()->with('deleted','Project Deleted Successfuly');
    }
    public function trashed()
    {
        $this->authorize('archive',Project::class);
        if (auth()->user()->type == 'Supervisor')
        {
            $projects=Project::onlyTrashed()->where('manager_id','=',auth()->user()->id)->paginate(10);
            return view('admin.project.projects-archive',compact('projects'));
        }
        $projects=Project::onlyTrashed()->paginate(10);
        return view('admin.project.projects-archive',compact('projects'));
    }
    public function restore($id)
    {
        $this->authorize('restore',Project::class);
        Project::withTrashed()->where('id','=',$id)->restore();
        return back()->with('success','Project Restored Successfuly');
    }
}
