@extends('layouts.master')

@section('title') List of Notifications | @endsection

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default margin-top-20"> 
			<div class="panel-heading">
				<h3 class="panel-title">List of Notifications</h3>
			</div>
			
			<div class="panel-body">
				<ul class="list-unstyled">
				@forelse($notifications as $notification)
					<li>
						<h3{{ $notification->status=='unread' ? ' class=bold':'' }}><a href="{{url('todo/'.$notification->resource_id.'?notification_id='.$notification->id)}}">{{ $notification->title }}</a></h3>
						<p><strong>Description: </strong>{{ $notification->short_description ?  $notification->short_description : 'N/A' }}</p>
					</li>
				@empty
					<li><h4 class="text-danger">No Notification Found!</h4></li>
				@endforelse
				</ul>
			</div><!-- /.panel-body -->
			
		</div>
	</div>
</div>

@endsection

