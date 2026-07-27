<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <title>Invoice {{ $data->auto_serial }}</title>

    <style>
        {!! $css !!}
    </style>

</head>

<body>

    <div class="invoice">

        <div class="header">

            <div class="company">

                <h2>{{ $data->company->company_name ?? 'Company Name' }}</h2>

                <p>{{ $data->company->address ?? '' }}</p>

                <p>
                    Phone :
                    {{ $data->company->phone ?? '' }}
                </p>

                <p>
                    Email :
                    {{ $data->company->email ?? '' }}
                </p>

            </div>

            <div class="invoice-info">

                <p><strong>Customer Name :</strong></p>
                <p>{{ $data->customer->name }}</p>

                <br>

                <p><strong>Customer Phone :</strong></p>
                <p>{{ $data->customer->phone }}</p>

                <br>

                <p><strong>Customer Address :</strong></p>
                <p>{{ $data->customer->address }}</p>

                <br>

            </div>

            <div class="clear"></div>

        </div>

        <div class="invoice-title">

            INVOICE

        </div>

        <div class="clear"></div>

        <table class="items-table">

            <thead>

                <tr>

                    <th>#</th>

                    <th>Item</th>

                    <th>Unit</th>

                    <th>Quantity</th>

                    <th>Price</th>

                    <th>Total</th>

                </tr>

            </thead>

            <tbody>

                @foreach ($details as $key => $item)
                    <tr>

                        <td>{{ $key + 1 }}</td>

                        <td style="direction:rtl">{{ $item->item_name }}</td>

                        <td>{{ $item->unit_name }}</td>

                        <td>{{ $item->quantity * 1 }}</td>

                        <td>{{ $item->unit_price / 100 }}</td>

                        <td>{{ $item->total_price / 100 }}</td>

                    </tr>
                @endforeach

            </tbody>

        </table>

        <div class="summary">

            <table>

                <tr>

                    <td>Sub Total</td>

                    <td>

                        {{ $data->total_before_discount }}

                    </td>

                </tr>

                <tr>

                    <td>

                        Tax Rate

                    </td>

                    <td>

                        {{ $data->tax_percent }} %

                    </td>

                </tr>

                <tr>

                    <td>

                        Discount Rate

                    </td>

                    <td>

                        {{ $data->discount_percent }} %

                    </td>

                </tr>



                <tr class="total-row">

                    <td>

                        Total

                    </td>

                    <td>

                        {{ $data->total_cost / 100 }}

                    </td>

                </tr>

                <tr>

                    <td>

                        Paid

                    </td>

                    <td>

                        {{ $data->what_paid / 100 }}

                    </td>

                </tr>

                <tr>

                    <td>

                        Remaining

                    </td>

                    <td>

                        {{ $data->what_remain / 100 }}

                    </td>

                </tr>

            </table>

        </div>

        <div class="clear"></div>

        <div class="notes">

            <h4>

                Notes

            </h4>

            <p>

                {{ $data->notes }}

            </p>

        </div>

        <div class="footer">

            Thank you for your business.

        </div>

    </div>

</body>

</html>
