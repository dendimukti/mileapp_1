<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Order extends Model
{
    
    protected $connection = 'mongodb';
    protected $collection = 'order';
    protected $guarded = [];
    protected $visible = [
        '_id',
        'transaction_id',
        'customer_name',
        'customer_code',
        'transaction_amount',
        'transaction_discount',
        'transaction_additional_field',
        'transaction_payment_type',
        'transaction_state',
        'transaction_code',
        'transaction_order',
        'location_id',
        'organization_id',
        // 'created_at',
        // 'updated_at',
        'transaction_payment_type_name',
        'transaction_cash_amount',
        'transaction_cash_change',
        'customer_attribute',
        'connote',
        'connote_id',
        'origin_data',
        'destination_data',
        'koli_data',
        'custom_field',
        'currentLocation',
    ];
}