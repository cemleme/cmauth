@extends('cmauth::partials.cmauth_wrapper')

@section('sub_template')

<style>
	.container {
		padding-top:20px;
	}
	
	.dashboard .btn:not(.btn-block) { 
		width:200px;
		margin-bottom:10px; 
	}
</style>

<div class="container">

	<div class="panel panel-primary">
		<div class="panel-heading">
			<a href="/cmauth" class="btn btn-success">
				<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
				<h3 class="panel-title">CMAUTH</h3>
			</a>
		</div>
		<div class="panel-body">

			@if(Session::has('message'))
			  <p class="alert alert-info">{{ Session::get('message') }}</p>
			@endif

			@if($errors->all())
				<div class="alert alert-danger">
					<ul>
						@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

		  	{!! $content !!}

		</div>
	</div>

</div>

@stop