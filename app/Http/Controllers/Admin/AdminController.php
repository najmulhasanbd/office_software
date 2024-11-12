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

        // Calculate today's total sales amount
        $todayTotalSalesAmount = Sales::whereDate('created_at', Carbon::today())->get()->sum(function ($sale) {
            // Decode the JSON 'amount' field and sum the values
            $amounts = is_array($sale->amount) ? $sale->amount : json_decode($sale->amount, true);
            return array_sum($amounts);
        });

        // Weekly sales
        $weekStart = Carbon::now()->startOfWeek(Carbon::SATURDAY);
        $weekEnd = Carbon::now()->endOfWeek(Carbon::SATURDAY);

        // Calculate total sales amount for the current week
        $weeklySalesAmount = Sales::whereBetween('created_at', [$weekStart, $weekEnd])->get()->sum(function ($sale) {
            $amounts = is_array($sale->amount) ? $sale->amount : json_decode($sale->amount, true);
            return array_sum($amounts);
        });

        // This month's sales
        $thisMonthStart = Carbon::now()->startOfMonth();
        $thisMonthEnd = Carbon::now()->endOfMonth();
        $thisMonthSalesAmount = Sales::whereBetween('created_at', [$thisMonthStart, $thisMonthEnd])->get()->sum(function ($sale) {
            $amounts = is_array($sale->amount) ? $sale->amount : json_decode($sale->amount, true);
            return array_sum($amounts);
        });

        // This year's sales
        $thisYearStart = Carbon::now()->startOfYear();
        $thisYearEnd = Carbon::now()->endOfYear();
        $thisYearSalesAmount = Sales::whereBetween('created_at', [$thisYearStart, $thisYearEnd])->get()->sum(function ($sale) {
            $amounts = is_array($sale->amount) ? $sale->amount : json_decode($sale->amount, true);
            return array_sum($amounts);
        });

        return view('admin.home',compact('weeklySalesAmount', 'thisMonthSalesAmount', 'thisYearSalesAmount', 'todayTotalSalesAmount'));
    }


    

    public function adminSalesList(Request $request)
    {
        $date = $request->date;
        $salesquery = Sales::latest();

        if ($request->filled('date')) {
            $dateRange = explode(" - ", $date);
            $startDate = date('Y-m-d', strtotime($dateRange[0]));
            $endDate = date('Y-m-d', strtotime($dateRange[1]));

            $salesquery->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate])
                    ->orWhereDate('created_at', $startDate);
            });

            
            // $salesquery->whereBetween('created_at', [$startDate, $endDate]);
        }
    
        $salesData = $salesquery->paginate(20);
    

        return view('admin.sales_list',compact('salesData','date'));
    }
    

    public function adminSaleUpdate(Request $request, $id)
    {
        // Validate the incoming data (arrays of purpose and amount)
        $request->validate([
            'purpose' => 'required|array',  // Make sure purpose is an array
            'purpose.*' => 'string|max:255', // Each item in purpose should be a string
            'amount' => 'required|array',   // Make sure amount is an array
            'amount.*' => 'numeric',        // Each item in amount should be numeric
        ]);
    
        // Find the sale by its ID
        $sale = Sales::findOrFail($id);
    
        // Update the sale record
        $sale->update([
            'purpose' => json_encode($request->purpose), // Store as JSON
            'amount' => json_encode($request->amount),   // Store as JSON
        ]);
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Sale updated successfully!');
    }
    
}
