<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Category;

use App\Helpers\Utils;
            
class CategoryController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'verified', 'isAdmin']);//isAdmin middleware lets only users with a //specific permission permission to access these resources
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderby('name')->paginate(\App\Models\Setting::get_PAGING_NUM());//Get all categories

        return view('categories.index')->with('categories', $categories);
    }
    
    public function manage()
    {
        $categories = Category::orderby('id', 'desc')->paginate(\App\Models\Setting::get_PAGING_NUM()); //show only 5 items at a time in descending order
        $tabs = new \App\Tabs\Books\Setup();
        $tabs->set_active_tab("categories");
        return view('categories.manage', compact('tabs', 'categories'));
    }

    
    public function create()
    {
        return view('categories.create');
    }

    public function show($id)
    {
        $category = Category::findOrFail($id); //Find Category of id = $id

        return view ('categories.show', compact('category'));

    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|max:100',
            ]);

        try
        {
            $name = $request['name'];
            $category = Category::create($request->only('name'));
            
            return redirect()->route('categories.manage')->with('flash_message', 'category,'. $category->title.' created');
        }
        catch (\PDOException $e)
        {
            return \App\Helpers\DBError::report($e);
        }
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name'=>'required|max:200',
        ]);

        try
        {
            $category = Category::findOrFail($id);
            $category->name = $request['name'];
            
            $category->save();

            return redirect()->route('categories.manage', 
                $category->id)->with('flash_message', 'Category, '. $category->title.' updated');
        }
        
        catch (\PDOException $e)
        {
            return \App\Helpers\DBError::report($e);
        }
    }
    
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.manage')
            ->with('flash_message', 'Category deleted!');
        //
    }
}
