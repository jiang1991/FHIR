@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">{{ $patient->name }}</div>

        <div class="panel-body">
          <table class="table table-striped">
            <h3>Information</h3>
            <div class="row">
              <div class="col-md-2">Gender: {{ $patient->gender }}</div>
              <div class="col-md-3">Birth Date: {{ $patient->birthDate }}</div>
              <div class="col-md-4">Medical ID: {{ $patient->medicalId }}</div>
              <div class="col-md-2">Height: {{ $patient->height }}</div>
              <div class="col-md-2">Weight: {{ $patient->weight }}</div>
              <div class="col-md-2">Step Size: {{ $patient->stepSize }}</div>
            </div>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
