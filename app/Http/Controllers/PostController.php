<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Post::all();
        return view('backend.post.index',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        return view('backend.post.add',['categories'=>$categories]);
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
            'title'=>'required|min:2|max:30',
            'category'=>'required',
            'detail'=>'required|min:5|max:100',
            
        ]);
        $postFullImage = '';
         if($request->hasFile('post_image')){
             $image1=$request->file('post_image');
             $postFullImage=time().'.'.$image1->getClientOriginalExtension();
            $destination_path1=public_path('/images/fullimage');
            $image1->move($destination_path1,$postFullImage);
         }
        $postThumbImage = '';
        if($request->hasFile('post_thumb')){
            $image2=$request->file('post_thumb');
            $postThumbImage=time().'.'.$image2->getClientOriginalExtension();
            $destination_path2=public_path('/images/thumbimage');
            $image2->move($destination_path2,$postThumbImage);
        }
        $post=new Post;
        $post->user_id=0;
        $post->cat_id=$request->category;
        $post->title=$request->title;
        $post->detail=$request->detail;
        $post->tags=$request->tags;
        $post->full_img=$postFullImage;
        $post->thumb=$postThumbImage;
        $post->save();
        return redirect('admin/post/create')->with('success','Post Added Successfully.');
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
        $data=Post::find($id);
        $categories=Category::all();
        return view('backend.post.update',['data'=>$data,'categories'=>$categories]);
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
            'title'=>'required|min:2|max:30',
            'category'=>'required',
            'detail'=>'required|min:5|max:100',
            
        ]);
        //$postFullImage = '';
         if($request->hasFile('post_image')){
             $image1=$request->file('post_image');
             $postFullImage=time().'.'.$image1->getClientOriginalExtension();
            $destination_path1=public_path('/images/fullimage');
            $image1->move($destination_path1,$postFullImage);
         }else{
            $postFullImage=$request->post_image;
         }
        //$postThumbImage = '';
        if($request->hasFile('post_thumb')){
            $image2=$request->file('post_thumb');
            $postThumbImage=time().'.'.$image2->getClientOriginalExtension();
            $destination_path2=public_path('/images/thumbimage');
            $image2->move($destination_path2,$postThumbImage);
        }else{
            $postThumbImage=$request->post_thumb;
         }
        $post=Post::find($id);
        $post->cat_id=$request->category;
        $post->title=$request->title;
        $post->detail=$request->detail;
        $post->tags=$request->tags;
        $post->full_img=$postFullImage;
        $post->thumb=$postThumbImage;
        $post->save();
        return redirect('admin/post/'.$id.'/edit')->with('success','Post Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::where('id',$id)->delete();
        return redirect('admin/post');
    }
}
