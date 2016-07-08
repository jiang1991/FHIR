@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
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
                      <h3><a href="/mypatient/{{ $patient->id }}">{{ $patient->name }}</a></h3>
                      <div class="row">
                        <div class="col-md-2">Gender: {{ $patient->gender }}</div>
                        <div class="col-md-3">Birth Date: {{ $patient->birthDate }}</div>
                        <div class="col-md-4">Medical ID: {{ $patient->medicalId }}</div>
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
