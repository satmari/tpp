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

	public function show_po () 
	{	
		//
		$data = DB::connection('sqlsrv')->select(DB::raw("SELECT po FROM tpp_pos ORDER BY id"));
		return view('Marker.show_po', compact('data'));	
	}

	public function show_markers_by_po ($po) 
	{	
		//
		// dd($po);
		// $po = '17T45800088372';
	
		$data = DB::connection('sqlsrv1')->select(DB::raw("SELECT H.[Order Commessa],
			H.[Item No_] as item,
			H.[Variant Code] as variant
			    ,CONVERT(DECIMAL(10,2),sum(H.[Quantity])) as HU_ConsumedMT  /*CONVERT(DECIMAL(10,2),YOURCOLUMN)*/
			    , H.[Module No_] as HU_Marker
			    ,H.[DOCUMENT NO_]
				,MAX(H.[Posting Date]) as IssueDate
			    ,VND.[Name] as [Buy-from Vendor Name]
			  FROM [dbo].[GORDON\$Handling Unit] as H left join
			   dbo.GORDON\$Item AS i ON i.No_ = H.[Item No_] left join

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
			) as VND on VND.[Document No_] = H.[Document No_] 
			 
			  where   i.[Use HU] = 1 and H.[Order Commessa] like '%' + :somevariable and H.[Status] = 3
			  group by H.[Item No_],H.[Variant Code],H.[Order Commessa] , H.[Module No_],  H.[DOCUMENT NO_],
			    VND.[Name]"), array(

					'somevariable' => $po
		));
		

		if (isset($data[0]->HU_Marker)) {
			// dd($data);
			// dd((float)$data[0]->quantity);

			return view('Marker.show_markers_by_po', compact('data'));	

		} else {
			
			$msg = "Markers not found for this PO";
			return view('Marker.error',compact('msg'));
		}

	}

	public function show_marker_details($marker)
	{
		//
		// dd($marker);

	
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

