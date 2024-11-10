<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDO;

class FrontendController extends Controller
{
    public function userDashboard()
    {
       
        $salesData = Sales::latest()->paginate(20);
        $todayTotalSalesAmount = Sales::whereDate('created_at', Carbon::today())->sum('amount');

        //weakly day sales
        $weekStart = Carbon::now()->startOfWeek(Carbon::SATURDAY);  // Start on Saturday
        $weekEnd = Carbon::now()->endOfWeek(Carbon::SATURDAY);      // End on Friday

        // Calculate total sales amount for the current week
        $weeklySalesAmount = Sales::whereBetween('created_at', [$weekStart, $weekEnd])->sum('amount');

        //this month sales
        $thisMonthStart = Carbon::now()->startOfMonth();
        $thisMonthEnd = Carbon::now()->endOfMonth();
        $thisMonthSalesAmount = Sales::whereBetween('created_at', [$thisMonthStart, $thisMonthEnd])->sum('amount');

        //this year
        $thisYearStart = Carbon::now()->startOfYear();
        $thisYearEnd = Carbon::now()->endOfYear();
        $thisYearSalesAmount = Sales::whereBetween('created_at', [$thisYearStart, $thisYearEnd])->sum('amount');

        return view('frontend.dashboard',compact('salesData','todayTotalSalesAmount',"weeklySalesAmount","thisMonthSalesAmount","thisYearSalesAmount"));
    }

    

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'purpose' => 'required|string|max:255',
        ]);      
    
        Sales::create([
            'amount' => $request->amount,
            'purpose' => $request->purpose,
        ]);
    
        return redirect()->back()->with('success', 'Sale Recorded Successfully!');
    }

    public function  salesList() {
        $salesData = Sales::latest()->paginate(20);
        return view('frontend.sales_list',compact('salesData'));
    }

    public function salesReport(){

        $todayTotalSalesAmount = Sales::whereDate('created_at', Carbon::today())->sum('amount');
          //weakly day sales
          $weekStart = Carbon::now()->startOfWeek(Carbon::SATURDAY);  // Start on Saturday
          $weekEnd = Carbon::now()->endOfWeek(Carbon::SATURDAY);      // End on Friday
  
          // Calculate total sales amount for the current week
          $weeklySalesAmount = Sales::whereBetween('created_at', [$weekStart, $weekEnd])->sum('amount');
  
          //this month sales
          $thisMonthStart = Carbon::now()->startOfMonth();
          $thisMonthEnd = Carbon::now()->endOfMonth();
          $thisMonthSalesAmount = Sales::whereBetween('created_at', [$thisMonthStart, $thisMonthEnd])->sum('amount');
  
          //this year
          $thisYearStart = Carbon::now()->startOfYear();
          $thisYearEnd = Carbon::now()->endOfYear();
          $thisYearSalesAmount = Sales::whereBetween('created_at', [$thisYearStart, $thisYearEnd])->sum('amount');

        return view('frontend.sales_report',compact('weeklySalesAmount','thisMonthSalesAmount','thisYearSalesAmount','todayTotalSalesAmount'));
    }
    
}
