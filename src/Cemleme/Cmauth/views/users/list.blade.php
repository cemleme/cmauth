<a href="/cmauth/users/create" class="btn btn-success pull-right">
	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Create New User
</a>

<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th></th>
			<th>LDAP</th>
			<th>Ad</th>
			<th>Email</th>
			<th>Last Activity</th>
			<th>Pwd Changed</th>
		</tr>
	</thead>
	<tbody>
		@foreach($users as $user)
			<tr>
				<td  class="form-inline">
					<a href="/cmauth/users/{{$user->id}}/yenisifremail" class="btn btn-primary laravel-submit" data-method="put" data-confirm="{{$user->name}} şifresini sıfırlamak istediğinizden emin misiniz?">Şifre Sıfırla</a>
					<a href="/cmauth/users/{{$user->id}}/edit" class="btn btn-warning inline">edit</a>
					<a href="/cmauth/users/{{$user->id}}" class="btn btn-danger laravel-submit" data-method="delete" data-confirm="{{$user->name}} kullanıcısını silmek istediğinizden emin misiniz?">
						<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
					</a>

					@if(!$user->welcomesent)
					<a href="/cmauth/users/{{$user->id}}/welcomemail" class="btn btn-info laravel-submit" data-method="put" data-confirm="{{$user->name}} şifresini sıfırlamak istediğinizden emin misiniz?">Welcome</a>
					@endif
				</td>
				<td>{{ $user->ldap }}</td>
				<td>{{ $user->name }}</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->last_activity_diff_tr }}</td>
				<td>{{ $user->pwdchanged }}</td>
			</tr>
		@endforeach
	</tbody>
</table>

