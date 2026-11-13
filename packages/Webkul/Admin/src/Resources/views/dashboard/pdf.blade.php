<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html
    lang="{{ $locale = app()->getLocale() }}"
    dir="{{ ($isRTL = in_array($locale, ['fa', 'ar'])) ? 'rtl' : 'ltr' }}"
>
    <head>
        <meta http-equiv="Cache-control" content="no-cache">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        @php
            if ($locale == 'en') {
                $fontFamily = [
                    'regular' => 'DejaVu Sans',
                    'bold'    => 'DejaVu Sans',
                ];
            } else {
                $fontFamily = [
                    'regular' => 'Arial, sans-serif',
                    'bold'    => 'Arial, sans-serif',
                ];
            }

            if (in_array($locale, ['ar', 'fa', 'tr'])) {
                $fontFamily = [
                    'regular' => 'DejaVu Sans',
                    'bold'    => 'DejaVu Sans',
                ];
            }
        @endphp

        <style type="text/css">
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: "{{ $fontFamily['regular'] }}";
            }

            body {
                font-size: 10px;
                color: #1E293B;
                background-color: #FFFFFF;
                line-height: 1.45;
            }

            b, strong, th {
                font-family: "{{ $fontFamily['bold'] }}";
            }

            .page-container {
                padding: 24px 30px;
            }

            /* Signature Gradient Accent Top Bar */
            .brand-accent-bar {
                height: 4px;
                width: 100%;
                background-color: #5A4DB9;
                border-bottom: 2px solid #01C7F4;
                margin-bottom: 18px;
            }

            /* Header Section */
            .header-table {
                width: 100%;
                margin-bottom: 18px;
                border-collapse: collapse;
            }

            .header-table td {
                vertical-align: middle;
            }

            .logo-cell {
                width: 50%;
            }

            .logo-img {
                max-width: 160px;
                max-height: 44px;
                display: block;
                margin-bottom: 6px;
            }

            .brand-subtitle {
                font-size: 10px;
                font-weight: 700;
                color: #5A4DB9;
                text-transform: uppercase;
                letter-spacing: 0.8px;
            }

            .meta-cell {
                width: 50%;
                text-align: right;
            }

            .report-title {
                font-size: 18px;
                font-weight: 700;
                color: #0F172A;
                margin-bottom: 4px;
            }

            .date-badge {
                display: inline-block;
                background-color: #F1F5F9;
                border: 1px solid #CBD5E1;
                border-radius: 4px;
                padding: 3px 8px;
                font-size: 9px;
                font-weight: 700;
                color: #334155;
            }

            .meta-timestamp {
                font-size: 8.5px;
                color: #64748B;
                margin-top: 4px;
            }

            /* KPI Highlights Row */
            .kpi-table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 6px;
                margin-bottom: 16px;
            }

            .kpi-card {
                background-color: #F8FAFC;
                border: 1px solid #E2E8F0;
                border-top: 3px solid #5A4DB9;
                border-radius: 6px;
                padding: 8px 10px;
                text-align: left;
                width: 25%;
            }

            .kpi-card.kpi-won {
                border-top-color: #10B981;
            }

            .kpi-card.kpi-lost {
                border-top-color: #EF4444;
            }

            .kpi-card.kpi-cyan {
                border-top-color: #01C7F4;
            }

            .kpi-label {
                font-size: 8px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: #64748B;
                margin-bottom: 4px;
            }

            .kpi-value {
                font-size: 13px;
                font-weight: 700;
                color: #0F172A;
            }

            .kpi-sub {
                font-size: 8px;
                color: #64748B;
                margin-top: 2px;
            }

            .badge-pos {
                color: #059669;
                font-weight: 700;
            }

            .badge-neg {
                color: #DC2626;
                font-weight: 700;
            }

            /* Section Styling */
            .section {
                margin-bottom: 16px;
            }

            .section-header {
                font-size: 11px;
                font-weight: 700;
                color: #0F172A;
                text-transform: uppercase;
                letter-spacing: 0.4px;
                padding-bottom: 4px;
                margin-bottom: 6px;
                border-bottom: 1.5px solid #E2E8F0;
            }

            .section-header span {
                color: #5A4DB9;
            }

            /* Data Tables */
            .table-container {
                border: 1px solid #E2E8F0;
                border-radius: 5px;
                overflow: hidden;
            }

            table.data-table {
                width: 100%;
                border-collapse: collapse;
                background-color: #FFFFFF;
            }

            table.data-table thead th {
                background-color: #0F172A;
                color: #FFFFFF;
                font-size: 8.5px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.4px;
                padding: 6px 10px;
                border: none;
                text-align: left;
            }

            table.data-table tbody td {
                padding: 6px 10px;
                font-size: 9px;
                color: #334155;
                border-bottom: 1px solid #F1F5F9;
                text-align: left;
            }

            table.data-table tbody tr:nth-child(even) td {
                background-color: #F8FAFC;
            }

            table.data-table tbody tr:last-child td {
                border-bottom: none;
            }

            .text-right {
                text-align: right !important;
            }

            .text-center {
                text-align: center !important;
            }

            /* Two Column Layout Table */
            .two-col-table {
                width: 100%;
                border-collapse: collapse;
            }

            .two-col-table td {
                vertical-align: top;
            }

            .col-left {
                width: 49%;
                padding-right: 1%;
            }

            .col-right {
                width: 49%;
                padding-left: 1%;
            }

            /* Footer */
            .footer-table {
                width: 100%;
                margin-top: 20px;
                padding-top: 10px;
                border-top: 1px solid #E2E8F0;
                border-collapse: collapse;
            }

            .footer-table td {
                font-size: 8px;
                color: #94A3B8;
            }
        </style>
    </head>

    <body dir="{{ $isRTL ? 'rtl' : 'ltr' }}">
        <div class="page-container">
            <!-- Signature Accent Top Line -->
            <div class="brand-accent-bar"></div>

            <!-- Header -->
            <table class="header-table">
                <tr>
                    <td class="logo-cell">
                        @if ($logo)
                            <img class="logo-img" src="{{ $logo }}" alt="Nexora CRM">
                        @else
                            <div style="font-size: 20px; font-weight: 800; color: #5A4DB9; letter-spacing: -0.5px;">
                                Nexora<span style="color: #01C7F4;">.CRM</span>
                            </div>
                        @endif
                        <div class="brand-subtitle">Executive Intelligence & Pipeline Report</div>
                    </td>

                    <td class="meta-cell">
                        <div class="report-title">
                            @lang('admin::app.dashboard.index.pdf.title')
                        </div>
                        <div class="date-badge">
                            @lang('admin::app.dashboard.index.pdf.filtered-date'): {{ $startDate->format('d M Y') }} – {{ $endDate->format('d M Y') }}
                        </div>
                        <div class="meta-timestamp">
                            Generated on {{ now()->format('M d, Y • h:i A') }} • System Confidential
                        </div>
                    </td>
                </tr>
            </table>

            <!-- KPI Summary Cards -->
            <table class="kpi-table">
                <tr>
                    <td class="kpi-card kpi-won">
                        <div class="kpi-label">@lang('admin::app.dashboard.index.revenue.won-revenue')</div>
                        <div class="kpi-value">{{ $revenueStats['total_won_revenue']['formatted_total'] }}</div>
                        <div class="kpi-sub">
                            Previous: {{ core()->formatBasePrice($revenueStats['total_won_revenue']['previous']) }}
                            (<span class="{{ $revenueStats['total_won_revenue']['progress'] >= 0 ? 'badge-pos' : 'badge-neg' }}">{{ number_format($revenueStats['total_won_revenue']['progress'], 1) }}%</span>)
                        </div>
                    </td>

                    <td class="kpi-card kpi-lost">
                        <div class="kpi-label">@lang('admin::app.dashboard.index.revenue.lost-revenue')</div>
                        <div class="kpi-value">{{ $revenueStats['total_lost_revenue']['formatted_total'] }}</div>
                        <div class="kpi-sub">
                            Previous: {{ core()->formatBasePrice($revenueStats['total_lost_revenue']['previous']) }}
                            (<span class="{{ $revenueStats['total_lost_revenue']['progress'] <= 0 ? 'badge-pos' : 'badge-neg' }}">{{ number_format($revenueStats['total_lost_revenue']['progress'], 1) }}%</span>)
                        </div>
                    </td>

                    <td class="kpi-card kpi-cyan">
                        <div class="kpi-label">@lang('admin::app.dashboard.index.over-all.total-leads')</div>
                        <div class="kpi-value">{{ $overAllStats['total_leads']['current'] }} Deals</div>
                        <div class="kpi-sub">
                            Avg/Day: {{ number_format($overAllStats['average_leads_per_day']['current'], 1) }} leads
                            (<span class="{{ $overAllStats['total_leads']['progress'] >= 0 ? 'badge-pos' : 'badge-neg' }}">{{ number_format($overAllStats['total_leads']['progress'], 1) }}%</span>)
                        </div>
                    </td>

                    <td class="kpi-card">
                        <div class="kpi-label">@lang('admin::app.dashboard.index.over-all.average-lead-value')</div>
                        <div class="kpi-value">{{ $overAllStats['average_lead_value']['formatted_total'] }}</div>
                        <div class="kpi-sub">
                            Quotes: {{ $overAllStats['total_quotations']['current'] }} • Contacts: {{ $overAllStats['total_persons']['current'] }}
                        </div>
                    </td>
                </tr>
            </table>

            <!-- Overview Metrics Table -->
            <div class="section">
                <div class="section-header">
                    <span>//</span> @lang('admin::app.dashboard.index.pdf.overview') & Operations
                </div>

                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>@lang('admin::app.dashboard.index.pdf.metric')</th>
                                <th class="text-center">@lang('admin::app.dashboard.index.pdf.current')</th>
                                <th class="text-center">@lang('admin::app.dashboard.index.pdf.previous')</th>
                                <th class="text-right">@lang('admin::app.dashboard.index.pdf.progress')</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td><strong>@lang('admin::app.dashboard.index.over-all.total-leads')</strong></td>
                                <td class="text-center">{{ $overAllStats['total_leads']['current'] }}</td>
                                <td class="text-center">{{ $overAllStats['total_leads']['previous'] }}</td>
                                <td class="text-right {{ $overAllStats['total_leads']['progress'] >= 0 ? 'badge-pos' : 'badge-neg' }}">
                                    {{ ($overAllStats['total_leads']['progress'] >= 0 ? '+' : '') . number_format($overAllStats['total_leads']['progress'], 2) }}%
                                </td>
                            </tr>

                            <tr>
                                <td><strong>@lang('admin::app.dashboard.index.over-all.average-lead-value')</strong></td>
                                <td class="text-center">{{ $overAllStats['average_lead_value']['formatted_total'] }}</td>
                                <td class="text-center">{{ core()->formatBasePrice($overAllStats['average_lead_value']['previous']) }}</td>
                                <td class="text-right {{ $overAllStats['average_lead_value']['progress'] >= 0 ? 'badge-pos' : 'badge-neg' }}">
                                    {{ ($overAllStats['average_lead_value']['progress'] >= 0 ? '+' : '') . number_format($overAllStats['average_lead_value']['progress'], 2) }}%
                                </td>
                            </tr>

                            <tr>
                                <td><strong>@lang('admin::app.dashboard.index.over-all.average-leads-per-day')</strong></td>
                                <td class="text-center">{{ number_format($overAllStats['average_leads_per_day']['current'], 2) }}</td>
                                <td class="text-center">{{ number_format($overAllStats['average_leads_per_day']['previous'], 2) }}</td>
                                <td class="text-right {{ $overAllStats['average_leads_per_day']['progress'] >= 0 ? 'badge-pos' : 'badge-neg' }}">
                                    {{ ($overAllStats['average_leads_per_day']['progress'] >= 0 ? '+' : '') . number_format($overAllStats['average_leads_per_day']['progress'], 2) }}%
                                </td>
                            </tr>

                            <tr>
                                <td><strong>@lang('admin::app.dashboard.index.over-all.total-quotations')</strong></td>
                                <td class="text-center">{{ $overAllStats['total_quotations']['current'] }}</td>
                                <td class="text-center">{{ $overAllStats['total_quotations']['previous'] }}</td>
                                <td class="text-right {{ $overAllStats['total_quotations']['progress'] >= 0 ? 'badge-pos' : 'badge-neg' }}">
                                    {{ ($overAllStats['total_quotations']['progress'] >= 0 ? '+' : '') . number_format($overAllStats['total_quotations']['progress'], 2) }}%
                                </td>
                            </tr>

                            <tr>
                                <td><strong>@lang('admin::app.dashboard.index.over-all.total-persons')</strong></td>
                                <td class="text-center">{{ $overAllStats['total_persons']['current'] }}</td>
                                <td class="text-center">{{ $overAllStats['total_persons']['previous'] }}</td>
                                <td class="text-right {{ $overAllStats['total_persons']['progress'] >= 0 ? 'badge-pos' : 'badge-neg' }}">
                                    {{ ($overAllStats['total_persons']['progress'] >= 0 ? '+' : '') . number_format($overAllStats['total_persons']['progress'], 2) }}%
                                </td>
                            </tr>

                            <tr>
                                <td><strong>@lang('admin::app.dashboard.index.over-all.total-organizations')</strong></td>
                                <td class="text-center">{{ $overAllStats['total_organizations']['current'] }}</td>
                                <td class="text-center">{{ $overAllStats['total_organizations']['previous'] }}</td>
                                <td class="text-right {{ $overAllStats['total_organizations']['progress'] >= 0 ? 'badge-pos' : 'badge-neg' }}">
                                    {{ ($overAllStats['total_organizations']['progress'] >= 0 ? '+' : '') . number_format($overAllStats['total_organizations']['progress'], 2) }}%
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Two-Column Section: Revenue Sources & Types -->
            <table class="two-col-table section">
                <tr>
                    <td class="col-left">
                        <div class="section-header">
                            <span>//</span> @lang('admin::app.dashboard.index.pdf.revenue-by-sources')
                        </div>
                        <div class="table-container">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>@lang('admin::app.dashboard.index.pdf.source')</th>
                                        <th class="text-right">@lang('admin::app.dashboard.index.pdf.total')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($revenueBySources as $source)
                                        <tr>
                                            <td><strong>{{ $source->name ?? '-' }}</strong></td>
                                            <td class="text-right">{{ core()->formatBasePrice($source->total) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center" style="color: #94A3B8;">No source data recorded</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </td>

                    <td class="col-right">
                        <div class="section-header">
                            <span>//</span> @lang('admin::app.dashboard.index.pdf.revenue-by-types')
                        </div>
                        <div class="table-container">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>@lang('admin::app.dashboard.index.pdf.type')</th>
                                        <th class="text-right">@lang('admin::app.dashboard.index.pdf.total')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($revenueByTypes as $type)
                                        <tr>
                                            <td><strong>{{ $type->name ?? '-' }}</strong></td>
                                            <td class="text-right">{{ core()->formatBasePrice($type->total) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center" style="color: #94A3B8;">No deal type data recorded</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>

            <!-- Pipeline Distribution by Stages -->
            <div class="section">
                <div class="section-header">
                    <span>//</span> @lang('admin::app.dashboard.index.pdf.open-leads-by-stages')
                </div>

                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>@lang('admin::app.dashboard.index.pdf.stage')</th>
                                <th class="text-right">@lang('admin::app.dashboard.index.pdf.total') Deals</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($openLeadsByStates as $stage)
                                <tr>
                                    <td><strong>{{ $stage->name ?? '-' }}</strong></td>
                                    <td class="text-right">{{ $stage->total }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center" style="color: #94A3B8;">No active open leads in pipeline</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Two-Column Section: Top Products & Top Customers -->
            <table class="two-col-table section">
                <tr>
                    <td class="col-left">
                        <div class="section-header">
                            <span>//</span> @lang('admin::app.dashboard.index.pdf.top-selling-products')
                        </div>
                        <div class="table-container">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>@lang('admin::app.dashboard.index.pdf.product')</th>
                                        <th class="text-center">@lang('admin::app.dashboard.index.pdf.price')</th>
                                        <th class="text-right">@lang('admin::app.dashboard.index.pdf.total')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($topSellingProducts as $product)
                                        <tr>
                                            <td><strong>{{ $product['name'] ?? '-' }}</strong></td>
                                            <td class="text-center">{{ $product['formatted_price'] }}</td>
                                            <td class="text-right">{{ $product['formatted_revenue'] }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center" style="color: #94A3B8;">No products recorded</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </td>

                    <td class="col-right">
                        <div class="section-header">
                            <span>//</span> @lang('admin::app.dashboard.index.pdf.top-persons')
                        </div>
                        <div class="table-container">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>@lang('admin::app.dashboard.index.pdf.person')</th>
                                        <th class="text-right">@lang('admin::app.dashboard.index.pdf.total')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($topPersons as $person)
                                        <tr>
                                            <td><strong>{{ $person['name'] ?? '-' }}</strong></td>
                                            <td class="text-right">{{ $person['formatted_revenue'] }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center" style="color: #94A3B8;">No contacts recorded</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>

            <!-- Document Footer -->
            <table class="footer-table">
                <tr>
                    <td>
                        Powered by <strong>Nexora CRM</strong> • Enterprise Pipeline Management & Sales Intelligence
                    </td>
                    <td class="text-right">
                        https://github.com/Isuru-CodeX/NoxusCRM
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>