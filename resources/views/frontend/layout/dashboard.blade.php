@extends('frontend.layout.master')

@section('user_content')
    <style>
        #current-time {
            color: #2570B4;
            font-weight: 700;
            font-size: 16px;
        }

        .report_hover:hover {
            background: #335DFF;
            color: #fff
        }
    </style>
    <div class="container py-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row d-flex align-items-stretch">
            <div class="col-md-6">
                <div class="card p-3 h-100">
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
            <div class="col-md-6">
                <div class="card p-3 h-100">
                    <h4 class="text-center"><b>Create Sales Report</b></h4>
                    <form action="{{ route('sales.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="purpose"><b>Purpose</b></label>
                            <textarea name="purpose" id="purpose" class="form-control" cols="30" rows="3" required></textarea>
                        </div>
                        <div class="form-group py-3">
                            <label for="amount"><b>Amount</b></label>
                            <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter amount" step="0.1" required>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn text-white" style="background: #335DFF;"><b>Submit</b></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>


    <div class="purpose_table">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th style="width: 10px">SL</th>
                                <th style="width: 100px">Date</th>
                                <th style="width: 100px">Time</th>
                                <th style="width: 200px">Purpose</th>
                                <th style="width: 100px">Amount</th>
                                <th style="width: 50px">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($salesData as $key => $data)
                                <tr>
                                    <td>{{ ($salesData->currentPage() - 1) * $salesData->perPage() + $key + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::now('Asia/Dhaka')->format('d F Y') }}</td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($data->created_at)->timezone('Asia/Dhaka')->format('h:i A') }}
                                    </td>



                                    <td>{{ $data->purpose }}</td>
                                    <td class="d-flex justify-content-between">
                                        ৳ {{ $data->amount }}
                                    </td>
                                    <td>
                                        @if ($data->updated_at != $data->created_at)
                                            <small style="color: gray">Edit by Admin</small>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                    </table>
                    <!-- Pagination Links -->
                    <div class="pagination">
                        {{ $salesData->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    

@endsection
