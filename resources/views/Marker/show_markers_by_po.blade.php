@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row vertical-center-row">
		<div class="text-center col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				
				<br>
                <div class="input-group"> <span class="input-group-addon">Filter</span>
                    <input id="filter" type="text" class="form-control" placeholder="Type here...">
                </div>

                <table class="table table-striped table-bordered" id="sort" 
                >
                <!--
                data-show-export="true"
                data-export-types="['excel']"
                data-search="true"
                data-show-refresh="true"
                data-show-toggle="true"
                data-query-params="queryParams" 
                data-pagination="true"
                data-height="500"
                data-show-columns="true" 
                data-export-options='{
                         "fileName": "preparation_app", 
                         "worksheetName": "test1",         
                         "jspdf": {                  
                           "autotable": {
                             "styles": { "rowHeight": 20, "fontSize": 10 },
                             "headerStyles": { "fillColor": 255, "textColor": 0 },
                             "alternateRowStyles": { "fillColor": [60, 69, 79], "textColor": 255 }
                           }
                         }
                       }'
                -->
				    <thead>
				        <tr>
				           {{--<th>id</th>--}}
				           <th><b>Marker</b></th>
				           <th>Materijal</th>
				           <th>Varijanta</th>
				           <th>Količina (m)</th>
				           <th>Datum izdavanja</th>
				           				           				           
				           <th></th>
				        </tr>
				    </thead>
				    <tbody class="searchable">
				    
				    @foreach ($data as $d)
				    	
				        <tr>
				        	{{--<td>{{ $d->id }}</td>--}}
				        	<td><b>{{ $d->HU_Marker }}</b></td>
				        	<td>{{ $d->item }}</td>
				        	<td>{{ $d->variant }}</td>
				        	<td>{{ $d->HU_ConsumedMT }}</td>
				        	<td>{{ Carbon\Carbon::parse($d->IssueDate)->format('d.m.Y')  }}</td>
				        	
				        	<td>
				        		@if(Auth::check())
				        			<a href="{{ url('/show_marker_details/'.$d->HU_Marker) }}" class="btn btn-info btn-xs center-block">Document</a>
				        		@endif
				        	</td>
				        	
				        	
				        	
						</tr>
				    
				    @endforeach
				    </tbody>

				</table>
			</div>
		</div>
	</div>
</div>

@endsection