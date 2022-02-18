<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index(){
        $orders = Order::where('status','0')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function view($id){
        $orders = Order::where('id',$id)->first();
        return view('admin.orders.view',compact('orders'));
    }

    public function update(Request $req, $id){
        $orders = Order::find($id);
        $orders->status = $req->input('order_status');
        $orders->update();
        return back()->with('status','Order updated');
    }


    public function orderHistory(){
        $orders = Order::where('status','1')->get();
        return view('admin.orders.history',compact('orders'));
    }
}
