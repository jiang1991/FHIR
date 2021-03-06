@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <ul class="breadcrumb">
        <li class="active">Home</li>
      </ul>

      <div class="panel panel-default">
        <div class="panel-heading">Patients</div>

        @if (count($patients) > 0)
        <div class="panel-body">
          <table class="table table-striped">
            @foreach ($patients as $patient)
              <tr>
                <td>
                  <table>
                    <tr>
                      @if ($patient->name == "Guest")
                      <h3><a href="/mypatient/{{ $patient->id }}">  <u>{{ $patient->name }}</u>  </a></h3>
                      <div class="row">
                        <div class="col-md-4">SN: {{ substr($patient->identifier_value, 0, -1) }}</div>
                      </div>
                      @else
                      <h3><a href="/mypatient/{{ $patient->id }}">  <u>{{ $patient->name }}</u>  </a></h3>
                      <div class="row">
                        <div class="col-md-4 text-danger"><strong>Medical ID: {{ $patient->medicalId }}</strong></div>
                        <!-- <div class="col-md-4 text-danger"><strong>SN: {{ $patient->identifier_value }}</strong> </div> -->

                        @if ($patient->gender == "--")
                        @else
                        <div class="col-md-2">Gender: {{ $patient->gender }}</div>
                        @endif

                        @if ($patient->birthDate == "0000-00-00")
                        @else
                        <div class="col-md-3">Birth date: {{ date('M d, Y', strtotime($patient->birthDate)) }}</div>
                        @endif

                      </div>
                      @endif
                    </tr>
                  </table>
                </td>
              </tr>
            @endforeach
          </table>
        </div>
        @endif
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">Patients share with me</div>

        @if (count($sharePatients) > 0)
        <div class="panel-body">
          <table class="table table-striped">
            @foreach ($sharePatients as $sharePatient)
              <tr>
                <td>
                  <table>
                    <tr>
                      @if ($sharePatient->name == "Guest")
                      <h3><a href="/mypatient/{{ $sharePatient->id }}">{{ $sharePatient->name }}  </a></h3>
                      <div class="row">
                        <div class="col-md-4">SN: {{ substr($sharePatient->identifier_value, 0, -1) }}</div>
                      </div>
                      @else
                      <h3><a href="/mypatient/{{ $sharePatient->id }}">{{ $sharePatient->name }}  </a></h3>
                      <div class="row">
                        @if ($sharePatient->gender = "--")
                        @else
                        <div class="col-md-2">Gender: {{ $sharePatient->gender }}</div>
                        @endif

                        @if ($sharePatient->birthDate == "0000-00-00")
                        @else
                        <div class="col-md-3">Birth date: {{ date('M d, Y', strtotime($sharePatient->birthDate)) }}</div>
                        @endif

                        <div class="col-md-4">SN: {{ substr($sharePatient->identifier_value, 0, -1) }}</div>
                      </div>
                      @endif
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
