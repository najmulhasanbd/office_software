@extends('admin.layouts.master')
@section('content')
    <section class="content-header">
        <div class="box">
            <div class="box-header">
                <div style="display: flex;align-items:center; justify-content:center;gap:20px">
                    <div>
                        <h2 style="font-size: 25px;margin:0">Sales Report</h2>
                    </div>
                    <div>
                        <div>
                            <form action="" method="get" id="filterForm">
                                @csrf

                                <div style="display: flex; align-items:center;gap:5px">
                                    <div class="custom_select">
                                        <input type="text" id="reportrange"
                                            style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%"
                                            name="date" placeholder="Filter by date" data-format="DD-MM-Y"
                                            value="{{ $date }}" data-separator=" - " autocomplete="off">
                                        <input type="hidden" id="dateadd" class="form-control " name="dateadd"
                                            data-format="DD-MM-Y" value="{{ $date }}" autocomplete="off">
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-success btn-sm"
                                            style="font-size: 15px">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- /.box-header -->

                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Invoice</th>
                                <th>Date & Time</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($salesData as $key => $sale)
                                <tr>
                                    <td>{{ ($salesData->currentPage() - 1) * $salesData->perPage() + $key + 1 }}</td>
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
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#{{ $sale->id }}"
                                            class="btn btn-sm btn-success" title="Details">Update</a>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="{{ $sale->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    {{ ucwords($sale->name) }}-{{ $sale->phone }}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.sale.update', $sale->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    @php
                                                        // Decode the JSON-encoded 'purpose' and 'amount' fields
                                                        $decodedPurpose = json_decode($sale->purpose, true);
                                                        $decodedAmount = json_decode($sale->amount, true);
                                                    @endphp

                                                    @foreach ($decodedPurpose as $key => $purpose)
                                                        <div class="form-group">
                                                            <label for="purpose">Purpose</label>
                                                            <!-- Ensure the name is an array so that all values can be submitted -->
                                                            <input type="text" name="purpose[]" class="form-control"
                                                                value="{{ $purpose }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="amount">Amount</label>
                                                            <!-- Ensure the name is an array so that all values can be submitted -->
                                                            <input type="text" name="amount[]" class="form-control"
                                                                value="{{ $decodedAmount[$key] }}">
                                                        </div>
                                                    @endforeach

                                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </tbody>
                    </table>
                    @if ($salesData)
                        <div class="pagination">
                            {{ $salesData->links() }}
                        </div>
                    @endif

                </div>
            </div>
    </section>




    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


    <script type="text/javascript">
        $(function() {
            var dateValue = $('input[name="date"]').val();
            var start, end;
            if (dateValue) {
                var dates = dateValue.split(' - ');
                start = moment(dates[0], 'MM/DD/YYYY');
                end = moment(dates[1], 'MM/DD/YYYY');
            } else {
                start = moment();
                end = moment();
            }
            $('input[name="date"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            function cb(start, end) {
                $('#reportrange').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            }, cb);
            cb(start, end);
        });
    </script>
@endsection
