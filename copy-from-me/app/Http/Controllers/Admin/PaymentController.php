<?php

namespace App\Http\Controllers\Admin;

use App\Events\PaymentEvent;
use App\Events\UserUpdateCreditsEvent;
use App\Http\Controllers\Controller;
use App\Models\PartnerDiscount;
use App\Models\Payment;
use App\Models\User;
use App\Models\ShopProduct;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ExtensionHelper;


class PaymentController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('admin.payments.index')->with([
            'payments' => Payment::paginate(15),
        ]);
    }

    /**
     * @param  Request  $request
     * @param  ShopProduct  $shopProduct
     * @return Application|Factory|View
     */
    public function checkOut(ShopProduct $shopProduct)
    {
        $discount = PartnerDiscount::getDiscount();
        $price = $shopProduct->price - ($shopProduct->price * $discount / 100);

        $paymentGateways = [];
        if ($price > 0) {
            $extensions = ExtensionHelper::getAllExtensionsByNamespace('PaymentGateways');

            // build a paymentgateways array that contains the routes for the payment gateways and the image path for the payment gateway which lays in public/images/Extensions/PaymentGateways with the extensionname in lowercase
            foreach ($extensions as $extension) {
                $extensionName = basename($extension);
                if (!ExtensionHelper::getExtensionConfig($extensionName, 'enabled')) continue; // skip if not enabled

                $payment = new \stdClass();
                $payment->name = ExtensionHelper::getExtensionConfig($extensionName, 'name');
                $payment->image = asset('images/Extensions/PaymentGateways/' . strtolower($extensionName) . '_logo.png');
                $paymentGateways[] = $payment;
            }
        }






        return view('store.checkout')->with([
            'product' => $shopProduct,
            'discountpercent' => $discount,
            'discountvalue' => $discount * $shopProduct->price / 100,
            'discountedprice' => $shopProduct->getPriceAfterDiscount(),
            'taxvalue' => $shopProduct->getTaxValue(),
            'taxpercent' => $shopProduct->getTaxPercent(),
            'total' => $shopProduct->getTotalPrice(),
            'paymentGateways'   => $paymentGateways,
            'productIsFree' => $price <= 0,
        ]);
    }

    /**
     * @param  Request  $request
     * @param  ShopProduct  $shopProduct
     * @return RedirectResponse
     */
    public function handleFreeProduct(ShopProduct $shopProduct)
    {
        /** @var User $user */
        $user = Auth::user();

        //create a payment
        $payment = Payment::create([
            'user_id' => $user->id,
            'payment_id' => uniqid(),
            'payment_method' => 'free',
            'type' => $shopProduct->type,
            'status' => 'paid',
            'amount' => $shopProduct->quantity,
            'price' => $shopProduct->price - ($shopProduct->price * PartnerDiscount::getDiscount() / 100),
            'tax_value' => $shopProduct->getTaxValue(),
            'tax_percent' => $shopProduct->getTaxPercent(),
            'total_price' => $shopProduct->getTotalPrice(),
            'currency_code' => $shopProduct->currency_code,
            'shop_item_product_id' => $shopProduct->id,
        ]);

        event(new UserUpdateCreditsEvent($user));
        event(new PaymentEvent($user, $payment, $shopProduct));

        //not sending an invoice

        //redirect back to home
        return redirect()->route('home')->with('success', __('Your credit balance has been increased!'));
    }

    public function pay(Request $request)
    {
        $product = ShopProduct::find($request->product_id);
        $paymentGateway = $request->payment_method;

        // on free products, we don't need to use a payment gateway
        $realPrice = $product->price - ($product->price * PartnerDiscount::getDiscount() / 100);
        if ($realPrice <= 0) {
            return $this->handleFreeProduct($product);
        }

        return redirect()->route('payment.' . $paymentGateway . 'Pay', ['shopProduct' => $product->id]);
    }

    /**
     * @param  Request  $request
     */
    public function Cancel(Request $request)
    {
        return redirect()->route('store.index')->with('info', 'Payment was Canceled');
    }

    /**
     * @return JsonResponse|mixed
     *
     * @throws Exception
     */
    public function dataTable()
    {
        $query = Payment::with('user');

        return datatables($query)

            ->addColumn('user', function (Payment $payment) {
                return 
                ($payment->user)?'<a class="font-medium text-purple-600 dark:text-purple-500 hover:underline"  href="'.route('admin.users.show', $payment->user->id).'">'.$payment->user->name.'</a>':__('Unknown user');
                
            })
            ->editColumn('price', function (Payment $payment) {
                return $payment->formatToCurrency($payment->price);
            })
            ->editColumn('tax_value', function (Payment $payment) {
                return $payment->formatToCurrency($payment->tax_value);
            })
            ->editColumn('tax_percent', function (Payment $payment) {
                return $payment->tax_percent.' %';
            })
            ->editColumn('total_price', function (Payment $payment) {
                return $payment->formatToCurrency($payment->total_price);
            })

            ->editColumn('created_at', function (Payment $payment) {
                return [
                    'display' => $payment->created_at ? $payment->created_at->diffForHumans() : '',
                    'raw' => $payment->created_at ? strtotime($payment->created_at) : ''
                ];
            })
            ->addColumn('actions', function (Payment $payment) {
                return '<div class="flex items-center text-sm">
                       <a data-content="' . __("Download Invoices") . '" data-toggle="popover" data-trigger="hover" data-placement="top" href="' . route('admin.invoices.downloadSingleInvoice', "id=" . $payment->payment_id) . '" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray" aria-label="Download">
                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                          </a>
                          </div>';
            })
            ->rawColumns(['actions', 'user'])
            ->make(true);
    }
}
