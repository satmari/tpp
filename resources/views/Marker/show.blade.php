@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-4 col-md-offset-4">
            <div class="panel panel-default">
				<div class="panel-heading">Izdavanje tekstilnog materijala</div>
				<br>
					
				<table class="table">
					 <thead>
				        <tr><td>Datum izdavanja</td><td>{{ Carbon\Carbon::parse($posting_date)->format('d.m.Y') }}</td></tr>
			            <tr><td>Faktura br</td><td>{{ $invoice }}</td></tr>
				        <tr><td>Dobavljač </td><td>{{ $vendor }}</td></tr>
				        <tr><td>C5 dokument br.</td><td>{{ $c5 }}</td></tr>
				        <tr><td>Materijal</td><td>{{ $item }}</td></tr>
				        <tr><td>Varijanta</td><td>{{ $variant }}</td></tr>
				        <tr><td>Commessa</td><td>{{ $po }}</td></tr>
				        <tr><td>Marker</td><td>{{ $hu_marker }}</td></tr>
				        <tr><td>Količina (m)</td><td>{{ round($hu_consumedmt,2) }}</td></tr>

				           
				        </tr>
				    </thead>
				   
				</table>
				<br>
				<hr>
				<div class="">
					<a href="{{url('/')}}" class="btn btn-default">Save marker to TPP markers</a>
				</div>				
				
				<hr>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/')}}" class="btn btn-default">Back</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection