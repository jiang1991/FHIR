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
            <h3> <div class="text-capitalize"> {{ $observation->resourceId }}</div>
              <div>
              <form action="/myobservation/{{ $observation->id }}" method="POST">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <input type="hidden" name="patient_id" value="{{ $patient->id }}">
              <button type="submit" class="btn btn-danger pull-right btn-sm">Delete</button>
              </form>
            </div></h3>
            <div class="row">
              <div class="col-md-3">Patient: {{ $observation->subject_display }}</div>
              <div class="col-md-3"> {{ date('H:i:s M d, Y', strtotime($observation->effectiveDateTime)) }}</div>
              <div class="col-md-6 text-capitalize">{{ $observation->interpretation_text }}</div>
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
                      <image class="col-xs-12" src="/plot/{{ $observation_component->id }}"> </image>
                    </div>
                  </tr>
                </table>
              </td>
            </tr>
            @elseif ($observation_component->code_code == "RPP")

            @elseif ($observation_component->code_display == "Avg HR")

            @else
            <tr>
              <td>
                <table>
                  <tr>
                    <div>
                      <div class="col-md-4">
                      @if ($observation_component->code_display == "Heart rate")
                      HR
                      @elseif($observation_component->code_display == "QRS duration")
                      QRS
                      @elseif($observation_component->code_display == "ST Segment.lead I")
                      ST
                      @elseif($observation_component->code_display == "Q-T interval")
                      QT
                      @elseif($observation_component->code_display == "Q-T interval corrected")
                      QTc
                      @elseif($observation_component->code_display == "Premature ventricular contractions [#]")
                      PVCs
                      @elseif($observation_component->code_display == "Oxygen saturation in Blood")
                      SpO2
                      @elseif($observation_component->code_display == "Perfusion index Tissue by Pulse oximetry")
                      PI
                      @elseif($observation_component->code_display == "Heart rate by Pulse oximetry")
                      PR
                      @else
                      {{ $observation_component->code_display }}
                      @endif

                      : <strong>{{ $observation_component->valueQuantity_value }} {{ $observation_component->valueQuantity_unit }}</strong>
                    </div>
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
