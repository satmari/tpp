@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-4 col-md-offset-4">
            <div class="panel panel-default">
				<div class="panel-heading">Izdavanje tekstilnog materijala</div>
				<br>
					{!! Form::open(['method'=>'POST', 'url'=>'/marker_insert']) !!}

						<div class="panel-body">
						<p>Marker: </p>
							{!! Form::input('number','marker', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
						</div>
						
											
						{!! Form::submit('Confirm', ['class' => 'btn  btn-success center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}
				
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