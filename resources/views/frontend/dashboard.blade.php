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

        .dashboard_bg {
            position: absolute;
            top: 0;
            width: 100%;
        }

        .dashboard_bg {}
    </style>
    <div class="dashboard_bg"
        style="background: url('{{ asset('frontend/bg.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 100vh;">
        <div class="container py-5">

            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card p-3" style="margin-top: 70px">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show "role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <h4 class="text-center d-flex justify-content-between">
                            <b>Create Sales Report</b>
                            <i class="fa fa-plus btn btn-sm btn-success" onclick="addFormFields()"
                                style="cursor: pointer;"></i>
                        </h4>

                        <form action="{{ route('sales.store') }}" method="POST">
                            @csrf
                            <div id="formFieldsContainer">
                                <div class="form-group">
                                    <label for="name" class="mb-1"><b>Name</b></label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter name">
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="mt-2 mb-1"><b>Phone</b></label>
                                    <input type="number" name="phone" class="form-control" placeholder="Enter phone">
                                </div>
                                <div class="form-group">
                                    <label for="address" class="mt-2 mb-1"><b>Address</b></label>
                                    <textarea name="address" class="form-control" cols="30" rows="2" placeholder="Enter address"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="purpose" class="mt-2 mb-1"><b>Purpose</b></label>
                                    <textarea name="purpose[]" class="form-control" cols="30" rows="3" required placeholder="Enter purpose..."></textarea>
                                </div>
                                <div class="form-group py-3">
                                    <label for="amount" class="mb-1"><b>Amount</b></label>
                                    <input type="number" name="amount[]" class="form-control" placeholder="Enter amount"
                                        step="0.1" required>
                                </div>
                            </div>

                            <button type="button" class="btn btn-secondary my-2" onclick="addFormFields()">Add
                                More</button>

                            <button type="submit" class="btn text-white w-100"
                                style="background: #335DFF;"><b>Submit</b></button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function addFormFields() {
            var container = document.getElementById("formFieldsContainer");

            var newFields = document.createElement("div");
            newFields.classList.add("form-group-set");
            newFields.innerHTML = `
        <div class="text-end" onclick="removeFormFields(this)">
            <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i> Remove</button>
        </div>
        <div class="form-group">
            <label for="purpose"><b>Purpose</b></label>
            <textarea name="purpose[]" class="form-control" cols="30" rows="3" required></textarea>
        </div>
        <div class="form-group py-3">
            <label for="amount"><b>Amount</b></label>
            <input type="number" name="amount[]" class="form-control" placeholder="Enter amount" step="0.1" required>
        </div>
    `;

            container.appendChild(newFields);
        }

        function removeFormFields(button) {
            button.parentElement.remove();
        }
    </script>
@endsection
