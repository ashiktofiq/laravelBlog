@extends('fontlayout')
@section('title','All Categories')
@section('content')
		<div class="row">
			<div class="col-md-8">
				<div class="row mb-5"> 
					@if(count($categories)>0)
						@foreach($categories as $category)
						<div class="col-md-4">
							<div class="card">
							  <a href="{{url('category/'.Str::slug($category->title).'/'.$category->id)}}"><img src="{{asset('images/'.$category->image)}}" class="card-img-top" alt="{{$category->title}}" /></a>
							  <div class="card-body">
							    <h5 class="card-title"><a href="{{url('category/'.Str::slug($category->title).'/'.$category->id)}}">{{$category->title}}</a></h5>
							  </div>
							</div>
						</div>
						@endforeach
					@else
					<p class="alert alert-danger">No Category Found</p>
					@endif
				</div>
				<!-- Pagination -->
				{{$categories->links()}}
			</div>
			<!-- Right SIdebar -->
			<div class="col-md-4">
				<!-- Search -->
				<div class="card mb-4">
					<h5 class="card-header">Search</h5>
					<div class="card-body">
						<form action="{{url('/')}}">
							<div class="input-group">
							  <input type="text" name="search" class="form-control" />
							  
							</div>
						</form>
					</div>
				</div>
				<!-- Recent Posts -->
				<div class="card mb-4">
					<h5 class="card-header">Recent Posts</h5>
					<div class="list-group list-group-flush">
						@if($recent_posts)
							@foreach($recent_posts as $post)
								<a href="{{url('detail/'.Str::slug($post->title).'/'.$post->id)}}" class="list-group-item">{{$post->title}}</a>
							@endforeach
						@endif
					</div>
				</div>
			</div>
		</div>
@endsection('content')