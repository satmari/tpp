@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-4 col-md-offset-4">
            <div class="panel panel-default">
				<div class="panel-heading">Add new Po</div>
				<br>
					{!! Form::open(['method'=>'POST', 'url'=>'/po_insert']) !!}

						<div class="panel-body">
						<p>Po: </p>
							{!! Form::text('po', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
						</div>
						
						<br>
						
						{!! Form::submit('Add', ['class' => 'btn  btn-success center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}
				
				<hr>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/po')}}" class="btn btn-default">Back</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection