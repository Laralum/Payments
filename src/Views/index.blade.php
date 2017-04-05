@extends('laralum::layouts.master')
@section('icon', 'ion-card')
@section('title', __('laralum_payments::general.payments'))
@section('subtitle', __('laralum_payments::general.payments_desc'))
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    [v-cloak] {
        display: none;
    }
</style>
@endsection
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('laralum::index') }}">@lang('laralum_payments::general.home')</a></li>
        <li><span>@lang('laralum_payments::general.payments')</span></li>
    </ul>
@endsection
@section('content')
    <div class="uk-container uk-container-large" id='payments_app'>
        <div uk-grid>
            @if ($settings->ready())
                <div class="uk-width-1-1@m uk-width-1-2@l" v-cloak>
                    <div class="uk-card uk-card-default uk-card-body">
                        <span class="statistics-text">
                            @lang('laralum_payments::general.pending_balance')
                            <span class="uk-label" v-bind:class="[balance.livemode ? 'uk-label-success' : 'uk-label-warning']">
                                @{{ balance.livemode ? "@lang('laralum_payments::general.live_mode')" : "@lang('laralum_payments::general.test_mode')" }}
                            </span>
                        </span>
                        <br />
                        <span class="statistics-number">
                            <span class="money" :data-ccy="balance.pending[0].currency.toUpperCase()">
                                @{{ (balance.pending[0].amount / 100).toFixed(2) }}
                            </span>
                        </span>
                    </div>
                </div>
                <div class="uk-width-1-1@m uk-width-1-2@l" v-cloak>
                    <div class="uk-card uk-card-default uk-card-body">
                        <span class="statistics-text">
                            @lang('laralum_payments::general.available_balance')
                            <span class="uk-label" v-bind:class="[balance.livemode ? 'uk-label-success' : 'uk-label-warning']">
                                @{{ balance.livemode ? "@lang('laralum_payments::general.live_mode')" : "@lang('laralum_payments::general.test_mode')" }}
                            </span>
                        </span>
                        <br />
                        <span class="statistics-number">
                            <span class="money" :data-ccy="balance.available[0].currency.toUpperCase()">
                                @{{ (balance.available[0].amount / 100).toFixed(2) }}
                            </span>
                        </span>
                    </div>
                </div>
                <div class="uk-width-1-1@m uk-width-1-2@l" v-cloak>
                    <div class="uk-card uk-card-default">
                        <div class="uk-card-header">
                            @lang('laralum_payments::general.payments')
                        </div>
                        <div class="uk-card-body">
                            <div class="uk-overflow-auto">
                                <table class="uk-table uk-table-striped">
                                    <thead>
                                        <tr>
                                            <th>@lang('laralum_payments::general.amount')</th>
                                            <th>@lang('laralum_payments::general.status')</th>
                                            <th>@lang('laralum_payments::general.date')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="charge in charges">
                                            <td>
                                                <span class="money" :data-ccy="charge.currency.toUpperCase()">
                                                    @{{ (charge.amount / 100).toFixed(2) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="uk-label" v-bind:class="[charge.paid ? 'uk-label-success' : uk-label-error]">
                                                    @{{ charge.paid ? "@lang('laralum_payments::general.paid')" : "@lang('laralum_payments::general.not_paid')" }}
                                                </span>
                                            </td>
                                            <td>@{{ moment.unix(charge.created).fromNow() }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-width-1-1@m uk-width-1-2@l" v-cloak>
                    <div class="uk-card uk-card-default">
                        <div class="uk-card-header">
                            @lang('laralum_payments::general.customers')
                        </div>
                        <div class="uk-card-body">
                            <div class="uk-overflow-auto">
                                <table class="uk-table uk-table-striped">
                                    <thead>
                                        <tr>
                                            <th>@lang('laralum_payments::general.email')</th>
                                            <th>@lang('laralum_payments::general.date')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="customer in customers">
                                            <td>@{{ customer.email }}</td>
                                            <td>@{{ moment.unix(customer.created).fromNow() }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="uk-width-1-1">
                    <div class="uk-card uk-card-default uk-card-body">
                        <div class="uk-alert-danger" uk-alert>
                            <p>@lang('laralum_payments::general.no_keys_set')</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('js')
    @if($settings->stripe_key and $settings->stripe_secret)
        <script src="https://cdn.bootcss.com/currencyformatter.js/1.0.4/currencyFormatter.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment-with-locales.min.js" integrity="sha256-vvT7Ok9u6GbfnBPXnbM6FVDEO8E1kTdgHOFZOAXrktA=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.2.2/vue.min.js" integrity="sha256-aj1M6HvoQC92WZpIeJvEFeHktFR5mizcIhJnK5n91wk=" crossorigin="anonymous"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            new Vue({
                'el': '#payments_app',
                'data': {
                    'balance': {
                        'available': [
                            {
                                'amount': '0',
                                'currency': 'eur',
                            }
                        ],
                        'pending': [
                            {
                                'amount': '0',
                                'currency': 'eur',
                            }
                        ],
                    },
                    'charges': [],
                    'customers': [],
                },
                'methods': {
                    getBalance: function() {
                        $.post("{{ route('laralum_api::payments.balance') }}", function(result) {
                            this.balance = result;
                        }.bind(this));
                    },
                    getCharges: function() {
                        $.post("{{ route('laralum_api::payments.charges') }}", function(result) {
                            this.charges = result['data'];
                        }.bind(this));
                    },
                    getCustomers: function() {
                        $.post("{{ route('laralum_api::payments.customers') }}", function(result) {
                            this.customers = result['data'];
                        }.bind(this));
                    },
                    setCurrency: function() {
                        OSREC.CurrencyFormatter.formatEach('.money');
                        $('.money').each(function() {
                            $(this).removeClass('money');
                            $(this).addClass('money-compiled');
                        });
                    },
                },
                created: function() {
                    this.getBalance();
                    this.getCharges();
                    this.getCustomers();
                },
                updated: function() {
                    this.setCurrency()
                },
            });
        </script>
    @endif
@endsection
