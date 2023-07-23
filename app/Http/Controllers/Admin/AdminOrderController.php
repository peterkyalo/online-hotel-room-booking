<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('admin.orders', compact('orders'));
    }

    public function invoice($id)
    {
        $order = Order::where('id', $id)->first();
        $order_detail = OrderDetail::where('order_id', $id)->get();
        $customer_data = Customer::where('id', $order->customer_id)->first();
        return view('admin.invoice', compact('order', 'order_detail', 'customer_data'));
    }

    public function delete($id)
    {
        $obj = Order::where('id', $id)->delete();
        // $obj->delete();
        $obj = OrderDetail::where('order_id', $id)->delete();
        // $obj->delete();

        return redirect()->back()->with('success', 'Order has been deleted successfully');
    }
}