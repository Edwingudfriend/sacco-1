@extends('layouts.master')
@section('content')
<a href="/addexpensesType"  class="btn btn-primary">create</a>
<table class="table table-condensed table-striped table-bordered table-hover">
   <tr>
      <th>#</th>
      <th>Expense type Name</th>
     <th>created at</th>
      <th>Updated at</th>
      <th>deleted</th>
      <th>deleted On</th>
      <th>deleted by</th>
      <th colspan="4">Actions</th>
   </tr>
   @foreach($expensesTypes as $expensetype)
   <tr>
      <td>{{ $expensetype->id }}</td>
      <td>{{ $expensetype->expense_type_name }} </td>
     <td>
         @if($expensetype->created_at)
         {{ $expensetype->created_at->toFormattedDateString() }}
         @else
         ___
         @endif
      </td>
      <td>
         @if($expensetype->created_at)
         {{ $expensetype->updated_at->toFormattedDateString() }}
         @else
         ___
         @endif
      </td>
      <td>
         @if( $expensetype->deleted==1 )
         <font size="3" color="red">deleted</font>
         @else()
         ___
         @endif
      </td>
      <td>{{ $expensetype->deleted_on }}</td>
      <td>
         @foreach($users as $item)
         @if($item->id==$expensetype->deleted_by)
         {{$item->user_first_name}}
         @elseif($expensetype->deleted_by== null)
         _
         @endif
         @endforeach
      </td>
      @if($expensetype->deleted_on ==0 || Auth::user()->id)
      <td>
       <td><a href ="/expenseType/edit/{{$expensetype->id}}" class="btn btn-sm btn-primary">edit</a></td>
      <td>
         <form action="/expensetypedelete/{{$expensetype->id}}" method="post" onsubmit()="are you sure you want to delete">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <button class="btn btn-sm btn-danger"  type="submit">delete</button>
         </form>
      </td>
      @elseif($expensetype->deleted_on ==1)
      <td><button type="disabled">deleted</button></td>
      <td><button type="disabled">deleted</button></td>
      @endif
   </tr>
   @endforeach
</table>
@endsection
