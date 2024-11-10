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
   <div style="background: url('{{ asset('frontend/bg.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 100vh;">
        <div class="container py-5" >
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row d-flex align-items-stretch">
                <div class="col-md-6 mx-auto">
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
                                <input type="number" name="amount" id="amount" class="form-control"
                                    placeholder="Enter amount" step="0.1" required>
                            </div>
                                <button type="submit" class="btn text-white w-100"
                                    style="background: #335DFF;"><b>Submit</b></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
