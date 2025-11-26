<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Stripe\StripeClient;
use App\Models\Item;
use App\Models\User;
use App\Http\Requests\PurchaseRequest;


class PurchaseController extends Controller
{
    public $purchaseMethod;

    public function show(Request $request, $item_id)
    {
        $purchase = Item::find($item_id);

        $id = Auth::id();
        $user = User::find($id);
        $profiles = $user->profile()->get();
        $profile = $profiles[0];

        return view('/purchase/create', compact('purchase', 'profile', 'item_id'));
    }

    public function store(PurchaseRequest $request, $item_id)
    {
        $id = Auth::id();
        $zipcode = $request->input('zipcode');
        $address = $request->input('address');
        $building = $request->input('building');
        $payment = $request->input('purchase-method');
        $item = Item::find($item_id);
        $item->buyUsers()->attach($id, ['zipcode' => $zipcode, 'address' => $address, 'building' => $building]);

        $itemsAll = Item::query()->nameSearch($request->itemname)->get();

        $ismylist = false;
        foreach ($itemsAll as $item) {
            $id = Auth::id();
            $exhibitUsers = $item->exhibitUsers()->get();
            $ar = [];
            if (count($exhibitUsers) > 0) foreach ($exhibitUsers as $eUser) {
                $ar[] = $eUser->id;
            }
            if (!in_array($id, $ar)) {
                $items[] = $item;
            }
        }

        // StripeのAPIキーを設定します
        $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));

        $price = $request->input('price');
        $name  = $request->input('name');
        $params = [
            'ismylist' => $ismylist,
            'items' => $item,
        ];

        // JSON化してURLエンコード
        $query = http_build_query([
            'session_id' => '{CHECKOUT_SESSION_ID}',
            'data' => json_encode($params),
        ]);

        $successUrl = "https://localhost/items/index?{$query}";


        try {
            // Stripe API 呼び出し
            // 決済する商品の情報を設定します
            if ($request->input('payment-method') == 'コンビニ払い') {
                $paymentMethod = ['konbini'];
                $checkout_session = $stripe->checkout->sessions->create([
                    'payment_method_types' => $paymentMethod,
                    'line_items' => [[
                        'price_data' => [
                            'currency' => 'jpy',
                            'unit_amount' => (int)$price,
                            'product_data' => [
                                'name' => $name,
                            ],
                        ],
                        'quantity' => 1,
                    ]],
                    'mode' => 'payment',
                    // 決済完了後にリダイレクトされるURLを指定します
                    'success_url' => $successUrl,
                    // 決済がキャンセルされた場合にリダイレクトされるURLを指定します
                    'cancel_url' => 'http://localhost/items/$item_id',
                ]);
            } else {
                $customerId = 'cus_TPIph6r9CGqocr';
                $paymentMethod = ['customer_balance'];
                $checkout_session = $stripe->checkout->sessions->create([
                    'payment_method_types' => $paymentMethod,
                    'customer' => $customerId,
                    'line_items' => [[
                        'price_data' => [
                            'currency' => 'jpy',
                            'unit_amount' => (int)$price,
                            'product_data' => [
                                'name' => $name,
                            ],
                        ],
                        'quantity' => 1,
                    ]],
                    'mode' => 'payment',
                    // 決済完了後にリダイレクトされるURLを指定します
                    'success_url' => $successUrl,
                    // 決済がキャンセルされた場合にリダイレクトされるURLを指定します
                    'cancel_url' => 'http://localhost/items/$item_id',
                ]);
            }
        } catch (\Stripe\Exception\ApiErrorException $e) {
            dd($e->getMessage(), $e->getHttpBody());
        }
        // Stripeが生成した決済ページのURLにリダイレクトします
        return Redirect::to($checkout_session->url);

        return view('items/index', compact('items', 'ismylist'));
    }
}
