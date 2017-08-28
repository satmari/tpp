<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTppMarkersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tpp_markers', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('marker')->unique();

			$table->string('po');
			$table->string('item');
			$table->string('variant');
			$table->string('invoice');
			$table->string('uom');
			$table->integer('hu_consumedmt');
			$table->dateTime('posting_date');
			$table->string('vendor');
			$table->string('c5');

			$table->string('status');
			$table->string('printed');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tpp_markers');
	}

}




/*

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


*/