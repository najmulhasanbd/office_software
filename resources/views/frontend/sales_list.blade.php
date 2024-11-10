
@extends('frontend.layout.master')

@section('user_content')
    
<div class="purpose_table py-5">
    <div class="container">
        <div class="text-end mb-2">
            <a href="{{route('user.dashboard')}}" class="btn btn-primary">Back</a>
        </div>
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