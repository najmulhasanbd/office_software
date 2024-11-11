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


        foreach ($request->purpose as $index => $purpose) {
            Sales::create([
                'amount' => $request->amount[$index],
                'purpose' => $purpose,
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
        }

        return redirect()->back()->with('success', "Sales Recorded Successfully!");
    }

    public function  salesList(Request $request)
    {

        $salesData = Sales::orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($date) {
                return \Carbon\Carbon::parse($date->created_at)->format('Y-m-d');
            })
            ->map(function ($daySales) {
                return [
                    'sales' => $daySales,
                    'total_amount' => $daySales->sum('amount'),
                ];
            })
            ->sortKeysDesc(); // Ensure the data is sorted by date in descending order

        return view('frontend.sales_list', compact('salesData'));
    }

    public function salesReport()
    {

        $todayTotalSalesAmount = Sales::whereDate('created_at', Carbon::today())->sum('amount');
        //weakly day sales
        $weekStart = Carbon::now()->startOfWeek(Carbon::SATURDAY);
        $weekEnd = Carbon::now()->endOfWeek(Carbon::SATURDAY);

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

        return view('frontend.sales_report', compact('weeklySalesAmount', 'thisMonthSalesAmount', 'thisYearSalesAmount', 'todayTotalSalesAmount'));
    }

    public function salesInvoiceList()
    {
        $salesInvoice = Sales::select('*')
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('sales')
                    ->groupBy('name', 'phone', 'address');
            })
            ->latest()
            ->get();
        return view('frontend.sales_invoice_list', compact('salesInvoice'));
    }

    public function salesInvoiceShow(Request $request)
    {
        $name = $request->name;
        $phone = $request->phone;
        $address = $request->address;

        $relatedInvoices = Sales::where('name', $name)
            ->where('phone', $phone)
            ->where('address', $address)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.sales_invoice_show', compact('relatedInvoices', 'name', 'phone', 'address'));
    }
}
