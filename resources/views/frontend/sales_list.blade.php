@extends('frontend.layout.master')

@section('user_content')
    <style>
        tr td {
            vertical-align: middle
        }
    </style>
    <div class="purpose_table py-5">
        <div class="container">
            <div class="mb-2 d-flex align-items-center justify-content-between">
                <a href="{{ route('user.dashboard') }}" class="btn btn-primary">Sale Create</a>
                <form action="{{ route('sales.index') }}" method="get" class="d-flex align-items-center gap-2">
                    <input type="text" name="search" placeholder="Search by Invoice ID" class="form-control"
                        value="{{ request()->query('search') }}">
                    <button type="submit" class="btn btn-success">Search</button>
                </form>
            </div>
            <div class="row">

                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th style="width: 10px">SL</th>
                                    <th style="width: 10px">Invoice</th>
                                    <th style="width: 100px">Date & Time</th>
                                    <th style="width: 100px">Name</th>
                                    <th style="width: 100px">Phone</th>
                                    <th style="width: 100px">Total Amount</th>
                                    <th style="width: 50px">Status</th>
                                    <th style="width: 50px">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($salesData->count() > 0)
                                    @foreach ($salesData as $key => $sale)
                                        <tr>
                                            <td>{{ ($salesData->currentPage() - 1) * $salesData->perPage() + $key + 1 }}
                                            </td>
                                            <td>{{ $sale->invoice_id }}</td>
                                            <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('d M Y h:i A') }}</td>
                                            <td>{{ $sale->name }}</td>
                                            <td>{{ $sale->phone }}</td>
                                            <td>
                                                @php
                                                    $amounts = is_array($sale->amount)
                                                        ? $sale->amount
                                                        : json_decode($sale->amount, true);
                                                @endphp
                                                <strong>৳ {{ number_format(array_sum($amounts), 2) }}</strong>
                                            </td>
                                            <td>
                                                @if ($sale->updated_at != $sale->created_at)
                                                    <small style="color: gray">Edit by Admin</small>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('sales.report.show', $sale->id) }}"
                                                    class="btn btn-sm btn-primary" title="Details">Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="text-center">No data found</td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{ $salesData->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
