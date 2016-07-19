@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">ECG</div>

        <div class="panel-body">
          <table class="table">
            <canvas id="myChart" width="100" height="100"></canvas>
            
          </table>
        </div>
      </div>
    <div>
  </div>
</div>


@endsection
