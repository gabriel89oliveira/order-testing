<?php

namespace App\Traits;

trait OrderTrait
{

    /**
     * Calculate discount based on following rule
     * 
     * 1) Total amount of order >500
     * 2) If any item quantity is between 5 and 9
     * 
     */
    public static function discount($order_items)
    {

        // Value of discount if applicable
        $discount_value = 0.15;

        // Validator
        $discount = false;

        // Check amount of items
        foreach($order_items as $item){
            if($item['quantity'] >= 5 And $item['quantity'] <= 9){
                $discount = true;
            }
        }

        // Check if discount is valid
        if($discount == true And $order_items->sum('total_amount') >= 500){
            return (1 - $discount_value);
        }else{
            return 1;
        }

    }


    /**
     * Sort input to manipulate it
     * in the next steps
     * 
     */
    public static function sort($items)
    {

        $order_items = collect($items)->groupBy('id');
        
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

        return $order_items;

    }

}