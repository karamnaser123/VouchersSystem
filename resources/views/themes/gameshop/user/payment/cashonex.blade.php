@extends($theme.'layouts.user')
@section('title')
    {{ 'Pay with '.optional($order->gateway)->name ?? '' }}
@endsection

@section('content')

    <style>
        .credit-card-box .form-control.error {
            border-color: red;
            outline: 0;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6);
        }

        .credit-card-box label.error {
            font-weight: bold;
            color: red;
            padding: 2px 8px;
            margin-top: 2px;
        }

        .dark-mode .input-group-text {
            color: #fffff6;
            background-color: {{config('basic.base_color')??'#8fb568'}};
            border: 1px solid{{config('basic.base_color')??'#8fb568'}};
        }
    </style>

    <section id="dashboard" class="login-section">
        <div class="container add-fund">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card secbg">
                        <div class="card-body">
                            <div class="row justify-content-center">

                                <div class="col-md-12 p-4 contact-box">
                                    <div class="card-wrapper"></div>
                                    <br><br>
                                    <form role="form" id="payment-form" method="{{$data->method}}"
                                          action="{{$data->url}}">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label><strong>@lang("CARD NAME")</strong></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control white" name="name"
                                                           placeholder="Card Name" autocomplete="off" required>
                                                </div>

                                                @error('name')<span
                                                    class="text-danger  mt-1">{{ $message }}</span>@enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label><strong>@lang("CARD NUMBER")</strong></label>
                                                <div class="input-group">
                                                    <input type="tel" class="form-control white" name="cardNumber"
                                                           placeholder="Valid Card Number" autocomplete="off" autofocus
                                                           required>
                                                </div>
                                                @error('cardNumber')<span
                                                    class="text-danger  mt-1">{{ $message }}</span>@enderror
                                            </div>

                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><strong>@lang("EXPIRATION DATE")</strong></label>
                                                <input
                                                    type="tel"
                                                    class="form-control input-lg white"
                                                    name="cardExpiry"
                                                    placeholder="MM / YYYY"
                                                    autocomplete="off"
                                                    required
                                                />


                                                @error('cardExpiry')<span
                                                    class="text-danger  mt-1">{{ $message }}</span>@enderror
                                            </div>
                                            <div class="col-md-6 pull-right">

                                                <label><strong>@lang("CVC CODE")</strong></label>
                                                <input
                                                    type="tel"
                                                    class="form-control input-lg white"
                                                    name="cardCVC"
                                                    placeholder="CVC"
                                                    autocomplete="off"
                                                    required
                                                />
                                                @error('cardCVC')<span
                                                    class="text-danger  mt-1">{{ $message }}</span>@enderror

                                            </div>
                                        </div>
                                        <br>
                                        <div class="btn-wrapper">
                                            <input class="game-btn " type="submit" value="PAY NOW">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script type="text/javascript" src="https://rawgit.com/jessepollak/card/master/dist/card.js"></script>

    <script>
        (function ($) {
            $(document).ready(function () {
                var card = new Card({
                    form: '#payment-form',
                    container: '.card-wrapper',
                    formSelectors: {
                        numberInput: 'input[name="cardNumber"]',
                        expiryInput: 'input[name="cardExpiry"]',
                        cvcInput: 'input[name="cardCVC"]',
                        nameInput: 'input[name="name"]'
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
