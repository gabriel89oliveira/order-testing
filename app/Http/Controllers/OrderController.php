<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\Order;
use App\Traits\OrderTrait;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        // Group order by item
        $order_items = OrderTrait::sort($request->items);
        
        // Total amount of order
        $total_amount_without_discount = $order_items->sum('total_amount');

        // Rule for discount
        $discount = OrderTrait::discount($order_items);

        // Total amount with discount
        $total_amount_with_discount = $total_amount_without_discount * $discount;

        // Create order
        $order = new Order;
        $order->user_id = Auth::user()->id;
        $order->date = Carbon::now()->format('Y-m-d');
        $order->total_amount_without_discount = $total_amount_without_discount;
        $order->total_amount_with_discount = $total_amount_with_discount;
        $order->save();

        $order->code = Carbon::parse($order->date)->format('Y-m-') . $order->id;
        $order->save();

        // Sync order with articles
        foreach($order_items as $key => $item){
            $order_items[$key] = $item->only('quantity');
        }

        $order->articles()->sync($order_items);

        // Return response
        return response()->json([
            'order' => $order,
            'message' => 'Ordem criada com sucesso.'
        ], Response::HTTP_OK);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
