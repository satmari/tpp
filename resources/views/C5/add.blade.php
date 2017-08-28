@extends('app')

@section('content')

<div class="container-fluid">
    <div class="row vertical-center-row">
        <div class="text-center col-md-4 col-md-offset-4">
            <div class="panel panel-default">
				<div class="panel-heading">Add new C5</div>
				<br>
					{!! Form::open(['method'=>'POST', 'url'=>'/c5_insert']) !!}

						<div class="panel-body">
						<p>C5: </p>
							{!! Form::text('c5', null, ['class' => 'form-control', 'autofocus' => 'autofocus']) !!}
						</div>
						
						<div class="panel-body">
						<p>Invoice: </p>
							{!! Form::text('invoice', null, ['class' => 'form-control']) !!}
						</div>
						<br>
						
						{!! Form::submit('Add', ['class' => 'btn  btn-success center-block']) !!}

						@include('errors.list')

					{!! Form::close() !!}
				
				<hr>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/c5')}}" class="btn btn-default">Back</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection