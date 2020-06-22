@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<ul class="breadcrumb">
        <li><a href="/">Home</a> <span class="divider"></span></li>
        <li class="active">TEST</li>
        <li class="active">Upload</li>
      </ul>

      <div class="panel panel-default">

      	<div class="panel-heading">
      		Upload file list
      	</div>

      	<div class="panel-body">
      		@if (count($upload_files) > 0)
      		<table class="table table-striped">
      			@foreach ($upload_files as $file)
    				<tr>
    				  <td>
    				    <table>
    				      <tr>
    				        <div class="row">
    				          <div class="col-md-4">{{ $file->id }}: {{ $file->file_name }}</div>
    				          <div class="col-md-2">{{ $file->file_size }} bytes</div>
    				          <div class="col-md-4"> {{ date('H:i:s M d, Y', strtotime($file->created_at)) }}</div>
    				          <a href="/test/upload/d/{{ $file->id }}" target="_blank" class="btn btn-primary btn-xs" role="button"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Download</a>
    				          
    				        </div>
    				      </tr>
    				    </table>
    				  </td>
    				</tr>
      			@endforeach
      		</table>
      		@endif

      	</div>
      </div>
    </div>
  </div>
</div>

@endsection