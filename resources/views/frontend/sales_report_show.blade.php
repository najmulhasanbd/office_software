<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&display=swap');
    </style>
    <style>
        .invoice_btn button {
            border: 0;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .invoice_btn button:first-child {
            background: #157c42;
            color: #fff;
        }

        .invoice_btn button:last-child {
            background: #0f75bc;
        }

        .invoice_btn button a {
            color: #fff;
        }

        * {
            margin: 0;
            padding: 0;
            outline: none;
            box-sizing: border-box;
            font-size: 14px;
            font-family: 'Roboto Slab', serif;
        }

        a {
            text-decoration: none
        }

        .page {
            background-color: white;
            display: block;
            margin: 0 auto;
            position: relative;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
        }

        .page[size="A4"] {
            width: 21cm;
            height: 29.7cm;
            position: relative;
        }

        .invoice__body h1 {
            background: #0F75BC;
            color: #fff;
            padding: 10px 20px;
            font-size: 30px;
            text-align: center;
            line-height: 1;
            display: inline-block;
            position: relative;
            margin-bottom: 30px;
            left: 50%;
            transform: translate(-50%);
            border-radius: 5px;
        }

        .invoice__body {
            padding-top: 170px;
            padding-left: 50px;
            padding-right: 50px;
        }



        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #848484;
        }

        table,
        td,
        th {
            border: 2px solid #848484;
            padding: 5px 10px;
            font-weight: 500;
        }


        .signature {
            position: absolute;
            top: 85%;
            right: 50px;
        }

        .signature h2 {
            border-top: 2px solid #000;
            font-size: 18px;
        }

        @media print {

            .item__amount table tbody tr td:last-child,
            .item__amount table tbody tr th:last-child {
                text-align: right;
            }

            .dfdkfdkl li {
                text-align: end;
                width: 100%
            }
        }


        fieldset span {
            padding: 10px;
            display: block;
            font-size: 16px;
            font-weight: 500;
        }

        fieldset legend {
            font-weight: 800;
            font-size: 14px;
        }

        fieldset {
            width: 100%;
            position: relative;
            left: 0;
            top: 15%;
        }
    </style>
</head>

<body>
    <div style="display: flex;align-items:center;justify-content:center;gap:10px;margin:30px 0" class="invoice_btn">
        <button onclick="invoiceFunction('invoice_print')">Print
            <i class="fa fa-print"></i></button>
        <a href="{{ route('sales.list') }}" class="btn btn-sm"
            style="background: #0F75BC;color: #fff;padding: 10px 20px;border-radius: 5px;">Back</a>
    </div>
    <div id="invoice_print">
        <div class="my-page page" size="A4"
            style="background-image: url('{{ asset('frontend/invoice.jpg') }}'); background-position: center; background-size: cover; background-repeat: no-repeat;">
            <div class="invoice__body">
                <h1>Invoice</h1>

                <div class="customer__details" style="margin-bottom: 70px;margin-left:10px">
                    <div class="cus__info__left" style="width:50%;float: left;">
                        <h6><strong>Name: </strong>{{ ucfirst($salesDetails->name) }}</h6>
                        <h6><strong>Phone: </strong>{{ $salesDetails->phone }}</h6>
                        <h6><strong>Address: </strong>{{ $salesDetails->address }}</h6>
                    </div>
                    <div class="cus__info__left" style="width:50%;float: left;">
                        <div style="margin-left:140px">
                            <h6 style="margin-bottom: 5px"><strong>Invoice No: </strong>{{ $salesDetails->invoice_id }}
                            </h6>
                            <h6><strong>Date: </strong>{{ $salesDetails->created_at->format('d M Y') }}</h6>
                        </div>
                    </div>
                </div>
                <div class="item__table">
                    <table style="width:100%">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 50px">SL</th>
                                    <th>Purpose</th>
                                    <th style="width: 150px">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($decodedPurpose as $key => $purpose)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $purpose }}</td>
                                        <td style="text-align: center">৳ {{ number_format($decodedAmount[$key], 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="2" style="text-align: end">Total Amount</th>
                                    <td style="text-align: center">৳ {{ number_format($totalAmount, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </table>
                </div>
                @php
                    function numberToWords($number)
                    {
                        $words = [
                            0 => '',
                            1 => 'one',
                            2 => 'two',
                            3 => 'three',
                            4 => 'four',
                            5 => 'five',
                            6 => 'six',
                            7 => 'seven',
                            8 => 'eight',
                            9 => 'nine',
                            10 => 'ten',
                            11 => 'eleven',
                            12 => 'twelve',
                            13 => 'thirteen',
                            14 => 'fourteen',
                            15 => 'fifteen',
                            16 => 'sixteen',
                            17 => 'seventeen',
                            18 => 'eighteen',
                            19 => 'nineteen',
                            20 => 'twenty',
                            30 => 'thirty',
                            40 => 'forty',
                            50 => 'fifty',
                            60 => 'sixty',
                            70 => 'seventy',
                            80 => 'eighty',
                            90 => 'ninety',
                        ];

                        if ($number < 21) {
                            return $words[$number];
                        } elseif ($number < 100) {
                            return $words[$number - ($number % 10)] . ' ' . $words[$number % 10];
                        } elseif ($number < 1000) {
                            return $words[(int) ($number / 100)] . ' hundred ' . numberToWords($number % 100);
                        } elseif ($number < 1000000) {
                            return numberToWords((int) ($number / 1000)) . ' thousand ' . numberToWords($number % 1000);
                        }

                        return (string) $number; // Fallback for numbers over 999999
                    }

                    $totalAmountInWords = ucfirst(numberToWords($totalAmount)) . ' taka only';
                @endphp

                <fieldset style="margin-top: 50px">
                    <legend>Grand Total In Words</legend>
                    <span>{{ $totalAmountInWords }}</span>
                </fieldset>
                <div class="signature">
                    <h2>Authorized Signature</h2>
                </div>
            </div>
        </div>
    </div>

    <script>
        function invoiceFunction(el) {
            let restorepage = document.body.innerHTML;
            let printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
            location.reload()
        }
    </script>
</body>

</html>
