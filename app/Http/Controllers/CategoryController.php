<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categories = Category::latest()->paginate(5);
        $onlyTrashed = Category::onlyTrashed()->latest()->paginate(10);
        return view('admin.category.index', compact('categories', 'onlyTrashed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreCategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        // Validate and store the category
        $validated = $request->validate([
            'title' => 'required|unique:categories|max:255'
        ]);

        /* Category::insert([
             'title' => $request->title,
             'user_id' => Auth::user()->id
         ]);*/

        $category = new Category();
        $category->title = $request->title;
        $category->user_id = Auth::user()->id;
        $category->save();

        return Redirect()->back()->with('success', 'Category with name ' . $request->title . ' added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateCategoryRequest $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:categories|max:255'
        ]);
        $category = Category::find($id);
        $category->title = $request->title;
        $category->update();
        return Redirect()->route('category')->with('success', 'Category with name ' . $request->title . ' added successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::find($id)->delete();
        return Redirect()->route('category')->with('success', 'Your category moved to Trash');
    }


    public function restore($id)
    {
        Category::withTrashed()->find($id)->restore();
        return Redirect()->route('category')->with('success', 'Your category has been moved from the Trash');
    }

    public function forceDestroy($id){

        Category::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->route('category')->with('success', 'Your category has been deleted successfully');
    }
}
