<form method="POST" action="/cmauth/users" accept-charset="UTF-8" class="form-horizontal form-bordered">
	<input name="_token" type="hidden" value="{{{ csrf_token() }}}">
    <h2 class="form-signup-heading">Create New User</h2>
 
	<div class="row">
		<div class="col-md-4">
			<input class="form-control" placeholder="Name" name="name" type="text">
			<input class="form-control" placeholder="Email Address" name="email" type="text">
            <br/>
            <input class="btn btn-large btn-primary btn-block" type="submit" value="Create">
		</div>
	</div>
</form>

