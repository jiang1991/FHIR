<?php

namespace App\Http\Controllers\Order;

use Illuminate\Routing\Controller;
use Auth;
use App\User;
use App\Order;

/**
 * membership: null, trial, prime
 */


class OrderController extends Controller
{
    // 新建一个订单
    public function generate()
    {
        $user = Auth::user();
        $user_id = $user->id;

        $orderJson = file_get_contents("php://input");
        $orderData = json_decode($orderJson);

        $unique_order_id = $orderData->unique_order_id;

        $order = Order::firstOrNew([
            'unique_order_id' => $unique_order_id
        ]);

        $order->user_id = $user_id;
        $order->is_trial = 0;
        $order->period = $orderData->period;
        $order->os = $orderData->os;
        $order->purchase_at = $orderData->purchase_at;
        $order->product_id = $orderData->product_id;
        $order->price = $orderData->price;
        $order->is_consumed = 0;
        $order->json = $orderData->json;
        $order->save();
        
        $res["status"] = "ok";
        $res["order_id"] = $order->id;
        $res["is_consumed"] = $order->is_consumed;

        return response($res)
            ->header('Content-Type', 'application/json');
    }

    // 消耗一个订单
    public function consume() {
        $user = Auth::user();
        $user_id = $user->id;

        $orderJson = file_get_contents("php://input");
        $orderData = json_decode($orderJson);

        $unique_order_id = $orderData->unique_order_id;

        if ($order = Order::where('unique_order_id', $unique_order_id)->first()) {
            
            if ($order->is_consumed == 1) {
                $res["status"] = "error";
                $res["error"] = "order have been consumed";

                return response($res)
                    ->header('Content-Type', 'application/json');
            } else {
                $expire_at = date("Y-m-d");
                if ($expire_at != "" && (strtotime($user->expire_at) > strtotime($expire_at))) {
                    $expire_at = $user->expire_at;
                }

                $expire_at = date("Y-m-d", strtotime($expire_at." +".($order->period)." month"));

                $user->has_trial = 1;
                $user->membership = "prime";
                $user->expire_at = $expire_at;
                $user->save();

                $order->is_consumed = 1;
                $order->save();

                $res["status"] = "ok";
                $res["expire_at"] = $expire_at;

                return response($res)
                    ->header('Content-Type', 'application/json');
            }
            
        } else {
            $res["status"] = "error";
            $res["error"] = "order not found";

            return response($res)
                ->header('Content-Type', 'application/json');
        }

    }

    // 试用
    public function trial() {
        $user = Auth::user();
        $user_id = $user->id;

        if ($user->has_trial) {
            $res["status"] = "error";
            $res["error"] = "Have trailed.";

            return response($res)
                ->header('Content-Type', 'application/json');
        }

        $order = new Order;
        $order->user_id = $user_id;
        $order->is_trial = 1;
        $order->period = 1;
        $order->price = "0 usd";
        $order->is_consumed = 1;
        $order->save();

        $user->has_trial = 1;
        $user->membership = "trial";
        $user->expire_at = date("Y-m-d", strtotime("+1 month"));
        $user->save();

        $res["status"] = "ok";
        $res["membership"] = $user->membership;
        $res["expire_at"] = $user->expire_at;

        return response($res)
            ->header('Content-Type', 'application/json');

    }

    // 查询
    public function query() {
        $user = Auth::user();
        $user_id =  $user->id;

        $orders = Order::where('user_id', $user_id)->get();
        $orderSize = $orders->count();

        $orderList = [];

        foreach ($orders as $o) {
            $order["id"] = $o->id;
            $order["is_trial"] = $o->is_trial;
            $order["period"] = $o->period;
            $order["unique_order_id"] = $o->unique_order_id;
            $order["purchase_at"] = $o->purchase_at;
            $order["price"] = $o->price;

            $orderList[] = $order;
        }

        $res["status"] = "ok";
        $res["userId"] = $user_id;
        $res["orderListSize"] = $orderSize;
        $res["orderList"] = $orderList;

        return response($res)
            ->header('Content-Type', 'application/json');
    }
}
