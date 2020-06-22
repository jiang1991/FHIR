@extends('layouts.app')

@section('content')



<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<ul class="breadcrumb">
        <li><a href="/">Home</a> <span class="divider"></span></li>
        <li class="active">Console</li>
        <li class="active">Update</li>
      </ul>

      <!-- query version -->
      <div class="panel panel-default">
      	<div class="panel-heading">
      		Query the latest version
      	</div>

      	<div class="panel-body">
      		<table>
      			<tr>
      				<td>
      					<form class="form-inline">
      						<div class="form-group">
      							<select id="query_device" class="form-control">
      								<option>SleepO2</option>
      								<option>SnoreO2</option>
      								<option>CheckO2</option>
      								<option>O2Ring</option>
      								<option>WearO2</option>
      								<option>SleepU</option>
      								<option>O2Vibe</option>
      								<option>AirBP</option>
									<option>ER1</option>
									<option>ER2</option>
      							</select>
      						</div>
      						<div class="form-group">
      							<input type="number" class="form-control" id="query_sn" placeholder="please input SN">
      						</div>
      						<button id="sn_query" type="button" class="btn btn-primary">
      							Query
      						</button>
      					</form>      					
      				</td>
      			</tr>

      			<tr>
      				<td>
      					<p></p>
      					<p id="q_error" class="text-danger">error: </p>

      					<p id="q_result" class="text-primary">btlVersion: , appVersion: </p>
      				</td>
      			</tr>
      		</table>

      	</div>
      </div>

      <!-- all versions -->
      <div class="panel panel-default">

      	<div class="panel-heading">
      		Live Versions
      	</div>
      

	      


	      <div class="panel-body">
	      	<!-- Nav tabs -->
	      	  <ul class="nav nav-tabs" role="tablist">
	      	    <li role="presentation" class="active"><a href="#ceo2Vs" aria-controls="ceo2Vs" role="tab" data-toggle="tab">CEO2</a></li>
	      	    <li role="presentation"><a href="#snoreo2Vs" aria-controls="snoreo2Vs" role="tab" data-toggle="tab">SnoreO2</a></li>
	      	    <li role="presentation"><a href="#o2ringVs" aria-controls="o2ringVs" role="tab" data-toggle="tab">O2Ring</a></li>
	      	    <li role="presentation"><a href="#sleepo2Vs" aria-controls="sleepo2Vs" role="tab" data-toggle="tab">SleepO2</a></li>
	      	    <li role="presentation"><a href="#wearo2Vs" aria-controls="wearo2Vs" role="tab" data-toggle="tab">WearO2</a></li>
	      	    <li role="presentation"><a href="#sleepuVs" aria-controls="sleepuVs" role="tab" data-toggle="tab">SleepU</a></li>
	      	    <li role="presentation"><a href="#o2vibeVs" aria-controls="o2vibeVs" role="tab" data-toggle="tab">O2Vibe</a></li>
	      	    <li role="presentation"><a href="#airbpVs" aria-controls="airbpVs" role="tab" data-toggle="tab">AirBP</a></li>
				<li role="presentation"><a href="#er1Vs" aria-controls="er1Vs" role="tab" data-toggle="tab">ER1</a></li>
				<li role="presentation"><a href="#er2Vs" aria-controls="er2Vs" role="tab" data-toggle="tab">ER2</a></li>
	      	  </ul>

	      	  <!-- Tab panes -->
	      	  <div class="tab-content">

	      	  	<!-- CE O2 -->
	      	    <div role="tabpanel" class="tab-pane active" id="ceo2Vs">
	      	    	<table class="table table-striped">
	      	    		<!-- header -->
	      	    		<tr>
	      	    			<td>
	      	    				<table>
	      	    					<tr>
	      	    						<div class="row">
	      	    							<div class="col-md-2">Model</div>
	      	    							<div class="col-md-3">SN range</div>
	      	    							<div class="col-md-2">btlVersion</div>
	      	    							<div class="col-md-2">appVersion</div>
	      	    						</div>
	      	    					</tr>
	      	    				</table>
	      	    			</td>
	      	    		</tr>
	      	    		@foreach ($ceo2Vs as $version)
	      	    		<tr>
	      	    			<td>
	      	    				<table>
	      	    					<tr>
	      	    						<div class="row">
	      	    							<div class="col-md-2">{{ $version->deviceName }}</div>
	      	    							<div class="col-md-3">
	      	    								@if ($version->snMin == $version->snMax)
	      	    									{{ $version->snMax }}
	      	    								@elseif ($version->snMin == 0 && $version->snMax == 9999999999)
	      	    									No Limit
	      	    								@else
	      	    									{{ $version->snMin }} - {{ $version->snMax}}
	      	    								@endif
	      	    							</div>
	      	    							<div class="col-md-2">{{ $version->btlVersion }}</div>
	      	    							<div class="col-md-2">{{ $version->appVersion }}</div>
	      	    						</div>
	      	    					</tr>
	      	    				</table>
	      	    			</td>
	      	    		</tr>
	      	    		@endforeach
	      	    	</table>
	      	    	
	      	    </div>

	      	    <!-- SnoreO2 -->
	      	    <div role="tabpanel" class="tab-pane" id="snoreo2Vs">

	      	    	<table class="table table-striped">
	      	    		<!-- header -->
	      	    		<tr>
	      	    			<td>
	      	    				<table>
	      	    					<tr>
	      	    						<div class="row">
	      	    							<div class="col-md-2">Model</div>
	      	    							<div class="col-md-3">SN range</div>
	      	    							<div class="col-md-2">btlVersion</div>
	      	    							<div class="col-md-2">appVersion</div>
	      	    						</div>
	      	    					</tr>
	      	    				</table>
	      	    			</td>
	      	    		</tr>
	      	    		@foreach ($snoreo2Vs as $version)
	      	    		<tr>
	      	    			<td>
	      	    				<table>
	      	    					<tr>
	      	    						<div class="row">
	      	    							<div class="col-md-2">{{ $version->deviceName }}</div>
	      	    							<div class="col-md-3">
	      	    								@if ($version->snMin == $version->snMax)
	      	    									{{$version->snMax}}
	      	    								@elseif ($version->snMin == 0 && $version->snMax == 9999999999)
	      	    									No Limit
	      	    								@else
	      	    									{{ $version->snMin }} - {{ $version->snMax}}
	      	    								@endif
	      	    							</div>
	      	    							<div class="col-md-2">{{ $version->btlVersion }}</div>
	      	    							<div class="col-md-2">{{ $version->appVersion }}</div>
	      	    						</div>
	      	    					</tr>
	      	    				</table>
	      	    			</td>
	      	    		</tr>
	      	    		@endforeach
	      	    	</table>
	      	    	
	      	    </div>

	      	    <!-- O2 Ring -->
	      	    <div role="tabpanel" class="tab-pane" id="o2ringVs">
	      	    	<table class="table table-striped">
	      	    		<!-- header -->
	      	    		<tr>
	      	    			<td>
	      	    				<table>
	      	    					<tr>
	      	    						<div class="row">
	      	    							<div class="col-md-2">Model</div>
	      	    							<div class="col-md-3">SN range</div>
	      	    							<div class="col-md-2">btlVersion</div>
	      	    							<div class="col-md-2">appVersion</div>
	      	    						</div>
	      	    					</tr>
	      	    				</table>
	      	    			</td>
	      	    		</tr>
	      	    		@foreach ($o2ringVs as $version)
	      	    		<tr>
	      	    			<td>
	      	    				<table>
	      	    					<tr>
	      	    						<div class="row">
	      	    							<div class="col-md-2">{{ $version->deviceName }}</div>
	      	    							<div class="col-md-3">
	      	    								@if ($version->snMin == $version->snMax)
	      	    									{{$version->snMax}}
	      	    								@elseif ($version->snMin == 0 && $version->snMax == 9999999999)
	      	    									No Limit
	      	    								@else
	      	    									{{ $version->snMin }} - {{ $version->snMax}}
	      	    								@endif
	      	    							</div>
	      	    							<div class="col-md-2">{{ $version->btlVersion }}</div>
	      	    							<div class="col-md-2">{{ $version->appVersion }}</div>
	      	    						</div>
	      	    					</tr>
	      	    				</table>
	      	    			</td>
	      	    		</tr>
	      	    		@endforeach
	      	    	</table>
	      	    	
	      	    </div>

	      	    <!-- Sleep O2 -->
	      	    <div role="tabpanel" class="tab-pane" id="sleepo2Vs">
	      	    	<table class="table table-striped">
	      	    		<!-- header -->
	      	    		<tr>
	      	    			<td>
	      	    				<table>
	      	    					<tr>
	      	    						<div class="row">
	      	    							<div class="col-md-2">Model</div>
	      	    							<div class="col-md-3">SN range</div>
	      	    							<div class="col-md-2">btlVersion</div>
	      	    							<div class="col-md-2">appVersion</div>
	      	    						</div>
	      	    					</tr>
	      	    				</table>
	      	    			</td>
	      	    		</tr>
	      	    		@foreach ($sleepo2Vs as $version)
	      	    		<tr>
	      	    			<td>
	      	    				<table>
	      	    					<tr>
	      	    						<div class="row">
	      	    							<div class="col-md-2">{{ $version->deviceName }}</div>
	      	    							<div class="col-md-3">
	      	    								@if ($version->snMin == $version->snMax)
	      	    									{{$version->snMax}}
	      	    								@elseif ($version->snMin == 0 && $version->snMax == 9999999999)
	      	    									No Limit
	      	    								@else
	      	    									{{ $version->snMin }} - {{ $version->snMax}}
	      	    								@endif
	      	    							</div>
	      	    							<div class="col-md-2">{{ $version->btlVersion }}</div>
	      	    							<div class="col-md-2">{{ $version->appVersion }}</div>
	      	    						</div>
	      	    					</tr>
	      	    				</table>
	      	    			</td>
	      	    		</tr>
	      	    		@endforeach
	      	    	</table>
	      	    	
	      	    </div>

	      	    <!-- Wear O2 -->
	      	    <div role="tabpanel" class="tab-pane" id="wearo2Vs">
	      	    	<table class="table table-striped">
	      	    		<!-- header -->
	      	    		<tr>
	      	    			<td>
	      	    				<table>
	      	    					<tr>
	      	    						<div class="row">
	      	    							<div class="col-md-2">Model</div>
	      	    							<div class="col-md-3">SN range</div>
	      	    							<div class="col-md-2">btlVersion</div>
	      	    							<div class="col-md-2">appVersion</div>
	      	    						</div>
	      	    					</tr>
	      	    				</table>
	      	    			</td>
	      	    		</tr>
	      	    		@foreach ($wearo2Vs as $version)
	      	    		<tr>
	      	    			<td>
	      	    				<table>
	      	    					<tr>
	      	    						<div class="row">
	      	    							<div class="col-md-2">{{ $version->deviceName }}</div>
	      	    							<div class="col-md-3">
	      	    								@if ($version->snMin == $version->snMax)
	      	    									{{$version->snMax}}
	      	    								@elseif ($version->snMin == 0 && $version->snMax == 9999999999)
	      	    									No Limit
	      	    								@else
	      	    									{{ $version->snMin }} - {{ $version->snMax}}
	      	    								@endif
	      	    							</div>
	      	    							<div class="col-md-2">{{ $version->btlVersion }}</div>
	      	    							<div class="col-md-2">{{ $version->appVersion }}</div>
	      	    						</div>
	      	    					</tr>
	      	    				</table>
	      	    			</td>
	      	    		</tr>
	      	    		@endforeach
	      	    	</table>
	      	    	
	      	    </div>

	      	    <!-- SleepU -->
	      	    <div role="tabpanel" class="tab-pane" id="sleepuVs">
	      	    	<table class="table table-striped">
	      	    		<!-- header -->
	      	    		<tr>
	      	    			<td>
	      	    				<table>
	      	    					<tr>
	      	    						<div class="row">
	      	    							<div class="col-md-2">Model</div>
	      	    							<div class="col-md-3">SN range</div>
	      	    							<div class="col-md-2">btlVersion</div>
	      	    							<div class="col-md-2">appVersion</div>
	      	    						</div>
	      	    					</tr>
	      	    				</table>
	      	    			</td>
	      	    		</tr>
	      	    		@foreach ($sleepuVs as $version)
	      	    		<tr>
	      	    			<td>
	      	    				<table>
	      	    					<tr>
	      	    						<div class="row">
	      	    							<div class="col-md-2">{{ $version->deviceName }}</div>
	      	    							<div class="col-md-3">
	      	    								@if ($version->snMin == $version->snMax)
	      	    									{{$version->snMax}}
	      	    								@elseif ($version->snMin == 0 && $version->snMax == 9999999999)
	      	    									No Limit
	      	    								@else
	      	    									{{ $version->snMin }} - {{ $version->snMax}}
	      	    								@endif
	      	    							</div>
	      	    							<div class="col-md-2">{{ $version->btlVersion }}</div>
	      	    							<div class="col-md-2">{{ $version->appVersion }}</div>
	      	    						</div>
	      	    					</tr>
	      	    				</table>
	      	    			</td>
	      	    		</tr>
	      	    		@endforeach
	      	    	</table>
	      	    	
	      	    </div>

	      	    <!-- O2Vibe -->
	      	    <div role="tabpanel" class="tab-pane" id="o2vibeVs">
	      	    	<table class="table table-striped">
	      	    		<!-- header -->
	      	    		<tr>
	      	    			<td>
	      	    				<table>
	      	    					<tr>
	      	    						<div class="row">
	      	    							<div class="col-md-2">Model</div>
	      	    							<div class="col-md-3">SN range</div>
	      	    							<div class="col-md-2">btlVersion</div>
	      	    							<div class="col-md-2">appVersion</div>
	      	    						</div>
	      	    					</tr>
	      	    				</table>
	      	    			</td>
	      	    		</tr>
	      	    		@foreach ($o2vibeVs as $version)
	      	    		<tr>
	      	    			<td>
	      	    				<table>
	      	    					<tr>
	      	    						<div class="row">
	      	    							<div class="col-md-2">{{ $version->deviceName }}</div>
	      	    							<div class="col-md-3">
	      	    								@if ($version->snMin == $version->snMax)
	      	    									{{$version->snMax}}
	      	    								@elseif ($version->snMin == 0 && $version->snMax == 9999999999)
	      	    									No Limit
	      	    								@else
	      	    									{{ $version->snMin }} - {{ $version->snMax}}
	      	    								@endif
	      	    							</div>
	      	    							<div class="col-md-2">{{ $version->btlVersion }}</div>
	      	    							<div class="col-md-2">{{ $version->appVersion }}</div>
	      	    						</div>
	      	    					</tr>
	      	    				</table>
	      	    			</td>
	      	    		</tr>
	      	    		@endforeach
	      	    	</table>
	      	    	
	      	    </div>

	      	    <!-- AirBP -->
	      	    <div role="tabpanel" class="tab-pane" id="airbpVs">
	      	    	<table class="table table-striped">
	      	    		<!-- header -->
	      	    		<tr>
	      	    			<td>
	      	    				<table>
	      	    					<tr>
	      	    						<div class="row">
	      	    							<div class="col-md-2">Model</div>
	      	    							<div class="col-md-3">SN range</div>
	      	    							<div class="col-md-2">btlVersion</div>
	      	    							<div class="col-md-2">appVersion</div>
	      	    						</div>
	      	    					</tr>
	      	    				</table>
	      	    			</td>
	      	    		</tr>
	      	    		@foreach ($airbpVs as $version)
	      	    		<tr>
	      	    			<td>
	      	    				<table>
	      	    					<tr>
	      	    						<div class="row">
	      	    							<div class="col-md-2">{{ $version->deviceName }}</div>
	      	    							<div class="col-md-3">
	      	    								@if ($version->snMin == $version->snMax)
	      	    									{{$version->snMax}}
	      	    								@elseif ($version->snMin == 0 && $version->snMax == 9999999999)
	      	    									No Limit
	      	    								@else
	      	    									{{ $version->snMin }} - {{ $version->snMax}}
	      	    								@endif
	      	    							</div>
	      	    							<div class="col-md-2">{{ $version->btlVersion }}</div>
	      	    							<div class="col-md-2">{{ $version->appVersion }}</div>
	      	    						</div>
	      	    					</tr>
	      	    				</table>
	      	    			</td>
	      	    		</tr>
	      	    		@endforeach
	      	    	</table>
	      	    	
	      	    </div>

				<!-- ER1 -->
				<div role="tabpanel" class="tab-pane" id="er1Vs">
	      	    	<table class="table table-striped">
	      	    		<!-- header -->
	      	    		<tr>
	      	    			<td>
	      	    				<table>
	      	    					<tr>
	      	    						<div class="row">
	      	    							<div class="col-md-2">Model</div>
	      	    							<div class="col-md-3">SN range</div>
	      	    							<div class="col-md-2">btlVersion</div>
	      	    							<div class="col-md-2">appVersion</div>
	      	    						</div>
	      	    					</tr>
	      	    				</table>
	      	    			</td>
	      	    		</tr>
	      	    		@foreach ($er1Vs as $version)
	      	    		<tr>
	      	    			<td>
	      	    				<table>
	      	    					<tr>
	      	    						<div class="row">
	      	    							<div class="col-md-2">{{ $version->deviceName }}</div>
	      	    							<div class="col-md-3">
	      	    								@if ($version->snMin == $version->snMax)
	      	    									{{$version->snMax}}
	      	    								@elseif ($version->snMin == 0 && $version->snMax == 9999999999)
	      	    									No Limit
	      	    								@else
	      	    									{{ $version->snMin }} - {{ $version->snMax}}
	      	    								@endif
	      	    							</div>
	      	    							<div class="col-md-2">{{ $version->btlVersion }}</div>
	      	    							<div class="col-md-2">{{ $version->appVersion }}</div>
	      	    						</div>
	      	    					</tr>
	      	    				</table>
	      	    			</td>
	      	    		</tr>
	      	    		@endforeach
	      	    	</table>
	      	    	
	      	    </div>

				<!-- ER2 -->
				<div role="tabpanel" class="tab-pane" id="er2Vs">
	      	    	<table class="table table-striped">
	      	    		<!-- header -->
	      	    		<tr>
	      	    			<td>
	      	    				<table>
	      	    					<tr>
	      	    						<div class="row">
	      	    							<div class="col-md-2">Model</div>
	      	    							<div class="col-md-3">SN range</div>
	      	    							<div class="col-md-2">btlVersion</div>
	      	    							<div class="col-md-2">appVersion</div>
	      	    						</div>
	      	    					</tr>
	      	    				</table>
	      	    			</td>
	      	    		</tr>
	      	    		@foreach ($er2Vs as $version)
	      	    		<tr>
	      	    			<td>
	      	    				<table>
	      	    					<tr>
	      	    						<div class="row">
	      	    							<div class="col-md-2">{{ $version->deviceName }}</div>
	      	    							<div class="col-md-3">
	      	    								@if ($version->snMin == $version->snMax)
	      	    									{{$version->snMax}}
	      	    								@elseif ($version->snMin == 0 && $version->snMax == 9999999999)
	      	    									No Limit
	      	    								@else
	      	    									{{ $version->snMin }} - {{ $version->snMax}}
	      	    								@endif
	      	    							</div>
	      	    							<div class="col-md-2">{{ $version->btlVersion }}</div>
	      	    							<div class="col-md-2">{{ $version->appVersion }}</div>
	      	    						</div>
	      	    					</tr>
	      	    				</table>
	      	    			</td>
	      	    		</tr>
	      	    		@endforeach
	      	    	</table>
	      	    	
	      	    </div>

	      	  </div>
	      </div>

    	</div>

		</div>
	</div>
</div>
@endsection