<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::latest()->paginate(5);
        return view('admin.brand.index', compact('brands'));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|unique:brands|max:199',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $brand = new Brand();
        if ($request->file('image')) {
            $file = $request->file('image');
            $file_ext = strtolower($file->getClientOriginalExtension());
            $filename = date('YmdHi') . '-' . hexdec(uniqid()) . '.' . $file_ext;
            $file->storeAs('image/brand', $filename, 'public');
            $brand['image'] = $filename;
        }
        $brand['title'] = $request->title;
        $brand->save();
        return Redirect()->back()->with('success', 'Brand with name ' . $request->title . ' added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {

        $request->validate([
            'title' => 'required|unique:brands|max:199',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            self::delete_file($request->old_image);
            $file = $request->file('image');
            $file_ext = strtolower($file->getClientOriginalExtension());
            $filename = date('YmdHi') . '-' . hexdec(uniqid()) . '.' . $file_ext;
            $file->storeAs('image/brand', $filename, 'public');
            $brand['image'] = $filename;
        }
        $brand->update([
            'title' => $request->title,
        ]);
        return redirect()->route('brand.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);

        if ($brand->image) {
            self::delete_file($brand->image);
        }
        Brand::find($id)->delete();
        return Redirect()->route('brand.index')->with('success', 'Your brand has been deleted successfully');
    }

    public static function delete_file($path)
    {
        if (Storage::disk('public')->exists('image/brand/' . $path))
            Storage::disk('public')->delete('image/brand/' . $path);
    }
}
