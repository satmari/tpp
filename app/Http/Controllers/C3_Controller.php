<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use Carbon\Carbon;

use App\C3;
use DB;

class C3_Controller extends Controller {


	public function index()
	{
		//
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM c3_table ORDER BY id"));
		return view('C3.index', compact('data'));
	}

	public function add_new_c3()
	{
		return view('C3.add');
	}

	public function c3_insert(Request $request)
	{
		//validation
		$this->validate($request, ['c3'=>'required','invoice'=>'required']);

		$input = $request->all(); 
		//var_dump($input);
	
		$c3 = $input['c3'];
		$invoice = $input['invoice'];

		
		try {
			$table = new C3;

			$table->c3 = $c3;
			$table->invoice = $invoice;

			$table->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			$msg = "Problem to save in table";
			return view('C3.error',compact('msg'));
		}

		return Redirect::to('/c3');
	}

	public function edit_c3($id)
	{
		$data = C3::findOrFail($id);		
		return view('C3.edit', compact('data'));

	}

	public function update($id, Request $request) 
	{
		//
		$this->validate($request, ['c3'=>'required','invoice'=>'required']);

		$table = C3::findOrFail($id);
		
		$input = $request->all(); 
		//dd($input);

		try {		
			$table->c3 = $input['c3'];
			$table->invoice = $input['invoice'];
						
			$table->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			return view('C3.error');		
		}
		
		return Redirect::to('/c3');
	}

	

}
