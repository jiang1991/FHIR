@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <ul class="breadcrumb">
        <li><a href="/">Home</a> <span class="divider"></span></li>
        <li class="active">{{ $patient->name }}</li>
      </ul>

      <div class="panel panel-default">
        <div class="panel-heading">Information</div>

        <div class="panel-body">
          <table class="table table-striped">
            @if ($patient->name == "Guest")
            <h3>{{ $patient->name }}</h3>
            <div class="row">
              <div class="col-md-4">SN: {{ substr($patient->identifier_value, 0, -1) }}</div>
            </div>
            @else
            <h3>{{ $patient->name }}</h3>
            <div class="row">
              <div class="col-md-2">Gender: {{ $patient->gender }}</div>
              <div class="col-md-3">Birth date: {{ date('M d, Y', strtotime($patient->birthDate)) }}</div>
              <div class="col-md-4">SN: {{ substr($patient->identifier_value, 0, -1) }}</div>
              <div class="col-md-2">Height: {{ $patient->height }}</div>
              <div class="col-md-2">Weight: {{ $patient->weight }}</div>
              <div class="col-md-2">Step size: {{ $patient->stepSize }}</div>
            </div>
            @endif
          </table>
        </div>

        <div class="panel-heading">Measurements</div>
        @if (count($observations) > 0)
        <div class="panel-body">
          <table class="table table-striped">
          @foreach ($observations as $observation)
            <tr>
              <td>
                <table>
                  <tr>
                    <div class="row">
                      <div class="col-md-3 text-capitalize"><a href="/myobservation/{{ $observation->id }}">Check type: {{ $observation->resourceId }}</a></div>
                      <div class="col-md-3"> {{ date('H:i:s M d, Y', strtotime($observation->effectiveDateTime)) }}</div>
                      <div class="col-md-6">{{ $observation->device_display }}: {{ $observation->device_sn }}</div>
                    </div>
                  </tr>
                </table>
              </td>
            </tr>
          @endforeach
          </table>
        </div>
        @endif

      </div>
    </div>
  </div>
</div>
@endsection
