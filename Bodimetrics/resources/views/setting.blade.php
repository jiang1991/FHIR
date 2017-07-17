@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <ul class="breadcrumb">
        <li><a href="/">Home</a> <span class="divider"></span></li>
        <li class="active">Setting</li>
      </ul>

      <div class="panel panel-default">
        <div class="panel-heading">Setting</div>

        <div class="panel-body">
          <table class="table">
            <div>
              <h3>Delete account</h3>
              <p>Once you delete your account, there is no going back. Please be certain.</p>
            </div>
            <div>
              <form action="/account" method="POST">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <button type="submit" class="btn btn-danger btn-sm">Delete your account</button>
              </form>
            </div>
          </table>
        </div>

    </div>
  </div>
</div>

@endsection