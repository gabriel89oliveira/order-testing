<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\Order;
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
        $order_items = collect($request->items)->groupBy('id');
        
        $list_of_items = collect();

        foreach($order_items as $key => $item) {

            $single_item = collect();

            // Populate the sub collection
            $single_item->put('id', $item[0]['id']);
            $single_item->put('code', $item[0]['code']);
            $single_item->put('name', $item[0]['name']);
            $single_item->put('unit_price', $item[0]['unit_price']);
            $single_item->put('unit_price_value', $item[0]['unit_price_value']);
            $single_item->put('quantity', count($item));
            $single_item->put('total_amount', $item[0]['unit_price_value'] * count($item));

            // Populate final collection
            $order_items->put($item[0]['id'], $single_item);

        }

        // Total amount of order
        $total_amount_without_discount = $order_items->sum('total_amount');

        // Rule for discount (5 < items < 9)
        $discount = false;
        foreach($order_items as $item){
            if($item['quantity'] >= 5 And $item['quantity'] <= 9){
                $discount = true;
            }
        }

        // Check if discount is valid
        if($discount == true And $total_amount_without_discount >= 500){
            $total_amount_with_discount = $total_amount_without_discount * 0.85;
        }else{
            $total_amount_with_discount = $total_amount_without_discount;
        }

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
