<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Gateway;
use App\Models\TopUpSell;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use Illuminate\Http\Request;
use App\Models\CategoryService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Facades\App\Services\BasicService;
use App\Http\Controllers\PaymentController;

class TopUpController extends Controller
{
    use Upload, Notify;

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }

    public function topUpOrder()
    {
        $data['topUpOrders'] = $this->user->topUp()->wherePayment_status(1)->orderBy('id', 'DESC')->paginate(config('basic.paginate'));
        return view($this->theme . 'user.top_up.index', $data);
    }

    public function topUpSearch(Request $request)
    {
        $search = $request->all();
        $dateSearch = $request->datetrx;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);
        $topUpOrders = TopUpSell::where('user_id', $this->user->id)->with('user')
            ->when(@$search['transaction_id'], function ($query) use ($search) {
                return $query->where('transaction', 'LIKE', "%{$search['transaction_id']}%");
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->paginate(config('basic.paginate'));
        $topUpOrders = $topUpOrders->appends($search);


        return view($this->theme . 'user.top_up.index', compact('topUpOrders'));
    }

    public function topUpPayment(Request $request)
    {
        $this->validate($request, [
            'gateway' => ['required', 'numeric'],
            'service' => ['required', 'numeric']
        ], [
            'gateway.required' => 'Please select a payment method',
            'service.required' => 'Please select a recharge option'
        ]);

        $service = CategoryService::with('category')->whereStatus(1)
            ->whereHas('category', function ($query) {
                $query->where('status', 1);
            })->findOrFail($request->service);
        $serviceCategory = $service->category;

        $rules = [];
        $inputField = [];
        if ($serviceCategory->form_field != null) {
            foreach ($serviceCategory->form_field as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], 'mimes:jpeg,jpg,png');
                    array_push($rules[$key], 'max:2048');
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }
        $this->validate($request, $rules);

        if ($request->gateway == '0') {
            $wallet['name'] = "Wallet";
            $wallet['id'] = 0;
            $wallet['fixed_charge'] = 0;
            $wallet['percentage_charge'] = 0;
            $wallet['convention_rate'] = 1;
            $wallet['currencies'] = (object)[
                '0' => (object)[
                    config('basic.currency') => config('basic.currency')
                ]
            ];
            $wallet['currency'] = config('basic.currency');
            $gate = (object)$wallet;
        } else {
            $gate = Gateway::where('status', 1)->findOrFail($request->gateway);
        }

        $serviceCategory = $service->category;
        $discount = 0;
        if ($serviceCategory->discount_status == 1) {
            if ($serviceCategory->discount_type == 0) {
                $discount = $serviceCategory->discount_amount; // fixed Discount
            } else {
                $discount = ($service->price * $serviceCategory->discount_amount) / 100; // percent Discount
            }
        }

        $user = $this->user;
        $reqAmount = $service->price - $discount;

        if ($request->gateway == '0' && $user->balance < $reqAmount) {
            return back()->with('error', 'Insufficient Wallet Balance')->withInput();
        }

        $charge = getAmount($gate->fixed_charge + ($reqAmount * $gate->percentage_charge / 100));
        $payable = getAmount($reqAmount + $charge);
        $final_amo = getAmount($payable * $gate->convention_rate);

        $topUpSell = new TopUpSell();
        $topUpSell->user_id = $user->id;
        $topUpSell->category_service_id = $service->id;
        $topUpSell->category_id = $serviceCategory->id;
        $topUpSell->price = $reqAmount;
        $topUpSell->discount = $discount;
        $topUpSell->transaction = strRandom();
        $collection = collect($request);
        $reqField = [];
        if ($serviceCategory->form_field != null) {
            foreach ($collection as $k => $v) {
                foreach ($serviceCategory->form_field as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {

                                try {
                                    $image = $request->file($inKey);
                                    $location = config('location.toUpSellLog.path');
                                    $filename = $this->uploadImage($image, $location);;
                                    $reqField[$inKey] = [
                                        'field_name' => $filename,
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    return back()->with('error', 'Image could not be uploaded.')->withInput();
                                }
                            }
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
            $topUpSell['information'] = $reqField;
        } else {
            $topUpSell['information'] = null;
        }
        $topUpSell->save();

        if ($request->gateway == '0' && $user->balance >= $reqAmount) {


            $user->balance -= $reqAmount;
            $user->save();

            $topUpSell->payment_status = 1;
            $topUpSell->save();
            BasicService::makeTransaction($user, getAmount($reqAmount), getAmount($charge), '-', $topUpSell->transaction, (optional($topUpSell->category)->details->name) ?? 'game top up');

            session()->flash('success', 'Your order has been processed');
            return redirect()->route('user.topUpOrder');
        } else {
            $fund = PaymentController::staticNewFund($request, $user, $gate, $charge, $final_amo, $reqAmount);
            $topUpSell->fundable()->save($fund);
            session()->put('track', $fund['transaction']);
            return redirect()->route('user.addFund.confirm');
        }
    }

    public function show()
    {

        return view('topupfreefire');
    }
    public function showPlayerData(Request $request)
    {
        $apiUrl = 'https://freefire.recharge-j.com/api/freefireTopup';
        $apiKey = 'xGYoWboh45HETHwVBpzadF65DuQbYnA7WfxpXpP5';
        // $apiKey = 'rRzD1rzK2rNA58Yy900FxhnxUvuMkkLIEAX4mfFM';

        $checkServiceUrl = 'https://freefire.recharge-j.com/api/checkService';
        $authToken = 'xGYoWboh45HETHwVBpzadF65DuQbYnA7WfxpXpP5';

        $response = Http::withHeaders([
            'Authorization' => $authToken,
        ])->get($checkServiceUrl);
        $costs = []; // Initialize an array to store costs
        if ($response->successful()) {
            $responseData = $response->json();
            $products = $responseData['products'];

            foreach ($products as $product) {
                $itemId2 = $product['item_id'];
                $appPointAmount = $product['app_point_amount'];
                $appBonusAmount = $product['app_bonus_amount'];
                // $costs[$product['item_id']] = $product['cost'];
                $costs[$product['item_id']] = $product['cost'] % 10 == 0 ? $product['cost'] / 10 : $product['cost'];
            }
        }

        // Retrieve player_id and item_id from form submission
        $playerId = $request->input('player_id');
        $itemId = $request->input('item_id');

        // Check if the form has been submitted
        if ($playerId && $itemId) {

            $user = User::where('id', auth()->user()->id)->first();

            if ($user->balance < $costs[$itemId]) {
                return response()->json(['error' => 'Insufficient Balance'], 400);
            }
            $data = [
                'player_id' => $playerId,
                'item_id'   => $itemId,
            ];

            $response = Http::withHeaders([
                'Content-Type'  => 'application/json',
                'Authorization' => $apiKey,
            ])->post($apiUrl, $data);
            $user = User::where('id', auth()->user()->id)->first();


            if ($response->successful()) {
                $responseData = $response->json();
                $status = $responseData['status'];
                if ($status === 'success') {
                    $playerName = $responseData['player_name'];
                    $operationId = $responseData['operation_id'];

                    $user->balance -= $costs[$itemId] / 1.06 * 0.71;
                    $user->save();

                    return response()->json([
                        'status' => 'success',
                        'player_name' => $playerName,
                        'operation_id' => $operationId,
                    ]);
                } else {
                    // Handle the error case
                    return response()->json([
                        'status' => 'error',
                        'statusCode' => $responseData['statusCode'], // Adjust this based on your actual response structure
                        'error' => $responseData, // You can provide additional error information if needed
                    ], 400);
                }
            } else {
                $error = $response->json();
                return response()->json(['error' => $error], $response->status());
            }
        }

        // Render the initial form view for non-AJAX requests
        return view('showPlayerData');
    }
}
