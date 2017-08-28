<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use Carbon\Carbon;

use App\C5;
use DB;

class C5_Controller extends Controller {


	public function index()
	{
		//
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM c5_table ORDER BY id"));
		return view('C5.index', compact('data'));
	}

	public function add_new_c5()
	{
		return view('C5.add');
	}

	public function c5_insert(Request $request)
	{
		//validation
		$this->validate($request, ['c5'=>'required','invoice'=>'required']);

		$input = $request->all(); 
		//var_dump($input);
	
		$c5 = $input['c5'];
		$invoice = $input['invoice'];

		
		try {
			$table = new C5;

			$table->c5 = $c5;
			$table->invoice = $invoice;

			$table->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			$msg = "Problem to save in table";
			return view('C5.error',compact('msg'));
		}

		return Redirect::to('/c5');
	}

	public function edit_c5($id)
	{
		$data = C5::findOrFail($id);		
		return view('C5.edit', compact('data'));

	}

	public function update($id, Request $request) 
	{
		//
		$this->validate($request, ['c5'=>'required','invoice'=>'required']);

		$table = C5::findOrFail($id);
		
		$input = $request->all(); 
		//dd($input);

		try {		
			$table->c5 = $input['c5'];
			$table->invoice = $input['invoice'];
						
			$table->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			return view('C5.error');		
		}
		
		return Redirect::to('/c5');
	}

	

}
