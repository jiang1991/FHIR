@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<ul class="breadcrumb">
				<li class="active">Home</li>
			</ul>


			<div class="panel panel-default">
				<div class="panel-heading">Devices</div>

				<div class="panel-body">
					<table class="table table-striped">
						@if (count($devices) > 0)
						@foreach ($devices as $device)
						<tr>
							<td>
								<table>
									<tr>
										<h3 class="text-uppercase"><a href="/oxiupload/devices/{{$device->id}}">{{ $device->device_name }}</a>  <small>{{$device->device_sn}}</small></h3>

										<div class="row">
											<div class="col-md-4"><strong>Branch Code: {{ $device->branch_code }}</strong></div>
											<div class="col-md-4"><strong>Version: </strong>{{ $device->btl_version }} / {{$device->app_version}}</div>
										</div>
										<div class="row">
											<div class="col-md-4 text-danger">update at: {{$device->updated_at}}</div>
										</div>
									</tr>
								</table>
							</td>
						</tr>
						@endforeach
						@endif
					</table>
				</div>

			</div>
		</div>
	</div>

</div>
@endsection