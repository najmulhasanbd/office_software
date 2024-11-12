<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


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

        return view('frontend.dashboard', compact('salesData', 'todayTotalSalesAmount', "weeklySalesAmount", "thisMonthSalesAmount", "thisYearSalesAmount"));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|array',
            'amount.*' => 'required|numeric',
            'purpose' => 'required|array',
            'purpose.*' => 'required|string',
        ]);

        $datePart = date('dmy');

        $lastInvoice = Sales::whereDate('created_at', today())
            ->orderBy('invoice_id', 'desc')
            ->first();

        if ($lastInvoice) {
            $lastSequence = (int) substr($lastInvoice->invoice_id, -2);
            $newSequence = str_pad($lastSequence + 1, 2, '0', STR_PAD_LEFT);
        } else {
            $newSequence = '01';
        }

        $invoice_id = $datePart . $newSequence;


        Sales::create([
            'invoice_id' => $invoice_id,
            'amount' => json_encode($request->amount),
            'purpose' => json_encode($request->purpose),
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->back()->with('success', "Sales Recorded Successfully!");
    }


    public function  salesList(Request $request)
    {

        $salesData = Sales::latest()->paginate(15);

        return view('frontend.sales_list', compact('salesData'));
    }
    public function index(Request $request)
    {
        $query = Sales::query();
    
        // Check if there's a search term
        if ($request->has('search') && $request->search != '') {
            $query->where('invoice_id', 'like', '%' . $request->search . '%');
        }
    
        $salesData = $query->paginate(10); // Adjust pagination as needed
    
        return view('frontend.sales_list', compact('salesData'));
    }
    


    public function salesReportShow($id)
    {
        $salesDetails = Sales::findOrFail($id);

        // Decode the JSON fields
        $decodedPurpose = json_decode($salesDetails->purpose, true);
        $decodedAmount = json_decode($salesDetails->amount, true);
        $totalAmount = array_sum($decodedAmount);

        return view('frontend.sales_report_show', compact('decodedPurpose', 'decodedAmount', 'salesDetails', 'totalAmount'));
    }


    public function salesReport()
    {
        $todayTotalSalesAmount = Sales::whereDate('created_at', Carbon::today())->get()->sum(function ($sale) {

            $amounts = is_array($sale->amount) ? $sale->amount : json_decode($sale->amount, true);
            return array_sum($amounts);
        });

        // Weekly sales
        $weekStart = Carbon::now()->startOfWeek(Carbon::SATURDAY);
        $weekEnd = Carbon::now()->endOfWeek(Carbon::SATURDAY);

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



        // Return the view with calculated sales data
        return view('frontend.sales_report', compact('weeklySalesAmount', 'thisMonthSalesAmount', 'thisYearSalesAmount', 'todayTotalSalesAmount'));
    }
}
