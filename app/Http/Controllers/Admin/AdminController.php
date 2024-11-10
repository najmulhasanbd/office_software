<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use Carbon\Carbon;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function index()
    {


        //todays sales
        $todayStart = Carbon::today()->startOfDay();
        $todayEnd = Carbon::today()->endOfDay();

        $todaySalesAmount = Sales::whereBetween('created_at', [$todayStart, $todayEnd])->sum('amount');

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


        $monthlySales = Sales::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
        ->whereYear('created_at', Carbon::now()->year) // Filter to only this year's sales
        ->groupBy('month')
        ->pluck('total', 'month')
        ->toArray();

    // Make sure all 12 months are accounted for, filling in 0 where there are no sales
    $monthlySales = array_replace(array_fill(1, 12, 0), $monthlySales);


        return view('admin.home', compact('todaySalesAmount', 'weeklySalesAmount', 'thisMonthSalesAmount', 'thisYearSalesAmount', 'monthlySales'));
    }



    public function adminSalesList(Request $request)
    {
        $filter = $request->sale_filter;

        if ($filter == 'today') {
            $salesData = Sales::whereDate('created_at', Carbon::today())->latest()->paginate(20);
        } elseif ($filter == 'yesterday') {
            $salesData = Sales::whereDate('created_at', Carbon::yesterday())->latest()->paginate(20);
            // dd('here');
        } elseif ($filter == 'weekly') {
            $salesData = Sales::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->latest()->paginate(20);
        } elseif ($filter == 'monthly') {
            $salesData = Sales::whereMonth('created_at', Carbon::now()->month)->latest()->paginate(20);
        } elseif ($filter == 'year') {
            $salesData = Sales::whereYear('created_at', Carbon::now()->year)->latest()->paginate(20);
        } else {
            $salesData = Sales::latest()->paginate(20);
        }

        $TotalSalesAmount = $salesData->sum('amount');

        return view('admin.sales_list', compact('salesData', 'TotalSalesAmount', 'filter'));
    }



    public function adminSaleUpdate(Request $request, $id)
    {
        // Validate the incoming data
        $request->validate([
            'amount' => 'required|numeric',
            'purpose' => 'required|string|max:255',
        ]);

        // Find the sale by its ID
        $sale = Sales::findOrFail($id); // If not found, it will throw a 404 error

        // Update the sale record
        $sale->update([
            'amount' => $request->amount,
            'purpose' => $request->purpose,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Sale updated successfully!');
    }
}
