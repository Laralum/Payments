@php
    $settings = Laralum\Payments\Models\Settings::first();
@endphp
<div uk-grid>
    @can('update', \Laralum\Payments\Models\Settings::class)
    <div class="uk-width-1-1@s uk-width-1-5@l"></div>
    <div class="uk-width-1-1@s uk-width-3-5@l">
        <form class="uk-form-horizontal" method="POST" action="{{ route('laralum::payments.settings.update') }}">
            {{ csrf_field() }}
            <fieldset class="uk-fieldset">

                <div class="uk-margin">
                    <label class="uk-form-label">@lang('laralum_payments::general.stripe_key')</label>
                    <div class="uk-form-controls">
                        <input value="{{ old('stripe_key', $settings->stripe_key ? decrypt($settings->stripe_key) : '') }}" name="stripe_key" class="uk-input" type="text" placeholder="@lang('laralum_payments::general.stripe_key_ph')">
                        <small class="uk-text-meta">@lang('laralum_payments::general.stripe_key_hp')</small>
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label">@lang('laralum_payments::general.stripe_secret')</label>
                    <div class="uk-form-controls">
                        <input value="{{ old('stripe_secret', $settings->stripe_secret ? decrypt($settings->stripe_secret) : '') }}" name="stripe_secret" class="uk-input" type="text" placeholder="@lang('laralum_payments::general.stripe_secret_ph')">
                        <small class="uk-text-meta">@lang('laralum_payments::general.stripe_secret_hp')</small>
                    </div>
                </div>

                <div class="uk-margin uk-align-right">
                    <button type="submit" class="uk-button uk-button-primary">
                        <span class="ion-forward"></span>&nbsp; @lang('laralum_payments::general.save')
                    </button>
                </div>

            </fieldset>
        </form>
    </div>
    <div class="uk-width-1-1@s uk-width-1-5@l"></div>
    @else
        <div class="uk-width-1-1">
            <div class="content-background">
                <div class="uk-section uk-section-small uk-section-default">
                    <div class="uk-container uk-text-center">
                        <h3>
                            <span class="ion-minus-circled"></span>
                            @lang('laralum_payments::general.unauthorized_action')
                        </h3>
                        <p>
                            @lang('laralum_payments::general.unauthorized_desc')
                        </p>
                        <p class="uk-text-meta">
                            @lang('laralum_payments::general.contact_webmaster')
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endcan
</div>
