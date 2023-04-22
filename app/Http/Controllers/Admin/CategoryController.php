<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::with('project')->paginate(10); 
        return view('admin.categories.categories-index',compact('categories'));
    }
    public function show($id)
    {
        //
    }

    public function create()
    {
        $this->authorize('create',Category::class);
        return view('admin.categories.categories-create');
    }


    public function store(Request $request)
    {
        $this->authorize('store',Category::class);

        $request->validate([
            'name'=>'required|min:3|max:20'
        ]);
        Category::create([
            'name'=>$request->name
        ]);
        return back()->with('success','Category Created Successfuly');
    }

    public function edit($id)
    {
        $this->authorize('edit',Category::class);
        $category=Category::findOrFail($id);
        return view('admin.categories.categories-edit',compact('category'));
    }


    public function update(Request $request, $id)
    {
        $this->authorize('update',Category::class);
        $request->validate([
            'name'=>'required|min:3|max:20'
        ]);
        Category::findOrFail($id)->update([
            'name'=>$request->name,
        ]);
        return redirect(route('categories'))->with('success','Category Updated Successfuly');
    }

    public function destroy($id)
    {
        $this->authorize('destroy',Category::class);

        $category=Category::findOrFail($id);
        $category->delete();
        return back()->with('deleted','Category Deleted Successfuly');
    }
}
