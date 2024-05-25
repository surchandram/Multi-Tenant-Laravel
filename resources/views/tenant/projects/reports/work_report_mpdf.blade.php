<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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

        @page {
            header: page-header;
            footer: page-footer;
        }

        @page noheader {
            odd-header-name: _blank;
            odd-footer-name: _blank;
        }

        .header,
        .footer {
            padding: 2em 0;
            margin: 2em 0;
            font-weight: bold;
            text-align: center;
            color: #334155;
            background-color: #f8fafc;
        }

        div.noheader {
            page: noheader;
        }

        .content-simple p {
            font-size: 14px;
        }

        .content-document {
            padding: 8px 8px;
            font-size: 16px;
            line-height: 24px;
        }

        .content-log {
            padding: 8px 8px;
            font-size: 16px;
            line-height: 24px;
            background-color: whitesmoke;
        }

        p.content-header {
            font-size: 14px;
            color: #475569;
        }

        .clear-page {
            margin-top: 3rem;
        }
    </style>
</head>

<body>
    <pageheader name="headerZero" content-center></pageheader>
    <htmlpageheader name="page-header">
        <div class="header">{{ $model['company']['name'] }}</div>
    </htmlpageheader>

    <htmlpagefooter name="page-footer">
        <p class="footer">
            Page {PAGENO} | {{ $model['company']['name'] }} | Powered by {{ config('app.name') }}
        </p>
    </htmlpagefooter>

    <div class="container">
        <h2>
            <bookmark content="Overview" />
            &nbsp;
        </h2>

        <table style="margin-left: auto; margin-right: auto;" width="100%">
            <tbody>
                <tr>
                    <td width="240">
                        <!-- Account Details -->
                        <p><strong>{{ $vendor ?? $model['company']['name'] }}</strong></p><br>

                        @if ($address = $model['company']['address'])
                            <p>
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
                            </p><br>
                        @endif

                        @isset($model['company']['phone'])
                            <p>{{ $model['company']['phone'] }}</p><br>
                        @endisset

                        @isset($model['company']['email'])
                            <p>{{ $model['company']['email'] }}</p><br>
                        @endisset

                        @isset($model['company']['license_no'])
                            <p><strong>License #</strong> {{ $model['company']['license_no'] }}</p><br>
                        @endisset

                        @isset($model['company']['tax_id'])
                            <p><strong>Tax ID</strong> {{ $model['company']['tax_id'] }}</p><br>
                        @endisset

                        @isset($url)
                            <a href="{{ $url }}">{{ $url }}</a><br>
                        @endisset
                    </td>

                    <!-- Company Name / Company Image -->
                    <td align="right">
                        <img style="height: 200px" src="{{ $model['company']['logo'] }}" alt="{{ $model['company']['name'] }}">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <br><br>
                        <h1 style="font-size: 28px; color: #444;">
                            Project # {{ $model['project']['id'] }}
                        </h1>
                        <br><br>
                    </td>
                </tr>

                <!-- Project Info -->
                <tr>
                    <td style="font-size:14px;" width="240">
                        <!-- Summary -->
                        <div>
                            <p>
                                <span style="font-size: 14px; color: #333;">
                                    Summary
                                </span>
                            </p><br>

                            <div>
                                <h5>
                                    Date Contacted
                                </h5>
                                <p>
                                    {{ $model['project']['contacted_at'] }}
                                </p>
                            </div><br>

                            <div>
                                <h5>
                                    Date of Loss
                                </h5>
                                <p>
                                    {{ $model['project']['loss_occurred_at'] }}
                                </p>
                            </div><br>

                            <div>
                                <h5>
                                    Work Schedule
                                </h5>
                                <p>
                                    {{ $model['project']['starts_at'] }} - {{ $model['project']['ends_at'] }}
                                </p>
                            </div><br>

                            <div>
                                <h5>
                                    Project Type
                                </h5>
                                <p>
                                    {{ $model['project']['type']['name'] }}
                                </p>
                            </div><br>

                            <div>
                                <h5>
                                    Point of Loss
                                </h5>
                                <p>
                                    {{ $model['project']['point_of_loss'] }}
                                </p>
                            </div><br>

                            <div>
                                <h5>
                                    Category
                                </h5>
                                <p>
                                    {{ $model['project']['category']['name'] }}
                                </p>
                            </div><br>

                            <div>
                                <h5>
                                    Class
                                </h5>
                                <p>
                                    {{ $model['project']['class']['name'] }}
                                </p>
                            </div>
                        </div>
                        <!-- END Summary -->
                    </td>

                    <!-- Right Side -->
                    <td>
                        <!-- Property Details -->
                        <div>
                            <p>
                                <span style="font-size: 22px; color: #333;">
                                    {{ __('tenant.labels.property') }}
                                </span>
                            </p><br>

                            <p>
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
                            </p>
                        </div>
                        <!-- END Property Details -->

                        <br><br>

                        <!-- Owner Details -->
                        <div>
                            <p>
                                <span style="font-size: 22px; color: #333;">
                                    Owner
                                </span>
                            </p><br>

                            <p>
                                <strong>{{ $model['project']['owner']['name'] }}</strong><br>

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
                            </p>
                        </div>
                        <!-- END Owner Details -->
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Insurance Table -->
        @if ($model['visible_data']['insurance_summary'] && ($insurance = $model['project']['insurance']))
            <pagebreak />

            <table class="table" style="margin-top: 3rem;">
                <tbody>
                    <tr valign="top">
                        <td>
                            <h2>
                                <bookmark content="Insurance" />
                                <span style="color: #333;">
                                    {{ __('tenant.labels.insurance') }}
                                </span>
                            </h2><br><br>

                            <p style="font-size: 14px; color: #444;">
                                Insurance details for:<br><br>
                                <strong>Project # {{ $model['project']['id'] }}</strong>
                            </p>
                        </td>

                        <td>
                            <div>
                                <div class="content-simple">
                                    <p class="content-header">{{ __('tenant.labels.claim_no') }}</p><br>
                                    <p>{{ $insurance['claim_no'] }}</p>
                                </div><br>
                                <div class="content-simple">
                                    <p class="content-header">{{ __('tenant.labels.policy_no') }}</p><br>
                                    <p>{{ $insurance['policy_no'] }}</p>
                                </div><br>
                                <div class="content-simple">
                                    <p class="content-header">{{ __('tenant.labels.insurance_deductible') }}</p><br>
                                    <p>{{ $insurance['formatted_deductible'] }}</p>
                                </div><br>
                            </div>

                            <!-- Insurance Company -->
                            @if ($model['visible_data']['insurance_company'] && ($insuranceCompany = $insurance['company']))
                                <br>
                                <br>
                                <div>
                                    <div class="content-simple">
                                        <p class="content-header">{{ __('app.labels.company') }}</p><br>
                                        <p>{{ $insuranceCompany['name'] }}</p>
                                    </div><br>
                                    <div class="content-simple">
                                        <p class="content-header">{{ __('app.labels.phone') }}</p><br>
                                        <p>{{ $insuranceCompany['phone'] }}</p>
                                    </div><br>
                                    <div class="content-simple">
                                        <p class="content-header">{{ __('app.labels.email') }}</p><br>
                                        <p>{{ $insuranceCompany['email'] }}</p>
                                    </div><br>
                                </div>
                            @endif
                            <!-- END Insurance Company -->

                            <!-- Insurance Agent -->
                            @if ($model['visible_data']['insurance_agent'] && ($agent = $insurance['agent']))
                                <br>
                                <br>
                                <div>
                                    <div class="content-simple">
                                        <p class="content-header">{{ __('tenant.labels.insurance_agent') }}</p><br>
                                        <p>{{ $agent['name'] }}</p>
                                    </div><br>
                                    <div class="content-simple">
                                        <p class="content-header">{{ __('app.labels.phone') }}</p><br>
                                        <p>{{ $agent['phone'] }}</p>
                                    </div><br>
                                    <div class="content-simple">
                                        <p class="content-header">{{ __('app.labels.email') }}</p><br>
                                        <p>{{ $agent['email'] }}</p>
                                    </div><br>
                                </div>
                            @endif
                            <!-- END Insurance Agent -->

                            <!-- Insurance Adjuster -->
                            @if ($model['visible_data']['insurance_adjuster'] && ($adjuster = $insurance['adjuster']))
                                <br>
                                <br>
                                <div>
                                    <div class="content-simple">
                                        <p class="content-header">{{ __('tenant.labels.insurance_adjuster') }}</p><br>
                                        <p>{{ $adjuster['name'] }}</p>
                                    </div><br>
                                    <div class="content-simple">
                                        <p class="content-header">{{ __('app.labels.phone') }}</p><br>
                                        <p>{{ $adjuster['phone'] }}</p>
                                    </div><br>
                                    <div class="content-simple">
                                        <p class="content-header">{{ __('app.labels.email') }}</p><br>
                                        <p>{{ $adjuster['email'] }}</p>
                                    </div><br>
                                </div>
                            @endif
                            <!-- END Insurance Adjuster -->
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif
        <!-- END Insurance -->

        <!-- Documents -->
        @if ($model['visible_data']['documents'] && ($documents = $model['project']['documents']))
            <pagebreak />

            <h2>
                <bookmark content="Documents" />
                {{ __('tenant.labels.documents') }}
            </h2>

            @foreach ($documents as $document)
                <h3>
                    <bookmark content="{{ $document['type']['name'] }}" level="1" />
                    {{ $document['title'] }}
                </h3><br>

                <div class="content-document">{!! $document['body'] !!}</div>

                @if ($document['signature'])
                    <img src="{{ $document['signature'] }}" alt="">
                @endif


                @if (!$loop->last)
                    <pagebreak />
                @endif
            @endforeach
        @endif
        <!-- END Documents -->

        <!-- Daily Log -->
        @if ($model['visible_data']['logs'] && ($logs = $model['logs']))
            <pagebreak />

            <h2>
                <bookmark content="Daily Log" />
                {{ __('tenant.labels.daily_logs') }}
            </h2>

            @foreach ($logs as $date => $dateLogs)
                <h3>{{ $date }}</h3><br>

                @foreach ($dateLogs as $log)
                    <div class="content-log">{!! $log['body'] !!}</div><br>
                @endforeach
                <br>
            @endforeach
        @endif
        <!-- END Daily Log -->

        <!-- Moisture Map -->
        @if ($model['visible_data']['moisture_map'] && ($moistureMap = $model['moisture_map']))
            <pagebreak />

            <h2>
                <bookmark content="Moisture Map" />
                {{ __('tenant.labels.moisture_map') }}
            </h2>

            @foreach ($moistureMap as $affectedArea => $affectedAreaStructures)
                <h4>
                    <bookmark content="{{ $affectedArea }}" level="1" />
                    {{ $affectedArea }}
                </h4><br>

                @foreach ($affectedAreaStructures as $structure => $structureMaterials)
                    <table class="table" style="width: 100%; background-color: #f3f3f3">
                        <tr>
                            <td colspan="2">
                                <h5>
                                    <bookmark content="{{ $structure }}" level="2" />
                                    {{ $structure }}
                                </h5>
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
                    </table><br><br><br>
                @endforeach
            @endforeach
        @endif
        <!-- END Moisture Map -->

        <!-- Psychrometric Report -->
        @if ($model['visible_data']['psychrometric_report'] && ($psychrometricReport = $model['psychrometric_report']))
            <pagebreak />

            <h2>
                <bookmark content="Psychrometric Report" />
                {{ __('tenant.labels.psychrometric_report') }}
            </h2>

            @foreach ($affectedAreaChunks = array_chunk($psychrometricReport, 3, true) as $i => $chunk)
                <div>
                    @foreach ($chunk as $affectedArea => $groupedMeasurePoints)
                        <h4>
                            <bookmark content="{{ $affectedArea }}" level="1" />
                            {{ $affectedArea }}
                        </h4><br>

                        <!-- Affected Area's Inspection Date Chunks -->
                        <div>
                            @foreach ($dateChunks = array_chunk($groupedMeasurePoints, 3, true) as $index => $dateChunk)
                                <!-- Inspection Date Readings Chunks -->
                                <div>
                                    @foreach ($dateChunk as $recordedDate => $measurePointData)
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
                                        </table><br>
                                    @endforeach

                                    @if ($index + 1 < count($dateChunks))
                                        <pagebreak />
                                    @endif
                                </div>
                                <!-- END Inspection Date Readings Chunks -->
                            @endforeach
                        </div>
                        <!-- END Affected Area's Inspection Date Chunks -->

                        <pagebreak />
                    @endforeach
                </div>
            @endforeach
        @endif
        <!-- END Psychrometric Report -->
    </div>

</body>

</html>
