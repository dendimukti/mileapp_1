<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Order;
use Carbon\Carbon;


class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $rule;

    public function __construct()
    {
        $this->rule = [
            'customer_name' => 'required|string|min:3|max:100',
            'customer_code' => 'required|string',
            'transaction_amount' => 'required|integer',
            'transaction_discount' => 'required|integer|min:0',
            'transaction_additional_field' => 'string',
            'transaction_payment_type' => 'required|integer',
            'transaction_state' => ['required', Rule::in(['INIT', 'PENDING', 'PAID', 'CANCEL', 'EXPIRE'])],
            'transaction_code' => 'required|string',
            'transaction_order' => 'required|integer',
            'location_id' => 'required|string',
            'organization_id' => 'required|integer',
            'transaction_payment_type_name' => 'required|string',
            'transaction_cash_amount' => 'required|integer|min:0',
            'transaction_cash_change' => 'required|integer|min:0',
    
            'customer_attribute.Nama_Sales' => 'required|string',
            'customer_attribute.TOP' => 'required|string',
            'customer_attribute.Jenis_Pelanggan' => 'required|string',
    
            'connote.connote_id' => 'required|string',
            'connote.connote_number' => 'required|integer',
            'connote.connote_service' => 'required|string',
            'connote.connote_service_price' => 'required|integer',
            'connote.connote_amount' => 'required|integer',
            'connote.connote_code' => 'required|string',
            'connote.connote_booking_code' => 'string',
            'connote.connote_order' => 'required|integer',
            'connote.connote_state' => 'required|string',
            'connote.connote_state_id' => 'required|integer',
            'connote.zone_code_from' => 'required|string',
            'connote.zone_code_to' => 'required|string',
            'connote.surcharge_amount' => 'nullable',
            'connote.transaction_id' => 'required|string',
            'connote.actual_weight' => 'required|integer|min:1|max:100',
            'connote.volume_weight' => 'required|integer|min:0|max:100',
            'connote.chargeable_weight' => 'required|integer',
            'connote.created_at' => 'required|date',
            'connote.updated_at' => 'required|date',
            'connote.organization_id' => 'required|integer',
            'connote.location_id' => 'required|string',
            'connote.connote_total_package' => 'required|integer',
            'connote.connote_surcharge_amount' => 'required|integer|min:0',
            'connote.connote_sla_day' => 'required|integer',
            'connote.location_name' => 'required|string',
            'connote.location_type' => 'required|string',
            'connote.source_tariff_db' => 'required|string',
            'connote.id_source_tariff' => 'required|integer',
            'connote.pod' => 'nullable',
            'connote.history' => 'array',
    
            'connote_id' => 'required|string',
    
            'origin_data.customer_name' => 'required|string',
            'origin_data.customer_address' => 'required|string',
            'origin_data.customer_email' => 'required|email',
            'origin_data.customer_phone' => 'required|string',
            'origin_data.customer_address_detail' => 'string|nullable',
            'origin_data.customer_zip_code' => 'required|string',
            'origin_data.zone_code' => 'required|string',
            'origin_data.organization_id' => 'required|integer',
            'origin_data.location_id' => 'required|string',
    
            'destination_data.customer_name' => 'required|string',
            'destination_data.customer_address' => 'required|string',
            'destination_data.customer_email' => 'email|nullable',
            'destination_data.customer_phone' => 'required|string',
            'destination_data.customer_address_detail' => 'string|nullable',
            'destination_data.customer_zip_code' => 'required|string',
            'destination_data.zone_code' => 'required|string',
            'destination_data.organization_id' => 'required|integer',
            'destination_data.location_id' => 'required|string',
    
            'koli_data' => 'present|array',
            'koli_data.*.koli_length' => 'required|integer',
            'koli_data.*.awb_url' => 'required|url',
            'koli_data.*.created_at' => 'required|date',
            'koli_data.*.koli_chargeable_weight' => 'required|integer',
            'koli_data.*.koli_width' => 'required|integer',
            'koli_data.*.koli_surcharge' => 'array',
            'koli_data.*.koli_height' => 'required|integer',
            'koli_data.*.updated_at' => 'required|date',
            'koli_data.*.koli_description' => 'required|string',
            'koli_data.*.koli_formula_id' => 'nullable',
            'koli_data.*.connote_id' => 'required|string',
            'koli_data.*.koli_volume' => 'required|integer',
            'koli_data.*.koli_weight' => 'required|integer',
            'koli_data.*.koli_id' => 'required|string',
            'koli_data.*.koli_custom_field' => 'required',
            'koli_data.*.koli_custom_field.awb_sicepat' => 'nullable',
            'koli_data.*.koli_custom_field.harga_barang' => 'nullable',
            'koli_data.*.koli_code' => 'required|string',
    
            'custom_field.catatan_tambahan' => 'required|string',
    
            'currentLocation.name' => 'required|string',
            'currentLocation.code' => 'required|string',
            'currentLocation.type' => 'required|string',
        ];
    }

    //
    public function getOrders(Request $request)
    {
        $orders = [];

        try {
            $orders = Order::orderBy('created_at', 'desc')->limit(10)->get();
        } catch (Exception $e) {
            $status = 500;
            return response()->json([
                'metadata' => [
                    'status' => $status,
                    'message' => $e->getMessage(),
                ],
            ], $status);
        }

        if ($orders === null) {
            $status = 404;
            return response()->json([
                'metadata' => [
                    'status' => $status,
                    'message' => 'Data not found',
                ],
            ], $status);
        }

        $status = 200;
        return response()->json([
            'data' => $orders,
            'metadata' => [
                'status' => $status,
                'message' => 'Data found',
            ],
        ], $status);
    }

    public function getOrder(Request $request)
    {
        try {
            $order = Order::where('transaction_id', $request->id)->limit(1)->get();
        } catch (Exception $e) {
            $status = 500;
            return response()->json([
                'metadata' => [
                    'status' => $status,
                    'message' => $e->getMessage(),
                ],
            ], $status);
        }

        if (count($order) <= 0) {
            $status = 404;
            return response()->json([
                'metadata' => [
                    'status' => $status,
                    'message' => 'Data not found',
                ],
            ], $status);
        }

        $status = 200;
        return response()->json([
            'data' => $order[0],
            'metadata' => [
                'status' => $status,
                'message' => 'Data found',
            ],
        ], $status);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rule);
        if ($validator->fails()) {
            $status = 400;
            return response()->json([
                'metadata' => [
                    'status' => $status,
                    'message' => $validator->errors(),
                ],
            ], $status);
        }

        try {
            $order = new Order();

            $curTime = Carbon::now();
            $order->transaction_id = (string) Str::uuid();
            $order->customer_name = $request->customer_name;
            $order->customer_code = $request->customer_code;
            $order->transaction_amount = $request->transaction_amount;
            $order->transaction_discount = $request->transaction_discount;
            $order->transaction_additional_field = $request->transaction_additional_field;
            $order->transaction_payment_type = $request->transaction_payment_type;
            $order->transaction_state = $request->transaction_state;
            $order->transaction_code = $request->transaction_code;
            $order->transaction_order = $request->transaction_order;
            $order->location_id = $request->location_id;
            $order->organization_id = $request->organization_id;
            $order->created_at = $curTime;
            $order->updated_at = $curTime;
            $order->transaction_payment_type_name = $request->transaction_payment_type_name;
            $order->transaction_cash_amount = $request->transaction_cash_amount;
            $order->transaction_cash_change = $request->transaction_cash_change;
            $order->customer_attribute = $request->customer_attribute;
            $order->connote = $request->connote;
            $order->connote_id = $request->connote_id;
            $order->origin_data = $request->origin_data;
            $order->destination_data = $request->destination_data;
            $order->koli_data = $request->koli_data;
            $order->custom_field = $request->custom_field;
            $order->currentLocation = $request->currentLocation;
            $order->save();
        } catch (Exception $e) {
            $status = 500;
            return response()->json([
                'metadata' => [
                    'status' => $status,
                    'message' => $e->getMessage(),
                ],
            ], $status);
        }

        $status = 201;
        return response()->json([
            'data' => $order,
            'metadata' => [
                'status' => $status,
                'message' => 'Data Created',
            ],
        ], $status);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rule);
        if ($validator->fails()) {
            $status = 400;
            return response()->json([
                'metadata' => [
                    'status' => $status,
                    'message' => $validator->errors(),
                ],
            ], $status);
        }

        try {
            $order = Order::where('transaction_id', $request->id)->limit(1)->get();
        } catch (Exception $e) {
            $status = 500;
            return response()->json([
                'metadata' => [
                    'status' => $status,
                    'message' => $e->getMessage(),
                ],
            ], $status);
        }

        if (count($order) <= 0) {
            $status = 404;
            return response()->json([
                'metadata' => [
                    'status' => $status,
                    'message' => 'Data not found',
                ],
            ], $status);
        }

        try {
            $order = $order[0];
            $order->customer_name = $request->customer_name;
            $order->customer_code = $request->customer_code;
            $order->transaction_amount = $request->transaction_amount;
            $order->transaction_discount = $request->transaction_discount;
            $order->transaction_additional_field = $request->transaction_additional_field;
            $order->transaction_payment_type = $request->transaction_payment_type;
            $order->transaction_state = $request->transaction_state;
            $order->transaction_code = $request->transaction_code;
            $order->transaction_order = $request->transaction_order;
            $order->location_id = $request->location_id;
            $order->organization_id = $request->organization_id;
            $order->updated_at = Carbon::now();
            $order->transaction_payment_type_name = $request->transaction_payment_type_name;
            $order->transaction_cash_amount = $request->transaction_cash_amount;
            $order->transaction_cash_change = $request->transaction_cash_change;
            $order->customer_attribute = $request->customer_attribute;
            $order->connote = $request->connote;
            $order->connote_id = $request->connote_id;
            $order->origin_data = $request->origin_data;
            $order->destination_data = $request->destination_data;
            $order->koli_data = $request->koli_data;
            $order->custom_field = $request->custom_field;
            $order->currentLocation = $request->currentLocation;
            $order->save();
        } catch (Exception $e) {
            $status = 500;
            return response()->json([
                'metadata' => [
                    'status' => $status,
                    'message' => $e->getMessage(),
                ],
            ], $status);
        }

        $status = 200;
        return response()->json([
            'data' => $order,
            'metadata' => [
                'status' => $status,
                'message' => 'Data Updated',
            ],
        ], $status);
    }

    public function updateState(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_state' => ['required', Rule::in(['INIT', 'PENDING', 'PAID', 'CANCEL', 'EXPIRE'])],
        ]);

        if ($validator->fails()) {
            $status = 400;
            return response()->json([
                'metadata' => [
                    'status' => $status,
                    'message' => $validator->errors(),
                ],
            ], $status);
        }
        
        try {
            $order = Order::where('transaction_id', $request->id)->limit(1)->get();
        } catch (Exception $e) {
            $status = 500;
            return response()->json([
                'metadata' => [
                    'status' => $status,
                    'message' => $e->getMessage(),
                ],
            ], $status);
        }

        if (count($order) <= 0) {
            $status = 404;
            return response()->json([
                'metadata' => [
                    'status' => $status,
                    'message' => 'Data not found',
                ],
            ], $status);
        }

        try {
            $order = $order[0];
            $order->transaction_state = $request->transaction_state;
            $order->updated_at = Carbon::now();
            $order->save();
        } catch (Exception $e) {
            $status = 500;
            return response()->json([
                'metadata' => [
                    'status' => $status,
                    'message' => $e->getMessage(),
                ],
            ], $status);
        }

        $status = 200;
        return response()->json([
            'data' => $order,
            'metadata' => [
                'status' => $status,
                'message' => 'Data Updated',
            ],
        ], $status);
    }

    public function delete(Request $request)
    {
        try {
            $order = Order::where('transaction_id', $request->id)->get();
        } catch (Exception $e) {
            $status = 500;
            return response()->json([
                'metadata' => [
                    'status' => $status,
                    'message' => $e->getMessage(),
                ],
            ], $status);
        }

        if (count($order) <= 0) {
            $status = 404;
            return response()->json([
                'metadata' => [
                    'status' => $status,
                    'message' => 'Data not found',
                ],
            ], $status);
        }

        try {
            $order = $order[0];
            $order->delete();
        } catch (Exception $e) {
            $status = 500;
            return response()->json([
                'metadata' => [
                    'status' => $status,
                    'message' => $e->getMessage(),
                ],
            ], $status);
        }

        $status = 200;
        return response()->json([
            'metadata' => [
                'status' => $status,
                'message' => 'Data deleted successfully',
            ],
        ], $status);
    }
}
