<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Category::all();
        return view('backend.category.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.category.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|min:2|max:20',
            'detail'=>'required|min:5|max:40',
            
        ]);
        $newimage = '';
        if($request->hasFile('image')){
            $image=$request->file('image');
            $newimage=time().'.'.$image->getClientOriginalExtension();
            $destination_path=public_path('/images');
            $image->move($destination_path,$newimage);
        }
        $category=new Category;
        $category->title=$request->title;
        $category->detail=$request->detail;
        $category->image=$newimage;
        $category->save();
        return redirect('admin/category/create')->with('success','Category Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=Category::find($id);
        return view('backend.category.update',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'=>'required',
            'detail'=>'required'
           
        ]);
        
        if($request->hasFile('image')){
            $image=$request->file('image');
            $newimage=time().'.'.$image->getClientOriginalExtension();
            $destination_path=public_path('/images');
            $image->move($destination_path,$newimage);
        }
        else{
           $newimage=$request->image;
        }
        $category= Category::find($id);
        $category->title=$request->title;
        $category->detail=$request->detail;
        $category->image=$newimage;
        $category->save();
        return redirect('admin/category/'.$id.'/edit')->with('success','Category Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::where('id',$id)->delete();
        return redirect('admin/category');
    }
}
