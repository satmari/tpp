<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use Carbon\Carbon;

use App\tpp_po;
use DB;

class Po_Controller extends Controller {


	public function index()
	{
		//
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT * FROM tpp_pos ORDER BY id"));
		return view('Po.index', compact('data'));
	}

	public function add_new_po()
	{
		return view('Po.add');
	}

	public function po_insert(Request $request)
	{
		//validation
		$this->validate($request, ['po'=>'required']);

		$input = $request->all(); 
		//var_dump($input);
	
		$po = $input['po'];
				
		try {
			$table = new tpp_po;

			$table->po = $po;
			
			$table->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			$msg = "Problem to save in table";
			return view('Po.error',compact('msg'));
		}

		return Redirect::to('/po');
	}

	public function edit_po($id)
	{
		$data = tpp_po::findOrFail($id);		
		return view('Po.edit', compact('data'));

	}

	public function update($id, Request $request) 
	{
		//
		$this->validate($request, ['po'=>'required']);

		$table = tpp_po::findOrFail($id);
		
		$input = $request->all(); 
		//dd($input);

		try {		
			$table->po = $input['po'];
									
			$table->save();
		}
		catch (\Illuminate\Database\QueryException $e) {
			return view('Po.error');		
		}
		
		return Redirect::to('/po');
	}

	

}
