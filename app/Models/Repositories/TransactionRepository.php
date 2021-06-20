<?php

namespace App\Models\Repositories;

use App\Models\TrServiceD;
use App\Models\TrServiceH;
use App\Models\Customers;
use App\Models\Services;
use Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DataTables;

class TransactionRepository extends Model
{
    use HasFactory;

    public function __construct(TrServiceH $h, TrServiceD $d) {
        $this->h = $h;
        $this->d = $d;
    }

    public function getOptionCustomers() {
        $customers = Customers::select('id', 'customer')->where('status', '00')->get();
        $type_options = [];
        foreach ($customers as $customer) {
            $type_options[$customer->id] = $customer->customer;
        }
        return $type_options;
    }

    public function getOptionServices() {
        $services = Services::select('id', 'service')->where('status', '00')->get();
        $type_options = [];
        foreach ($services as $service) {
            $type_options[$service->id] = $service->service;
        }
        return $type_options;
    }

    public function createTransaction($request) {
        $randomText = rand(1000,9999).'-';
        $code = "SERV-".$randomText.date("mdY");
        $prices = $request['prices'];
        $services = $request['services'];
        $details = [];
        $realPrice = [];

        for ($i = 0; $i < count($services); $i++) {
            $price = $prices[$i];
            $service = $services[$i];
            $serviceObj = Services::find($service);
            $type = $serviceObj->service_type_id;
            if ($price  == 0 || $price == null) {
                $price = $serviceObj->price;
            }
            $detail = [
                'service' => $service,
                'price' => $price,
                'type' => $type
            ];
            array_push($details, $detail);
            array_push($realPrice, $price);
        }
        
        $headerPrice = array_sum($realPrice);
        $userId = Auth::user()->id;
        
        DB::beginTransaction();
        try {
            // insert header
            $h = $this->h;
            $h->service_code = $code;
            $h->user_id = Auth::user()->id;
            $h->customer_id = $request['customer_id'];
            $h->total_price = $headerPrice;
            $h->down_payment = $request['dp'];
            $h->date_time = Carbon::now();
            $h->laptop = $request['laptop'];
            $h->case = $request['case'];
            $h->save();

            //insert detail
            $dataDetail = [];
            foreach ($details as $detail) {
                $d = $this->d;
                $d->create([
                    'service_h_id' => $h->id,
                    'service_id' => $detail['service'],
                    'service_type_id' => $detail['type'],
                    'price' => $detail['price']
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'result' => false,
                'message' => $e->getMessage()
            ];
        }
        
        return [
            'result' => true,
            'code' => $h->service_code,
            'message' => 'Transaction created!'
        ];
        
    }

    public function getAllTransaction() {
        $data = $this->h->select(
            'tr_service_h.id',
            'tr_service_h.date_time',
            'tr_service_h.service_code',
            'ms_customers.customer',
            'ms_customers.telp',
            'tr_service_h.laptop',
            'tr_service_h.case',
            'tr_service_h.service_status',
            )
            ->join('ms_customers', 'tr_service_h.customer_id', '=', 'ms_customers.id')
            ->where('tr_service_h.service_status', '00')
            ->orderBy('date_time', 'DESC')
            ->get();
        return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('status', function($row){
                                return $row->service_status == '00' ? 'Dalam Proses' : 'Selesai';
                            })
                            ->addColumn('action', function($row){
                                $btn = '<a href="'.url('transaction/view').'/'.$row->id.'" class="edit btn btn-primary btn-sm">View</a>';
                                $btn = $btn.' <a href="'.url('transaction/finish').'/'.$row->id.'" class="btn btn-danger btn-sm">Finish</a>';
                                return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
    }

    public function getTransaction($id) {
        $dataH = $this->h->select(
            'tr_service_h.id',
            'tr_service_h.service_code',
            'tr_service_h.total_price',
            'tr_service_h.down_payment',
            'tr_service_h.date_time',
            'tr_service_h.service_status',
            'tr_service_h.laptop',
            'tr_service_h.case',
            'users.name',
            'ms_customers.customer',
            'ms_customers.telp',
            'ms_customers.address',
            'ms_customers.address'
        )
        ->join('users', 'users.id', '=', 'tr_service_h.user_id')
        ->join('ms_customers', 'ms_customers.id', '=', 'tr_service_h.customer_id')
        ->where('tr_service_h.id', $id)
        ->first();

        return $dataH;
    }

    public function getTransactionDetail($id) {
        $dataD = $this->d->select(
            'tr_service_d.service_h_id',
            'tr_service_d.price',
            'ms_services.service',
            'ms_service_types.type'
        )
        ->join('ms_services', 'ms_services.id', '=', 'tr_service_d.service_id')
        ->join('ms_service_types', 'ms_service_types.id', '=', 'tr_service_d.service_type_id')
        ->where('tr_service_d.service_h_id', $id)
        ->get();
        
        return $dataD;
    }

    public function finishService($id) {
        $h = $this->h->find($id);
        $h->service_status = '01';
        $h->save();
        return true;
    }

    public function getReport($request) {

        $data = $this->h->select(
            'tr_service_h.*',
            'ms_customers.customer',
            'ms_customers.telp'
            )
            ->join('ms_customers', 'tr_service_h.customer_id', '=', 'ms_customers.id')
            ->where('tr_service_h.service_status', '01');
            if (isset($request['date_start']) && isset($request['date_end'])) {
                $data = $data->where('date_time', '>=', $request['date_start'].' 00:00:00')
                            ->where('date_time', '<=', $request['date_end'].' 23:59:59');
            }
            
            $date = $data->orderBy('date_time', 'DESC')
                        ->get();
        return Datatables::of($data)
                            ->addIndexColumn()
                            ->make(true);
    }
}
