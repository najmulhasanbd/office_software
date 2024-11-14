@extends('admin.layouts.master')
@section('content')
    <section class="content-header">
        <div class="box">
            <div class="box-header">
                <div style="display: flex; align-items:center; justify-content:center; gap:20px">
                    <div>
                        <h2 style="font-size: 25px; margin:0">Withdraw Report</h2>
                    </div>

                </div><!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Date & Time</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payment as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y h:i A') }}</td>
                                    <td>{{ $item->amount }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
