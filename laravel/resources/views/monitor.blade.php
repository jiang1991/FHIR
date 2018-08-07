@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<ul class="breadcrumb">
			  <li><a href="/">Home</a> <span class="divider"></span></li>
			  <li class="active">Monitor Data</li>
			</ul>

			<div class="panel panel-default">
				<div class="panel-heading">Monitor Data</div>
			</div>

			<div class="panel-body">
				<table class="table table-striped">
					@if (count($monitors) > 0)
					@foreach ($monitors as $monitor)
					<tr>
						<div class="row">
							<div class="col-md-3 text-capitalize">
								User: {{ $monitor->user_id }}
							</div>
							<div class="col-md-3">
								{{ $monitor->date_m }} {{ $monitor->time_m }}
							</div>
							<div class="col-md-6">
								Seq NO.: {{ $monitor->seq_no }} Duration: {{ $monitor->begin }} - {{ $monitor->end }}
								</div>
							<div class="col-md-6">
								Location: {{ $monitor->location }}
								</div>
							</div>
						</div>
					</tr>
					@endforeach
					@endif
				</table>
			</div>
		</div>
	</div>
</div>

@endsection