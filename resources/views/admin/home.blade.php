@extends('admin.layouts.master')
@section('content')
    <section class="content-header">
        <h1>
            Dashboard
            <small>Admin Panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>৳ {{ $todaySalesAmount }}</h3>
                        <p>Today Sales</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>৳ {{ $weeklySalesAmount }}</h3>
                        <p>Weakly Sales</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>৳ {{ $thisMonthSalesAmount }}</h3>
                        <p>This Month Sales</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>৳ {{ $thisYearSalesAmount }}</h3>
                        <p>This Year Sales</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                </div>
            </div><!-- ./col -->
        </div><!-- /.row -->

    </section><!-- /.content -->


    <section class="content">
        <h2>Month-wise Sales Report</h2>
        <div id="barchart" style="width: 100%; height: 500px;"></div>
    </section>

   

@endsection
