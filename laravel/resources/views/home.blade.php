@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">Hello {{ Auth::user()->name }}</div>

        @if (count($patients) > 0)
        <div class="panel-body">
          <table class="table table-striped"

            <!-- Table Headings -->
            <thead>
              <th>Patient</th>
              <th>&nbsp;</th>
            </thead>

            <!-- Patient Name -->
            <tbody>
            @foreach ($patients as $patient)
              <tr>
                <td class="table-text">
                  <div>{{ $patient->name }}</div>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
