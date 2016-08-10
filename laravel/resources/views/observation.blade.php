@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">

      <ul class="breadcrumb">
        <li><a href="/">Home</a> <span class="divider"></span></li>
        <li><a href="/mypatient/{{ $patient->id }}">{{ $patient->name }}</a> <span class="divider"></span></li>
        <li class="active">{{ $observation->resourceId }}</li>
      </ul>

      <div class="panel panel-default">
        <div class="panel-heading">Observation</div>

        <div class="panel-body">
          <table class="table table-striped">
            <h3>{{ $observation->resourceId }}</h3>
            <h4>{{ $observation->code_display }}</h4>
            <div class="row">
              <div class="col-md-3">Patient: {{ $observation->subject_display }}</div>
              <div class="col-md-2"><strong>{{ $observation->interpretation_display }}</strong></div>
              <div class="col-md-6">{{ $observation->interpretation_text }}</div>
            </div>
          </table>
        </div>

        <div class="panel-heading">Details</div>
        @if (count($observation_components) > 0)
        <div class="panel-body">
          <table class="table table-striped">
            @foreach ($observation_components as $observation_component)
              @if ($observation_component->valueString)
              <!-- TODO: ECG waveform -->
              <tr>
                <td>
                  <table>
                    <tr>
                      <div>
                        <image src="/plot/{{ $observation_component->id }}" class="img-responsive col-xs-12">
                      </div>
                    </tr>
                  </table>
                <td>
              </tr>
              @else
              <tr>
                <td>
                  <table>
                    <tr>
                      <div class="row">
                        <div class="col-md-6">{{ $observation_component->code_display }} : <strong>{{ $observation_component->valueQuantity_value }} {{ $observation_component->valueQuantity_unit }}</strong></div>
                      </div>
                    </tr>
                  </table>
                </td>
              </tr>
              @endif
            @endforeach
          </table>
        </div>
        @endif

      </div>
    </div>
  </div>
</div>

@endsection
