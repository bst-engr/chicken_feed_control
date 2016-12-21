@extends(config('sentinel.layout'))

{{-- Web site Title --}}
@section('title')
@parent
Users
@stop

@section('page_title')
  Current Users
  
    <a class='btn btn-primary pull-right' href="{{ route('sentinel.users.create') }}">Create User</a>
  
@stop

@sub_page_title

@stop

{{-- Content --}}
@section('content')
<!-- <div class="row">
    <div class='page-header'>
        <div class='btn-toolbar pull-right'>
            <div class='btn-group'>
                <a class='btn btn-primary' href="{{ route('sentinel.users.create') }}">Create User</a>
            </div>
        </div>
        <h1>Current Users</h1>
    </div>
</div> -->

<div class="row">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover" id="users_list">
            <thead>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Options</th>
            </thead>
            <tbody>
            @foreach ($users as $user)

                <tr>
                    <td>{{$user->first_name.' '. $user->last_name}}</td>
                    <td><a href="{{ action('\\Sentinel\Controllers\UserController@show', array($user->hash)) }}">{{ $user->email }}</a></td>
                    <td>{{ $user->status }} </td>
                    <td>
                        <button class="btn btn-default" type="button" onClick="location.href='{{ action('\\Sentinel\Controllers\UserController@edit', array($user->hash)) }}'">Edit</button>
                        @if(Sentry::getUser()->email != $user->email  )
                            @if ($user->status != 'Suspended')
                                <button class="btn btn-default" type="button" onClick="location.href='{{ action('\\Sentinel\Controllers\UserController@suspend', array($user->hash)) }}'">Suspend</button>
                            @else
                                <button class="btn btn-default" type="button" onClick="location.href='{{ action('\\Sentinel\Controllers\UserController@unsuspend', array($user->hash)) }}'">Un-Suspend</button>
                            @endif
                            @if ($user->status != 'Banned')
                                <button class="btn btn-default" type="button" onClick="location.href='{{ action('\\Sentinel\Controllers\UserController@ban', array($user->hash)) }}'">In Active</button>
                            @else
                                <button class="btn btn-default" type="button" onClick="location.href='{{ action('\\Sentinel\Controllers\UserController@unban', array($user->hash)) }}'">Active</button>
                            @endif
                            <!-- <button class="btn btn-default action_confirm" href="{{ action('\\Sentinel\Controllers\UserController@destroy', array($user->hash)) }}" data-token="{{ Session::getToken() }}" data-method="delete">Delete</button> -->
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<script src="{{ asset('packages/rydurham/sentinel/js/restfulizer.js') }}"></script> 
<script type="text/javascript">
$(function(){
$('#users_list').DataTable({
                responsive: true
        });
});
</script>
@stop
