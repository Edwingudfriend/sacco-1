@extends('layouts.master')
@section('content')
<a href="/adduser"  class="btn btn-primary">create</a>
<table class="table table-condensed table-striped table-bordered table-hover">
   <tr>
      <th>#</th>
      <th>First Name</th>
      <th>Last name</th>
      <th>Email</th>
      <th>User Status</th>
      <th>Role</th>
      <th>created at</th>
      <th>Updated at</th>
      <th>deleted</th>
      <th>deleted On</th>
      <th>deleted by</th>
      <th colspan="4">Actions</th>
   </tr>
   @foreach($users as $user)
   <tr>
      <td>{{ $user->id }}</td>
      <td>{{ $user->user_first_name }} </td>
      <td>{{ $user->user_last_name }} </td>
      <td>{{ $user->email }}</td>
      <td> @if( $user->user_status==1)
         <font size="3" color="green">Active</font>
         @else()
         <font size="3" color="red">InActive</font>
         @endif
      </td>
     
        <td>
            @foreach($user->roles as $role)
                <table>
                    @if($role->pivot->role_id == $role->id)
                        <td>
                            {{$role->role_name}}
                        </td>
                    @endif
                </table>
            @endforeach           
        </td>
      
         @if($user->created_at == NULL)
         <td>-</td>
         @else
        <td>{{ $user->created_at }}</td>
         @endif

         @if($user->updated_at == NULL)
         <td>- </td>
         @else
         <td>{{ $user->updated_at->toFormattedDateString() }}</td>
         @endif
     
      <td>
         @if( $user->deleted==1 )
         <font size="3" color="red">deleted</font>
         @else()
         Not deleted
         @endif
      </td>
      <td>{{ $user->deleted_on }}</td>
      <td>
         @foreach($users as $item)
         @if($item->id==$user->deleted_by)
         {{$item->user_first_name}}
         @endif
         @endforeach
      </td>
      <td><!-- Button trigger modal -->
        
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#assignRoleModal">
            Asign role
        </button></td>
      
        

        <!-- Modal -->
        <div class="modal fade" id="assignRoleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Choose a Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/userrole/{{$user->id}}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label for="userrole">Choose a Role</label>
                      <select name="role_id" id="">
                          <option value="">Select a Role</option>
                          @foreach($roles as $role)
                             <option value={{$role->id}}>{{$role->role_name}}</option>
                          @endforeach
                      </select>
                     
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Assign role</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
        </div>
      <td><a href ="/users/edit/{{$user->id}}" class="btn btn-sm btn-primary">edit</a></td>
      <td><a href="/userrole/{{$user->id}}"  class="btn btn-sm btn-success">View and Manage User Role</a></td>
      <td>
         @if(Auth::user()->id != $user->id)
         <form action="/usersdelete/{{$user->id}}" method="post" onsubmit()="are you sure you want to delete">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <button class="btn btn-sm btn-danger"  type="submit">delete</button>
         </form>
         @endif
      </td>
   </tr>
   @endforeach
</table>
@endsection
