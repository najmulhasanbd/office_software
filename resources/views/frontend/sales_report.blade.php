
@extends('frontend.layout.master')

@section('user_content')
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card p-3">
                <h4 class="text-center"><b>My Report</b></h4>
                <h6><b>{{ ucwords(Auth::user()->name) }}</b></h6>
                <table class="table table-bordered">
                    <tr>
                        <th>Today</th>
                        <td>৳ {{ $todayTotalSalesAmount }}</td>
                    </tr>
                    <tr>
                        <th>Weekly</th>
                        <td>৳ {{ $weeklySalesAmount }}</td>
                    </tr>
                    <tr>
                        <th>Monthly</th>
                        <td>৳ {{ $thisMonthSalesAmount }}</td>
                    </tr>
                    <tr>
                        <th>Yearly</th>
                        <td>৳ {{ $thisYearSalesAmount }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection