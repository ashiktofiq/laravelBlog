<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;

class HomeController extends Controller
{
    function index(Request $request){
        if($request->has('search')){
    		$search=$request->search;
    		$posts=Post::where('title','like','%'.$search.'%')->orderBy('id','desc')->paginate(4);
    	}else{
    		$posts=Post::orderBy('id','desc')->paginate(4);
    	}
        return view('home',['posts'=>$posts]);
    }
    // post detail
    function detail(Request $request,$slug,$postId){
        $detail=Post::find($postId);
        return view('detail',['detail'=>$detail]);
    }
    // all categories
    function all_category(){
        $categories=Category::orderBy('id','desc')->paginate(2);
        return view('categories',['categories'=>$categories]);
    }
    // all posts according to the category
    function category(Request $request,$cat_slug,$cat_id){
         $category=Category::find($cat_id);
         $posts=Post::where('cat_id',$cat_id)->orderBy('id','desc')->paginate(2);
         return view('category',['posts'=>$posts,'category'=>$category]);
    }
    // user submit post
    function save_post_form(){
        $categories=Category::all();
        return view('save-post-form',['categories'=>$categories]);
    }
    // save post data
    function save_post_data(Request $request){
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
        $post->user_id=$request->user()->id;
        $post->cat_id=$request->category;
        $post->title=$request->title;
        $post->detail=$request->detail;
        $post->tags=$request->tags;
        $post->full_img=$postFullImage;
        $post->thumb=$postThumbImage;
        $post->status=1;
        $post->save();
        return redirect('save-post-form')->with('success','Post Added Successfully.');
    }
    // save comment
    function save_comment(Request $request,$slug,$id){
        $request->validate([
            'comment'=>'required'
        ]);
        $data=new Comment;
        $data->user_id=$request->user()->id;
        $data->post_id=$id;
        $data->comment=$request->comment;
        $data->save();
        return redirect('detail/'.$slug.'/'.$id)->with('success','Comment has been submitted.');
    }
    // manage posts
    function manage_posts(Request $request){
        $posts=Post::where('user_id',$request->user()->id)->orderBy('id','desc')->get();
        return view('manage-posts',['data'=>$posts]);
    }
    // manage posts edit
    function manage_post_edit($id)
    {
         $data=Post::find($id);
         $categories=Category::all();
         return view('manage-post-edit',['data'=>$data,'categories'=>$categories]);
        
    }
    // manage post update
    function manage_post_update(Request $request,$id){
        $request->validate([
            'title'=>'required|min:2|max:30',
            'category'=>'required',
            'detail'=>'required|min:5|max:100',
            
        ]);
        
         if($request->hasFile('post_image')){
             $image1=$request->file('post_image');
             $postFullImage=time().'.'.$image1->getClientOriginalExtension();
            $destination_path1=public_path('/images/fullimage');
            $image1->move($destination_path1,$postFullImage);
         }else{
            $postFullImage=$request->post_image;
         }
        
        if($request->hasFile('post_thumb')){
            $image2=$request->file('post_thumb');
            $postThumbImage=time().'.'.$image2->getClientOriginalExtension();
            $destination_path2=public_path('/images/thumbimage');
            $image2->move($destination_path2,$postThumbImage);
        }else{
            $postThumbImage=$request->post_thumb;
         }
        $post=Post::find($id);
        $post->user_id=$request->user()->id;
        $post->cat_id=$request->category;
        $post->title=$request->title;
        $post->detail=$request->detail;
        $post->tags=$request->tags;
        $post->full_img=$postFullImage;
        $post->thumb=$postThumbImage;
        $post->status=1;
        $post->save();
        return redirect('manage-post-edit/'.$id)->with('success','Post Updated Successfully.');
    }
    // delete manage post
    function delete_manage_post($id)
    {
        Post::where('id',$id)->delete();
        return redirect('manage-posts');
    }
   
}
