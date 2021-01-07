<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Order;
use Carbon\Carbon;


class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $rule = [
        'customer_name' => 'required|string',
        'customer_code' => 'required|string',
        'transaction_amount' => 'required|integer',
        'transaction_discount' => 'required|integer|min:0',
        'transaction_additional_field' => 'required|string',
        'transaction_payment_type' => 'required|integer',
        'transaction_state' => ['required', Rule::in(['INIT', 'PENDING', 'PAID', 'CANCEL', 'EXPIRE'])],
        'transaction_code' => 'required|string',
        'transaction_order' => 'required|integer',
        'location_id' => 'required|integer',
        'organization_id' => 'required|string',
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
        'connote.connote_booking_code' => 'required|string',
        'connote.connote_order' => 'required|integer',
        'connote.connote_state' => 'required|string',
        'connote.connote_state_id' => 'required|string',
        'connote.zone_code_from' => 'required|string',
        'connote.zone_code_to' => 'required|string',
        'connote.surcharge_amount' => 'required|string|nullable',
        'connote.transaction_id' => 'required|string',
        'connote.actual_weight' => 'required|integer',
        'connote.volume_weight' => 'required|integer|min:0',
        'connote.chargeable_weight' => 'required|integer',
        'connote.created_at' => 'required|date',
        'connote.updated_at' => 'required|date',
        'connote.organization_id' => 'required|string',
        'connote.location_id' => 'required|string',
        'connote.connote_total_package' => 'required|integer',
        'connote.connote_surcharge_amount' => 'required|integer|min:0',
        'connote.connote_sla_day' => 'required|integer',
        'connote.location_name' => 'required|string',
        'connote.location_type' => 'required|string',
        'connote.source_tariff_db' => 'required|string',
        'connote.id_source_tariff' => 'required|integer',
        'connote.pod' => 'required|string|nullable',
        'connote.history' => 'required|array',

        'connote_id' => 'required|string',

        'origin_data.customer_name' => 'required|string',
        'origin_data.customer_address' => 'required|string',
        'origin_data.customer_email' => 'required|email',
        'origin_data.customer_phone' => 'required|string',
        'origin_data.customer_address_detail' => 'required|string|nullable',
        'origin_data.customer_zip_code' => 'required|string',
        'origin_data.zone_code' => 'required|string',
        'origin_data.organization_id' => 'required|integer',
        'origin_data.location_id' => 'required|string',

        'destination_data.customer_name' => 'required|string',
        'destination_data.customer_address' => 'required|string',
        'destination_data.customer_email' => 'required|email|nullable',
        'destination_data.customer_phone' => 'required|string',
        'destination_data.customer_address_detail' => 'required|string|nullable',
        'destination_data.customer_zip_code' => 'required|string',
        'destination_data.zone_code' => 'required|string',
        'destination_data.organization_id' => 'required|integer',
        'destination_data.location_id' => 'required|string',

        'custom_field.catatan_tambahan' => 'required|string',

        'currentLocation.name' => 'required|string',
        'currentLocation.code' => 'required|string',
        'currentLocation.type' => 'required|string',

    ];

    public function __construct()
    {
        //
    }

    //
    public function getOrders(Request $request) {
        $data = Order::orderBy('created_at', 'desc')->get();

        return response()->json($data);
    }

    public function getOrder(Request $request) {
        $data = Order::where('transaction_id', $request->id)->get();
        
        return response()->json($data, 200);
    }

    public function postOrder(Request $request) {
        
        $data = $request;
        $validator = Validator::make($request->all(), $this->rule);

        if ($validator->fails()) {
            $res['IS_SUCCESS'] = false;
            $res['MESSAGE'] = 'Invalid Parameter';
            $res['ERRORS'] = $validator->errors();
            return response()->json($res);
        }

        $data['transaction_id'] = (string) Str::uuid();
        $curTime = Carbon::now();

	// "created_at": "2020-07-15T11:11:12+0700",
	// "updated_at": "2020-07-15T11:11:22+0700",
    // "created_at": "2021-01-07T07:38:57.865058Z",
    // "updated_at": "2021-01-07T07:38:57.865058Z",
		$data['created_at'] = $curTime;
		$data['updated_at'] = $curTime;
        return response()->json($data);
    }

    public function putOrder(Request $request) {
        return "putOrder";
    }

    public function patchOrder(Request $request) {
        return "patchOrder";
    }

    public function delOrder(Request $request) {
        return "delOrder";
    }

}
