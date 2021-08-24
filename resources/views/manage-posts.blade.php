@extends('fontlayout')
@section('title','Manage Posts')
@section('content')
		<div class="row">
			<div class="col-md-8 mb-5">
				<h3 class="mb-3">Manage Posts</h3>
				<div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
			  <th>#</th>
              <th>Category</th>
              <th>Title</th>
              <th>Detail</th>
              <th>Full Image</th>
              <th>Thumb Image</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
			  <th>#</th>
              <th>Category</th>
              <th>Title</th>
              <th>Detail</th>
              <th>Full Image</th>
              <th>Thumb Image</th>
              <th>Action</th>
            </tr>
          </tfoot>
          <tbody>
              @foreach($data as $post)
              <tr>
                <td>{{$post->id}}</td>
                <td>{{$post->category->title}}</td>
                <td>{{$post->title}}</td>
				<td>{{$post->detail}}</td>
                <td><img src="{{ asset('images/thumbimage').'/'.$post->thumb }}" width="100" /></td>
                <td><img src="{{ asset('images/fullimage').'/'.$post->full_img }}" width="100" /></td>
				<td>
                  <a class="btn btn-info btn-sm" href="{{url('manage-post-edit/'.$post->id)}}">Edit</a>
                  <a onclick="return confirm('Are you sure you want to delete?')" class="btn btn-danger btn-sm" href="{{url('manage-posts/delete/'.$post->id)}}">Delete</a>
                </td>
              </tr>
              @endforeach
          </tbody>
        </table>
        </div>
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
<!-- Page level plugin CSS-->
<link href="{{asset('backend')}}/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
<script src="{{asset('backend')}}/vendor/datatables/jquery.dataTables.js"></script>
<script src="{{asset('backend')}}/vendor/datatables/dataTables.bootstrap4.js"></script>
<script src="{{asset('backend')}}/js/demo/datatables-demo.js"></script>
@endsection('content')