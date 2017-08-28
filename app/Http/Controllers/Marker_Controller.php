<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use Carbon\Carbon;

use App\C5;
use DB;

class Marker_Controller extends Controller {

	
	public function index()
	{
		//
		return view('Marker.add');
	}

	public function marker_insert(Request $request)
	{
		//
		//validation
		$this->validate($request, ['marker'=>'required']);

		$input = $request->all(); 
		//var_dump($input);
	
		$marker = $input['marker'];
		// dd($marker);

	// test
		$nav = DB::connection('sqlsrv1')->select(DB::raw("SELECT 
			H.[Order Commessa] as po,
			H.[Item No_] as item,
			H.[Variant Code] as variant,
			H.[Module No_] as HU_Marker,
			H.[DOCUMENT NO_] as Invoice,
			H.[Unit Of Measure Code] as uom,
		    sum(H.[Quantity]) as HU_ConsumedMT,
			MAX (H.[Posting Date]) as posting_date,
			VND.[Name] as Vendor
			  
			FROM [dbo].[GORDON\$Handling Unit] as H 

			left join [dbo].[GORDON\$Item] AS i ON i.[No_]= H.[Item No_] 
			left join

			(SELECT [Document No_]
			      ,[Vendor No_], NM.[Name]
			  FROM [Gordon_LIVE].[dbo].[GORDON\$Inbound Delivery Header] as Inb left join
			  (SELECT [No_]
			      ,[Name]
			  FROM [Gordon_LIVE].[dbo].[GORDON\$Vendor]
			  where [No_] not like 'R%'
			  group by [No_]
			      ,[Name]) as NM on NM.[No_] = INB.[Vendor No_]
			  group by [Document No_]
			      ,[Vendor No_], NM.[Name]
			) as VND on VND.[Document No_] = H.[DOCUMENT NO_] 

			WHERE [Module No_] = :somevariable

			group by H.[Item No_],
				 H.[Variant Code],
				 H.[Order Commessa],
				 H.[Module No_],
				 H.[DOCUMENT NO_],
				 H.[Unit of Measure Code],
				 VND.[Name]
				 "), array(

					'somevariable' => $marker,
		));
		// dd($nav);
		// dd($nav[0]->Invoice);

		if (isset($nav[0]->Invoice)) {
			//C5
			$C5 = DB::connection('sqlsrv')->select(DB::raw("SELECT c5 FROM c5_table WHERE invoice = :somevariable"), array(
						'somevariable' => $nav[0]->Invoice,
			));
			// dd($C5);
			// dd($C5[0]->c5);
		} else {
			
			$msg = "Marker not found";
			return view('Marker.error',compact('msg'));
		}

		if (isset($C5[0]->c5)) {
			$c5 = $C5[0]->c5;
		} else {
			$c5 = NULL;
		}

		// dd($C5);

		$po = $nav[0]->po;
		$item = $nav[0]->item;
		$variant = $nav[0]->variant;
		$hu_marker = $nav[0]->HU_Marker;
		$invoice = $nav[0]->Invoice;
		$uom = $nav[0]->uom;
		$hu_consumedmt = $nav[0]->HU_ConsumedMT;
		$posting_date = $nav[0]->posting_date;
		$vendor = $nav[0]->Vendor;
		//$c5 = $C5[0]->c5;	


		return view('Marker.show', compact('po','item','variant','hu_marker','invoice','uom','hu_consumedmt','posting_date','vendor','c5'));

	}

}
