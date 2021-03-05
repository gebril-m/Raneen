<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reports\mainReport;
use App\Reports\ordersReport;

class ReportsController extends Controller
{

    /**
     * orders reports.
     */

    function ordersReportTable(ordersReport $report){
        return $this->viewDispatcher($report);
    }

    function ordersReportResults(ordersReport $report, Request $request){
        return $this->resultsDispatcher($report, $request);
    }

    /**
     * customers reports
     */

    function customersReportForm(){

    }

    function customersReportResult(Request $request){
        
    }

    /**
     * Dispatchers
     */

    function viewDispatcher(mainReport $report){
        return $report->table();
    }

    function resultsDispatcher(mainReport $report, Request $request){
        return $report->tableResults($request);
    }

}
