<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="{{url('images/logo_2.png')}}" />
    <title>{{$general_setting->site_title}} | Challan Invoice</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    @if(!config('database.connections.saleprosaas_landlord'))
        <link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css">
    @else
    <link rel="stylesheet" href="<?php echo asset('../../vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css">
    @endif

    <style type="text/css">
        * {
            font-size: 11px;
            line-height: 22px;
            font-family: 'Ubuntu', sans-serif;

        }
        .btn {
            padding: 7px 10px;
            text-decoration: none;
            border: none;
            display: block;
            text-align: center;
            margin: 7px;
            cursor:pointer;
        }

        .btn-info {
            background-color: #999;
            color: #FFF;
        }

        .btn-primary {
            background-color: #6449e7;
            color: #FFF;
            width: 100%;
        }


        table {width: 50% !important;}


        .centered {
            text-align: center;
            align-content: center;
        }
        small{font-size:11px;}

        @media print {
            * {
                font-size:17px;
                line-height: 20px;
            }
            td,th {padding: 3px 0;}
            .hidden-print {
                display: none !important;
            }
            @page { margin: 0; } body { margin: 0.5cm; margin-bottom:1.6cm; }
            #rider-copy { page-break-after: always; }
        }
    </style>
  </head>
<body>

<div style="max-width:800px;margin:0 auto">
    <div class="hidden-print">
        <table>
            <tr>
                <td><a href="{{route('challan.index')}}" class="btn btn-info"><i class="fa fa-arrow-left"></i> Back</a> </td>
                <td><button onclick="window.print();" class="btn btn-primary"><i class="fa fa-print"></i> Print</button></td>
            </tr>
        </table>

    </div>

    <div id="office-copy">
        <br><br>
        <h1 class="text-center">DELIVERY CHALLAN</h1>
        <h2 class="text-center">Office Copy</h2><br>
        <p>Reference: DC-{{$challan->reference_no}}</p>
        <p>Date: {{date($general_setting->date_format, strtotime($challan->created_at->toDateString()))}}</p>
        <p>Courier: {{$challan->courier->name.' ['.$challan->courier->phone_number.']'}}</p>
        <?php
            $packing_slip_list = explode(",", $challan->packing_slip_list);
            $amount_list = explode(",", $challan->amount_list);
            $sum = 0;
        ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <!-- <th>PS Reference</th> -->
                    <th>Order Reference</th>
                    <th>Shipping Info</th>
                    <th>Amount</th>
                    <th>Cash</th>
                    <th>Cheque</th>
                    <th>Online Payment</th>
                    <th>Delivery Charge</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
            @foreach($packing_slip_list as $key=>$packing_slip_id)
            <?php
                $packing_slip = \App\Models\PackingSlip::with('sale.customer')->find($packing_slip_id);
                $sum += $amount_list[$key];
                if($packing_slip->sale->shipping_address){
                    $address = $packing_slip->sale->shipping_address;
                    $city = $packing_slip->sale->shipping_city;
                    $phone = $packing_slip->sale->shipping_phone;
                }
                else {
                    $address = $packing_slip->sale->customer->address;
                    $city = $packing_slip->sale->customer->city;
                    $phone = $packing_slip->sale->customer->phone_number;
                }
            ?>
            <tr>
                <td>{{$key+1}}</td>
                <!-- <td>P{{$packing_slip->reference_no}}</td> -->
                <td>{{$packing_slip->sale->reference_no}}</td>
                <td>{{$address}}, {{$city}}<br><strong>{{$phone}}</strong></td>
                <td>{{$amount_list[$key]}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total</th>
                    <th>{{$sum}}</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        <br><br><br>
        <div class="row">
            <div class="col-md-6">
                <hr style="border-top: 2px solid black">
                <p>Rider Signature</p>
            </div>
            <div class="col-md-6">
                <hr style="border-top: 2px solid black">
                <p>Authorized Signature</p>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function auto_print() {
        window.print()
    }
    setTimeout(auto_print, 1000);
</script>

</body>
</html>