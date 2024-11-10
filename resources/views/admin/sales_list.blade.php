@extends('admin.layouts.master')
@section('content')
    <section class="content-header">
        <div class="box">
            <div class="box-header">
                <div style="display: flex;align-items:center;justify-content:space-between">
                    <div>
                        <h2 style="font-size: 25px">Sales Report</h2>
                    </div>
                    <div>
                        <h4 style="display: flex;align-items:center;gap:10px">Total Sales Amount : <strong
                                style="font-size: 30px"> ৳ {{ $TotalSalesAmount }}</strong></h4>
                    </div>
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
                                    <button type="submit" class="btn btn-success btn-sm" style="font-size: 15px">Filter</button>
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
                            <th>Date</th>
                            <th>Purpose</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salesData as $key => $data)
                            <tr>
                                <td>{{ ($salesData->currentPage() - 1) * $salesData->perPage() + $key + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d F Y h:i A') }}</td>
                                <td>{{ $data->purpose }}</td>
                                <td>৳ {{ $data->amount }}</td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#edit{{ $data->id }}"
                                        class="btn btn-success">Update</a>
                                </td>
                            </tr>

                            <!-- Modal for updating -->
                            <div class="modal fade" id="edit{{ $data->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="display: flex; justify-content:space-between">
                                            <h5 style="font-size: 20px">Update Sale</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.sale.update', $data->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="amount"><b>Amount</b></label>
                                                    <input type="number" name="amount" id="amount" class="form-control"
                                                        min="1" value="{{ $data->amount }}" step="0.1">
                                                </div>
                                                <div class="form-group my-3">
                                                    <label for="purpose"><b>Purpose</b></label>
                                                    <textarea name="purpose" id="purpose" class="form-control" cols="30" rows="5">{{ $data->purpose }}</textarea>
                                                </div>
                                                <button type="submit" class="btn btn-success"><b>Update</b></button>
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
