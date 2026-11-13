<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html
    lang="{{ $locale = app()->getLocale() }}"
    dir="{{ in_array($locale, ['fa', 'ar']) ? 'rtl' : 'ltr' }}"
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

            // Resolve logo as base64 data URI for reliable offline/PDF rendering
            $logo = null;
            $configuredLogo = core()->getConfigData('general.general.admin_logo.logo_image');
            if ($configuredLogo && \Illuminate\Support\Facades\Storage::disk('public')->exists($configuredLogo)) {
                $mime = \Illuminate\Support\Facades\Storage::disk('public')->mimeType($configuredLogo);
                $logo = 'data:' . $mime . ';base64,' . base64_encode(\Illuminate\Support\Facades\Storage::disk('public')->get($configuredLogo));
            } elseif (file_exists(public_path('images/nexora-logo-dark.png'))) {
                $logo = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/nexora-logo-dark.png')));
            }

            $companyAddress = core()->getConfigData('general.general.company_info.address')
                ?: '100 Silicon Vista Blvd, Suite 400, San Francisco, CA 94107';
        @endphp

        <style type="text/css">
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: "{{ $fontFamily['regular'] }}";
            }

            body {
                font-size: 9.5px;
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
                vertical-align: top;
            }

            .logo-cell {
                width: 55%;
            }

            .logo-img {
                max-width: 170px;
                max-height: 46px;
                display: block;
                margin-bottom: 6px;
            }

            .brand-text-logo {
                font-size: 20px;
                font-weight: 800;
                color: #5A4DB9;
                letter-spacing: -0.5px;
                margin-bottom: 4px;
            }

            .company-info {
                font-size: 8.5px;
                color: #64748B;
                line-height: 1.35;
                max-width: 280px;
            }

            .meta-cell {
                width: 45%;
                text-align: right;
            }

            .quote-title {
                font-size: 20px;
                font-weight: 800;
                color: #0F172A;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin-bottom: 4px;
            }

            .quote-number {
                font-size: 11px;
                font-weight: 700;
                color: #5A4DB9;
                margin-bottom: 6px;
            }

            .meta-badge {
                display: inline-block;
                background-color: #F8FAFC;
                border: 1px solid #E2E8F0;
                border-radius: 4px;
                padding: 3px 8px;
                font-size: 8.5px;
                color: #334155;
                margin-bottom: 3px;
            }

            .meta-badge b {
                color: #0F172A;
            }

            .expiry-badge {
                display: inline-block;
                background-color: #FEF3C7;
                border: 1px solid #FCD34D;
                border-radius: 4px;
                padding: 3px 8px;
                font-size: 8.5px;
                color: #92400E;
                font-weight: 700;
            }

            /* Two-Column Party Cards */
            .parties-table {
                width: 100%;
                margin-bottom: 16px;
                border-collapse: separate;
                border-spacing: 10px 0;
            }

            .party-card {
                background-color: #F8FAFC;
                border: 1px solid #E2E8F0;
                border-top: 3px solid #5A4DB9;
                border-radius: 6px;
                padding: 10px 12px;
                vertical-align: top;
                width: 50%;
            }

            .party-card.ship-to {
                border-top-color: #01C7F4;
            }

            .party-title {
                font-size: 9px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: #64748B;
                margin-bottom: 6px;
                border-bottom: 1px solid #E2E8F0;
                padding-bottom: 3px;
            }

            .party-name {
                font-size: 11px;
                font-weight: 700;
                color: #0F172A;
                margin-bottom: 2px;
            }

            .party-detail {
                font-size: 8.5px;
                color: #475569;
                line-height: 1.4;
            }

            .party-rep {
                margin-top: 6px;
                padding-top: 4px;
                border-top: 1px dashed #CBD5E1;
                font-size: 8px;
                color: #64748B;
            }

            /* Line Items Table */
            .table-container {
                border: 1px solid #E2E8F0;
                border-radius: 6px;
                overflow: hidden;
                margin-bottom: 14px;
            }

            table.data-table {
                width: 100%;
                border-collapse: collapse;
                background-color: #FFFFFF;
            }

            table.data-table thead th {
                background-color: #0F172A;
                color: #FFFFFF;
                font-size: 8px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.4px;
                padding: 7px 10px;
                border: none;
                text-align: left;
            }

            table.data-table tbody td {
                padding: 8px 10px;
                font-size: 8.5px;
                color: #334155;
                border-bottom: 1px solid #F1F5F9;
                text-align: left;
                vertical-align: middle;
            }

            table.data-table tbody tr:nth-child(even) td {
                background-color: #F8FAFC;
            }

            table.data-table tbody tr:last-child td {
                border-bottom: none;
            }

            .sku-pill {
                display: inline-block;
                background-color: #EEF2F6;
                color: #475569;
                padding: 1px 5px;
                border-radius: 3px;
                font-size: 7.5px;
                font-family: monospace;
                margin-bottom: 2px;
            }

            .item-name {
                font-weight: 700;
                color: #0F172A;
            }

            .text-right {
                text-align: right !important;
            }

            .text-center {
                text-align: center !important;
            }

            /* Financial Summary & Notes Split */
            .bottom-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 16px;
            }

            .bottom-table td {
                vertical-align: top;
            }

            .notes-cell {
                width: 55%;
                padding-right: 14px;
            }

            .notes-box {
                background-color: #F8FAFC;
                border: 1px solid #E2E8F0;
                border-left: 3px solid #5A4DB9;
                border-radius: 5px;
                padding: 10px 12px;
            }

            .notes-title {
                font-size: 8.5px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.4px;
                color: #475569;
                margin-bottom: 4px;
            }

            .notes-content {
                font-size: 8px;
                color: #64748B;
                line-height: 1.4;
            }

            .totals-cell {
                width: 45%;
            }

            .totals-card {
                border: 1px solid #E2E8F0;
                border-radius: 6px;
                overflow: hidden;
                background-color: #FFFFFF;
            }

            .totals-table {
                width: 100%;
                border-collapse: collapse;
            }

            .totals-table td {
                padding: 5px 10px;
                font-size: 8.5px;
                border-bottom: 1px solid #F1F5F9;
            }

            .totals-label {
                color: #64748B;
            }

            .totals-val {
                text-align: right;
                font-weight: 600;
                color: #1E293B;
            }

            .grand-total-row td {
                background-color: #0F172A;
                color: #FFFFFF !important;
                padding: 8px 10px;
                border-bottom: none;
            }

            .grand-total-row .totals-label {
                color: #CBD5E1;
                font-size: 9.5px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .grand-total-row .totals-val {
                color: #38BDF8 !important;
                font-size: 13px;
                font-weight: 800;
            }

            /* Signature Block */
            .signature-table {
                width: 100%;
                margin-top: 18px;
                margin-bottom: 16px;
                border-collapse: separate;
                border-spacing: 30px 0;
            }

            .signature-cell {
                width: 50%;
                border-top: 1px solid #94A3B8;
                padding-top: 4px;
                text-align: center;
                font-size: 8px;
                color: #64748B;
            }

            .signature-cell b {
                display: block;
                color: #0F172A;
                font-size: 8.5px;
                margin-bottom: 2px;
            }

            /* Footer */
            .footer-table {
                width: 100%;
                border-top: 1px solid #E2E8F0;
                padding-top: 8px;
                margin-top: 10px;
            }

            .footer-left {
                font-size: 7.5px;
                color: #94A3B8;
            }

            .footer-right {
                font-size: 7.5px;
                color: #94A3B8;
                text-align: right;
            }

            .footer-brand {
                color: #5A4DB9;
                font-weight: 700;
            }
        </style>
    </head>

    <body dir="{{ in_array($locale, ['fa', 'ar']) ? 'rtl' : 'ltr' }}">
        <div class="brand-accent-bar"></div>

        <div class="page-container">
            <!-- Header Section -->
            <table class="header-table">
                <tr>
                    <td class="logo-cell">
                        @if ($logo)
                            <img class="logo-img" src="{{ $logo }}" alt="Nexora CRM">
                        @else
                            <div class="brand-text-logo">
                                Nexora<span style="color: #01C7F4;">.CRM</span>
                            </div>
                        @endif

                        <div class="company-info">
                            {!! nl2br(e($companyAddress)) !!}
                        </div>
                    </td>

                    <td class="meta-cell">
                        <div class="quote-title">@lang('admin::app.quotes.index.pdf.title')</div>
                        <div class="quote-number">#{{ $quote->id }} — {{ $quote->subject }}</div>

                        <div class="meta-badge">
                            <b>@lang('admin::app.quotes.index.pdf.date'):</b>
                            {{ core()->formatDate($quote->created_at, 'M d, Y') }}
                        </div>

                        @if ($quote->expired_at)
                            <div>
                                <span class="expiry-badge">
                                    @lang('admin::app.quotes.index.pdf.expired-at'):
                                    {{ core()->formatDate($quote->expired_at, 'M d, Y') }}
                                </span>
                            </div>
                        @endif
                    </td>
                </tr>
            </table>

            <!-- Customer & Shipping Information Cards -->
            <table class="parties-table">
                <tr>
                    <td class="party-card">
                        <div class="party-title">@lang('admin::app.quotes.index.pdf.billing-address')</div>
                        <div class="party-name">{{ $quote->person->name ?? 'Valued Customer' }}</div>

                        @if (! empty($quote->person?->organization))
                            <div class="party-detail" style="font-weight: 600; color: #5A4DB9;">
                                {{ $quote->person->organization->name }}
                            </div>
                        @endif

                        @if (! empty($quote->billing_address))
                            <div class="party-detail">
                                {{ $quote->billing_address['address'] ?? '' }}
                                @if (! empty($quote->billing_address['city']) || ! empty($quote->billing_address['postcode']))
                                    <br>{{ $quote->billing_address['city'] ?? '' }} {{ $quote->billing_address['postcode'] ?? '' }}
                                @endif
                                @if (! empty($quote->billing_address['state']) || ! empty($quote->billing_address['country']))
                                    <br>{{ $quote->billing_address['state'] ?? '' }} {{ core()->country_name($quote->billing_address['country'] ?? '') }}
                                @endif
                            </div>
                        @endif

                        @if (! empty($quote->person?->emails))
                            <div class="party-detail" style="margin-top: 3px; color: #64748B;">
                                {{ is_array($quote->person->emails) ? ($quote->person->emails[0]['value'] ?? '') : '' }}
                            </div>
                        @endif
                    </td>

                    <td class="party-card ship-to">
                        <div class="party-title">@lang('admin::app.quotes.index.pdf.shipping-address') &amp; @lang('admin::app.quotes.index.pdf.sales-person')</div>

                        @if (! empty($quote->shipping_address))
                            <div class="party-detail">
                                {{ $quote->shipping_address['address'] ?? '' }}
                                @if (! empty($quote->shipping_address['city']) || ! empty($quote->shipping_address['postcode']))
                                    <br>{{ $quote->shipping_address['city'] ?? '' }} {{ $quote->shipping_address['postcode'] ?? '' }}
                                @endif
                                @if (! empty($quote->shipping_address['state']) || ! empty($quote->shipping_address['country']))
                                    <br>{{ $quote->shipping_address['state'] ?? '' }} {{ core()->country_name($quote->shipping_address['country'] ?? '') }}
                                @endif
                            </div>
                        @else
                            <div class="party-detail" style="color: #64748B; font-style: italic;">
                                Same as billing address
                            </div>
                        @endif

                        <div class="party-rep">
                            <b>@lang('admin::app.quotes.index.pdf.sales-person'):</b>
                            {{ $quote->user->name ?? 'Sales Representative' }}
                            @if (! empty($quote->user?->email))
                                ({{ $quote->user->email }})
                            @endif

                            @php
                                $associatedLead = $quote->leads?->first();
                            @endphp
                            @if ($associatedLead)
                                <br><b>Associated Lead:</b> #{{ $associatedLead->id }} — {{ $associatedLead->title }}
                            @endif
                        </div>
                    </td>
                </tr>
            </table>

            <!-- Line Items Table -->
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 14%;">@lang('admin::app.quotes.index.pdf.sku')</th>
                            <th style="width: 32%;">@lang('admin::app.quotes.index.pdf.product-name')</th>
                            <th class="text-right" style="width: 11%;">@lang('admin::app.quotes.index.pdf.price')</th>
                            <th class="text-center" style="width: 7%;">@lang('admin::app.quotes.index.pdf.quantity')</th>
                            <th class="text-right" style="width: 12%;">@lang('admin::app.quotes.index.pdf.amount')</th>
                            <th class="text-right" style="width: 10%;">@lang('admin::app.quotes.index.pdf.discount')</th>
                            <th class="text-right" style="width: 14%;">@lang('admin::app.quotes.index.pdf.grand-total')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($quote->items as $item)
                            <tr>
                                <td>
                                    <span class="sku-pill">{{ $item->sku ?: 'SKU-'.$item->id }}</span>
                                </td>
                                <td>
                                    <div class="item-name">{{ $item->name }}</div>
                                </td>
                                <td class="text-right">{!! core()->formatBasePrice($item->price, true) !!}</td>
                                <td class="text-center"><b>{{ $item->quantity }}</b></td>
                                <td class="text-right">{!! core()->formatBasePrice($item->total, true) !!}</td>
                                <td class="text-right">
                                    @if ((float) $item->discount_amount > 0)
                                        <span style="color: #059669;">-{!! core()->formatBasePrice($item->discount_amount, true) !!}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-right" style="font-weight: 700; color: #0F172A;">
                                    {!! core()->formatBasePrice($item->total + $item->tax_amount - $item->discount_amount, true) !!}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center" style="padding: 14px; color: #94A3B8;">
                                    No products found in this quote.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Financial Summary & Notes -->
            <table class="bottom-table">
                <tr>
                    <td class="notes-cell">
                        @if ($quote->description)
                            <div class="notes-box">
                                <div class="notes-title">@lang('admin::app.quotes.index.pdf.description') / Notes</div>
                                <div class="notes-content">
                                    {!! nl2br(e($quote->description)) !!}
                                </div>
                            </div>
                        @else
                            <div class="notes-box">
                                <div class="notes-title">Terms &amp; Conditions</div>
                                <div class="notes-content">
                                    • All quotations are valid for 30 days unless otherwise specified.<br>
                                    • Payment terms: Net 30 days upon acceptance.<br>
                                    • Standard commercial service warranties apply.
                                </div>
                            </div>
                        @endif
                    </td>

                    <td class="totals-cell">
                        <div class="totals-card">
                            <table class="totals-table">
                                <tr>
                                    <td class="totals-label">@lang('admin::app.quotes.index.pdf.sub-total')</td>
                                    <td class="totals-val">{!! core()->formatBasePrice($quote->sub_total, true) !!}</td>
                                </tr>

                                @if ((float) $quote->discount_amount > 0)
                                    <tr>
                                        <td class="totals-label">@lang('admin::app.quotes.index.pdf.discount')</td>
                                        <td class="totals-val" style="color: #059669;">
                                            -{!! core()->formatBasePrice($quote->discount_amount, true) !!}
                                        </td>
                                    </tr>
                                @endif

                                @if ((float) $quote->tax_amount > 0)
                                    <tr>
                                        <td class="totals-label">@lang('admin::app.quotes.index.pdf.tax')</td>
                                        <td class="totals-val">{!! core()->formatBasePrice($quote->tax_amount, true) !!}</td>
                                    </tr>
                                @endif

                                @if ((float) $quote->adjustment_amount != 0)
                                    <tr>
                                        <td class="totals-label">@lang('admin::app.quotes.index.pdf.adjustment')</td>
                                        <td class="totals-val">{!! core()->formatBasePrice($quote->adjustment_amount, true) !!}</td>
                                    </tr>
                                @endif

                                <tr class="grand-total-row">
                                    <td class="totals-label">@lang('admin::app.quotes.index.pdf.grand-total')</td>
                                    <td class="totals-val">{!! core()->formatBasePrice($quote->grand_total, true) !!}</td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>

            <!-- Signature Line -->
            <table class="signature-table">
                <tr>
                    <td class="signature-cell">
                        <b>{{ $quote->user->name ?? 'Sales Representative' }}</b>
                        Authorized Nexora Representative
                    </td>
                    <td class="signature-cell">
                        <b>{{ $quote->person->name ?? 'Authorized Client Signatory' }}</b>
                        Client Acceptance &amp; Date
                    </td>
                </tr>
            </table>

            <!-- Footer -->
            <table class="footer-table">
                <tr>
                    <td class="footer-left">
                        Quote #{{ $quote->id }} &bull; Generated {{ date('Y-m-d H:i') }} &bull; Confidential
                    </td>
                    <td class="footer-right">
                        Powered by <span class="footer-brand">Nexora CRM</span>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
