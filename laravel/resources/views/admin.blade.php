@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <ul class="breadcrumb">
        <li><a href="/">Home</a> <span class="divider"></span></li>
        <li class="active">Admin</li>
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
                  <div class="row">
                    <div class="col-md-4">{{ $patient->name }}</div>
                    <div class="col-md-4">{{ $patient->medicalId }}</div>
                    <div><form action="/viatomadmin/{{ $patient->id }}" method="POST">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}

                  <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                  </form></div>
                  </div>
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
