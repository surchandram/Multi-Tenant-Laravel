<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>{{ $model['project']['id'] }} - {{ $model['project']['name'] }}</title>

    <style>
        body {
            background: #fff none;
            font-family: DejaVu Sans, 'sans-serif';
            font-size: 12px;
        }

        h2 {
            font-size: 28px;
            color: #444;
        }

        .container {
            padding-top: 30px;
        }

        .invoice-head td {
            padding: 0 8px;
        }

        .table th {
            vertical-align: bottom;
            font-weight: bold;
            padding: 8px;
            line-height: 14px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table tr.row td {
            border-bottom: 1px solid #ddd;
        }

        .table td {
            padding: 8px;
            line-height: 14px;
            text-align: left;
            vertical-align: top;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

<div class="container">
    <table style="margin-left: auto; margin-right: auto;" width="550">
        <tr>
            <td width="160">
                <!-- Account Details -->
                <strong>{{ $vendor ?? $model['company']['name'] }}</strong><br>

                @if ($address = $model['company']['address'])
                    @if ($address['address_1'])
                        {{ $address['address_1'] }}<br>
                    @endif

                    @if ($address['address_2'])
                        {{ $address['address_2'] }}<br>
                    @endif

                    @if ($address['city'])
                        {{ $address['city'] }}<br>
                    @endif

                    @if ($address['state'] || $address['postal_code'])
                        {{ implode(' ', [$address['state'], $address['postal_code']]) }}<br>
                    @endif

                    @if ($address['country'])
                        {{ $address['country']['name'] }}<br>
                    @endif
                @endif

                @isset($model['company']['phone'])
                    {{ $model['company']['phone'] }}<br>
                @endisset

                @isset($model['company']['email'])
                    {{ $model['company']['email'] }}<br>
                @endisset

                @isset($model['company']['license_no'])
                    <strong>License #</strong> {{ $model['company']['license_no'] }}<br>
                @endisset

                @isset($model['company']['tax_id'])
                    <strong>Tax ID</strong> {{ $model['company']['tax_id'] }}<br>
                @endisset

                @isset($url)
                    <a href="{{ $url }}">{{ $url }}</a><br>
                @endisset
            </td>

            <!-- Company Name / Company Image -->
            <td align="right">
                <strong>{{ $model['company']['name'] }}</strong><br>
            </td>
        </tr>

        <!-- Project Info -->
        <tr valign="top">
            <td style="font-size:9px;">
                <br>
                <h1 style="font-size: 28px; color: #444;">
                    Project # {{ $model['project']['id'] }}
                </h1><br><br>

                <!-- Call Report Table -->
                <table width="100%" class="table" border="0">
                    <tr>
                        <td>
                            <span style="font-size: 18px; color: #333;">
                                Call Report
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th align="left">Date Contacted</th>
                    </tr>
                    <tr>
                        <td align="right" colspan="2">
                            {{ $model['project']['contacted_at'] }}
                        </td>
                    </tr>
                    <tr>
                        <th align="left">Date of Loss</th>
                    </tr>
                    <tr>
                        <td align="right" colspan="2">
                            {{ $model['project']['loss_occurred_at'] }}
                        </td>
                    </tr>
                    <tr>
                        <th align="left">Work Schedule</th>
                    </tr>
                    <tr>
                        <td align="right" colspan="2">
                            {{ $model['project']['starts_at'] }} - {{ $model['project']['ends_at'] }}
                        </td>
                    </tr>
                    <tr>
                        <th align="left">Project Type</th>
                    </tr>
                    <tr>
                        <td align="right" colspan="2">
                            {{ $model['project']['type']['name'] }}
                        </td>
                    </tr>
                    <tr>
                        <th align="left">Point of Loss</th>
                    </tr>
                    <tr>
                        <td align="right" colspan="2">
                            {{ $model['project']['point_of_loss'] }}
                        </td>
                    </tr>
                    <tr>
                        <th align="left">Category</th>
                    </tr>
                    <tr>
                        <td align="right" colspan="2">
                            {{ $model['project']['category']['name'] }}
                        </td>
                    </tr>
                    <tr>
                        <th align="left">Class</th>
                    </tr>
                    <tr>
                        <td align="right" colspan="2">
                            {{ $model['project']['class']['name'] }}
                        </td>
                    </tr>
                </table>
            </td>

            <!-- Right Side -->
            <td>
                <br><br>
                <!-- Property Details -->
                <table width="100%" border="0" class="table">
                    <tr>
                        <td colspan="2">
                            <span style="font-size: 22px; color: #333;">
                                Property
                            </span>
                            <br><br>

                            @if ($address = $model['project_address'])
                                @if ($address['address_1'])
                                    {{ $address['address_1'] }}<br>
                                @endif
                                @if ($address['address_2'])
                                    {{ $address['address_2'] }}<br>
                                @endif
                                @if ($address['city'])
                                    {{ $address['city'] }}<br>
                                @endif
                                @if ($address['state'] || $address['postal_code'])
                                    {{ implode(' ', [$address['state'], $address['postal_code']]) }}<br>
                                @endif
                                @if ($address['country'])
                                    {{ $address['country']['name'] }}<br>
                                @endif
                            @endif
                        </td>
                    </tr>
                </table>

                <br><br>

                <!-- Owner Details -->
                <table width="100%" border="0" class="table">
                    <tr>
                        <td colspan="2">
                            <span style="font-size: 22px; color: #333;">
                                Owner
                            </span>
                            <br><br>

                            {{ $model['project']['owner']['name'] }}<br>

                            @if ($address = $model['project']['address'])
                                @if ($address['address_1'])
                                    {{ $address['address_1'] }}<br>
                                @endif
                                @if ($address['address_2'])
                                    {{ $address['address_2'] }}<br>
                                @endif
                                @if ($address['city'])
                                    {{ $address['city'] }}<br>
                                @endif
                                @if ($address['state'] || $address['postal_code'])
                                    {{ implode(' ', [$address['state'], $address['postal_code']]) }}<br>
                                @endif
                                @if ($address['country'])
                                    {{ $address['country']['name'] }}<br>
                                @endif
                            @endif

                            @if ($model['project']['owner']['phone'])
                                {{ $model['project']['owner']['phone'] }}<br>
                            @endif

                            @if ($model['project']['owner']['name'])
                                {{ $model['project']['owner']['email'] }}<br>
                            @endif
                        </td>
                    </tr>
                </table>
                <!-- Invoice Table -->
                {{-- <table width="100%" class="table" border="0">
                    <tr>
                        <th align="left">Description</th>
                        <th align="right">Date</th>

                        @if ($invoice->hasTax())
                            <th align="right">Tax</th>
                        @endif

                        <th align="right">Amount</th>
                    </tr>

                    <!-- Display The Invoice Items -->
                    @foreach ($invoice->invoiceItems() as $item)
                        <tr class="row">
                            <td colspan="2">{{ $item->description }}</td>

                            @if ($invoice->hasTax())
                                <td>
                                    @if ($inclusiveTaxPercentage = $item->inclusiveTaxPercentage())
                                        {{ $inclusiveTaxPercentage }}% incl.
                                    @endif

                                    @if ($item->hasBothInclusiveAndExclusiveTax())
                                        +
                                    @endif

                                    @if ($exclusiveTaxPercentage = $item->exclusiveTaxPercentage())
                                        {{ $exclusiveTaxPercentage }}%
                                    @endif
                                </td>
                            @endif

                            <td>{{ $item->total() }}</td>
                        </tr>
                    @endforeach

                    <!-- Display The Subscriptions -->
                    @foreach ($invoice->subscriptions() as $subscription)
                        <tr class="row">
                            <td>{{ $subscription->description }}</td>
                            <td>
                                {{ $subscription->startDateAsCarbon()->toFormattedDateString() }} -
                                {{ $subscription->endDateAsCarbon()->toFormattedDateString() }}
                            </td>

                            @if ($invoice->hasTax())
                                <td>
                                    @if ($inclusiveTaxPercentage = $subscription->inclusiveTaxPercentage())
                                        {{ $inclusiveTaxPercentage }}% incl.
                                    @endif

                                    @if ($subscription->hasBothInclusiveAndExclusiveTax())
                                        +
                                    @endif

                                    @if ($exclusiveTaxPercentage = $subscription->exclusiveTaxPercentage())
                                        {{ $exclusiveTaxPercentage }}%
                                    @endif
                                </td>
                            @endif

                            <td>{{ $subscription->total() }}</td>
                        </tr>
                    @endforeach

                    <!-- Display The Subtotal -->
                    @if ($invoice->hasDiscount() || $invoice->hasTax() || $invoice->hasStartingBalance())
                        <tr>
                            <td colspan="{{ $invoice->hasTax() ? 3 : 2 }}" style="text-align: right;">Subtotal</td>
                            <td>{{ $invoice->subtotal() }}</td>
                        </tr>
                    @endif

                    <!-- Display The Discount -->
                    @if ($invoice->hasDiscount())
                        @foreach ($invoice->discounts() as $discount)
                            @php($coupon = $discount->coupon())

                            <tr>
                                <td colspan="{{ $invoice->hasTax() ? 3 : 2 }}" style="text-align: right;">
                                    @if ($coupon->isPercentage())
                                        {{ $coupon->name() }} ({{ $coupon->percentOff() }}% Off)
                                    @else
                                        {{ $coupon->name() }} ({{ $coupon->amountOff() }} Off)
                                    @endif
                                </td>

                                <td>-{{ $invoice->discountFor($discount) }}</td>
                            </tr>
                        @endforeach
                    @endif

                    <!-- Display The Taxes -->
                    @unless ($invoice->isNotTaxExempt())
                        <tr>
                            <td colspan="{{ $invoice->hasTax() ? 3 : 2 }}" style="text-align: right;">
                                @if ($invoice->isTaxExempt())
                                    Tax is exempted
                                @else
                                    Tax to be paid on reverse charge basis
                                @endif
                            </td>
                            <td></td>
                        </tr>
                    @else
                        @foreach ($invoice->taxes() as $tax)
                            <tr>
                                <td colspan="3" style="text-align: right;">
                                    {{ $tax->display_name }} {{ $tax->jurisdiction ? ' - '.$tax->jurisdiction : '' }}
                                    ({{ $tax->percentage }}%{{ $tax->isInclusive() ? ' incl.' : '' }})
                                </td>
                                <td>{{ $tax->amount() }}</td>
                            </tr>
                        @endforeach
                    @endunless

                    <!-- Display The Final Total -->
                    <tr>
                        <td colspan="{{ $invoice->hasTax() ? 3 : 2 }}" style="text-align: right;">
                            Total
                        </td>
                        <td>
                            {{ $invoice->realTotal() }}
                        </td>
                    </tr>

                    <!-- Applied Balance -->
                    @if ($invoice->rawAppliedBalance() > 0)
                        <tr>
                            <td colspan="{{ $invoice->hasTax() ? 3 : 2 }}" style="text-align: right;">
                                Applied balance
                            </td>
                            <td>{{ $invoice->appliedBalance() }}</td>
                        </tr>
                    @endif

                    <!-- Display The Amount Due -->
                    <tr>
                        <td colspan="{{ $invoice->hasTax() ? 3 : 2 }}" style="text-align: right;">
                            <strong>Amount due</strong>
                        </td>
                        <td>
                            <strong>{{ $invoice->amountDue() }}</strong>
                        </td>
                    </tr>
                </table>
            </td> --}}
        </tr>

        <!-- Insurance Table -->
        @if ($insurance = $model['project']['insurance'])
            <tr valign="top">
                <td style="font-size:9px;">
                    <br>
                    <h1 style="font-size: 28px; color: #444;">
                        Project # {{ $model['project']['id'] }}
                    </h1><br><br>
                </td>

                <td>
                    <table width="100%" class="table" border="0">
                        <tr>
                            <td colspan="2">
                                <span style="font-size: 18px; color: #333;">
                                    Insurance
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th align="left" width="120">Claim #</th>
                            <th align="right">{{ $insurance['claim_no'] }}</th>
                        </tr>
                        <tr>
                            <th align="left" width="120">Policy #</th>
                            <th align="right">{{ $insurance['policy_no'] }}</th>
                        </tr>
                        <tr>
                            <th align="left" width="120">Deductible</th>
                            <th align="right">{{ $insurance['formatted_deductible'] }}</th>
                        </tr>
                    </table>
                    <br>

                    <table width="100%" class="table" border="0">
                            <tr>
                            <th align="left" width="120">Company</th>
                            <th align="right">{{ $insurance['company']['name'] }}</th>
                        </tr>
                        <tr>
                            <th align="left" width="120">Phone</th>
                            <th align="right">{{ $insurance['company']['phone'] }}</th>
                        </tr>
                        <tr>
                            <th align="left" width="120">Email</th>
                            <th align="right">{{ $insurance['company']['email'] }}</th>
                        </tr>
                    </table>

                    @if($agent = $insurance['agent'])
                        <br>
                        <table width="100%" class="table" border="0">
                            <tr>
                                <th align="left" width="120">Agent</th>
                                <th align="right">{{ $agent['name'] }}</th>
                            </tr>
                            <tr>
                                <th align="left" width="120">Phone</th>
                                <th align="right">{{ $agent['phone'] }}</th>
                            </tr>
                            <tr>
                                <th align="left" width="120">Email</th>
                                <th align="right">{{ $agent['email'] }}</th>
                            </tr>
                        </table>
                    @endif

                    <!-- Insurance Adjuster -->
                    @if($adjuster = $insurance['adjuster'])
                        <br>
                        <table width="100%" class="table" border="0">
                            <tr>
                                <th align="left" width="120">Adjuster</th>
                                <th align="right">{{ $adjuster['name'] }}</th>
                            </tr>
                            <tr>
                                <th align="left" width="120">Phone</th>
                                <th align="right">{{ $adjuster['phone'] }}</th>
                            </tr>
                            <tr>
                                <th align="left" width="120">Email</th>
                                <th align="right">{{ $adjuster['email'] }}</th>
                            </tr>
                        </table>
                    @endif
                </td>
            </tr>
        @endif

        <!-- Moisture Map -->
        @if($moistureMap = $model['moisture_map'])
            <tr>
                <td colspan="2">
                    <div class="page-break"></div>

                    <table>
                        <tr>
                            <td>
                                <h2>Moisture Map</h2>
                            </td>
                        </tr>
                    </table>

                    @foreach ($moistureMap as $affectedArea => $affectedAreaStructures)
                        <br><br>
                        <h3>{{ $affectedArea }}</h4>

                        <table class="table" style="width: 100%; background-color: #f3f3f3">
                            @foreach ($affectedAreaStructures as $structure => $structureMaterials)
                                <tr>
                                    <td colspan="2">
                                        <h5>{{ $structure }}</h5>
                                    </td>
                                </tr>

                                @foreach ($structureMaterials as $materialData)
                                    <tr style="background-color: #f7f7f7">
                                        <td width="80">{{ $materialData['material'] }}</td>

                                        <td>
                                            <table class="table" style="width: 100%">
                                                @foreach ($materialData['readings'] as $date => $reading)
                                                    <tr>
                                                        <td>{{ $date }}</td>
                                                        <td>{{ $reading }}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </table>
                    @endforeach
                </td>
            </tr>
        @endif

        <!-- Psychrometric Report -->
        @if($psychrometricReport = $model['psychrometric_report'])
            <tr>
                <td colspan="2">
                    <div class="page-break"></div>

                    <table>
                        <tr>
                            <td>
                                <h2>Psychrometric Report</h2>
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>

            @foreach (($affectedAreaChunks = array_chunk($psychrometricReport, 3, true)) as $i => $chunk)
                <tr>
                    <td colspan="2">
                        @foreach ($chunk as $affectedArea => $groupedMeasurePoints)
                            <br><br>
                            <h3>{{ $affectedArea }}</h4>

                            @foreach (($dateChunks = array_chunk($groupedMeasurePoints, 3, true)) as $index => $dateChunk)
                                @foreach ($dateChunk as $recordedDate => $measurePointData)
                                    <br>
                                    <table class="table" style="width: 100%; background-color: #f3f3f3">
                                        <tr valign="top">
                                            <th scope="row" width="80">
                                                {{ $recordedDate }}
                                            </th>
                                            @foreach ($model['psychrometry_measure_points'] as $measure_point)
                                                <th scope="row">{{ $measure_point }}</th>
                                            @endforeach
                                        </tr>
                                        @foreach ($measurePointData as $measurePoint => $readingData)
                                            <tr style="background-color: #f7f7f7">
                                                <td width="80">{{ $measurePoint }}</td>
                                                @foreach ($model['psychrometry_measure_points'] as $key => $label)
                                                    <td>{{ $readingData[$key] ?? '-' }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </table>
                                @endforeach

                                @if (($index + 1) < count($dateChunks))
                                    <div class="page-break"></div>
                                @endif
                            @endforeach

                            @if (($i + 1) <= count($affectedAreaChunks))
                                <div class="page-break"></div>
                            @endif
                        @endforeach
                    </td>
                </tr>
            @endforeach
        @endif
    </table>
</div>

</body>
</html>
