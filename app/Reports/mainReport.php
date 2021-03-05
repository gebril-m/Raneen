<?php 
namespace App\Reports;
use Illuminate\Http\Request;

abstract class mainReport {
    abstract function table();
    abstract function tableResults(Request $request);
}
