@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<ul class="breadcrumb">
				<li class="active">Home</li>
			</ul>


			<div class="panel panel-default">
				<div class="panel-heading">Device</div>

				<div class="panel-body">
					<table>
						<tr>
							<h3 class="text-uppercase">{{ $device->device_name }} <small>{{$device->device_sn}}</small></h3>

							<div class="row">
								<div class="col-md-4"><strong>Branch Code: {{ $device->branch_code }}</strong></div>
								<div class="col-md-4"><strong>Version: </strong>{{ $device->btl_version }} / {{$device->app_version}}</div>
							</div>
							<div class="row">
								<div class="col-md-4 text-danger">update at: {{$device->updated_at}}</div>
							</div>
						</tr>
					</table>
				</div>

			</div>


			<div class="panel panel-default">
				<div class="panel-heading">Resources</div>

				<div class="panel-body">
					<table class="table table-striped">
						@if (count($resources) > 0)
						@foreach ($resources as $resource)
						<tr>
							<td>
								<table>
									<tr>
										<h3 class="text-uppercase">{{ $device->device_name }}  <small>{{$resource->resource_type}}</small></h3>

										<div class="row">
											<div class="col-md-4 text-danger"><strong>Record Time: {{ $resource->record_date }}</strong></div>
											<div class="col-md-4"><strong>Record Duration: </strong>{{ $resource->record_duration }}</div>
										</div>
										<div class="row">
											<div class="col-md-4">sync at: {{$resource->updated_at}}</div>
										</div>
									</tr>
								</table>
							</td>
						</tr>
						@endforeach
						@endif
					</table>

					{!! $resources->links() !!}
				</div>

			</div>
		</div>
	</div>

</div>
@endsection