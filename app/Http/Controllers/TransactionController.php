<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\TrServiceH;
use App\Models\TrServiceD;
use App\Models\Customers;
use App\Models\Services;
use Auth;
use DB;
use Carbon\Carbon;
use DataTables;

class TransactionController extends Controller
{
    //
    public function __construct(TrServiceH $h, TrServiceD $d) {
        $this->h = $h;
        $this->d = $d;
    }

    private function validationRules() {
        $rules = [
            'customer_id' => 'required',
            'dp' => 'required',
            'laptop' => 'required',
            'case' => 'required',
            'services.*' => 'required',
            'prices.*' => 'required|numeric'
        ];
        return $rules;
    }

    public function index() {
        return view('transaction/index');
    }

    public function create(Request $request) {

        if ($request->isMethod('post')) {
            $input = $request->all();
            $validation = Validator::make($input, $this->validationRules());
            if ($validation->fails())
                return redirect()->back()->withInput()->withErrors($validation->errors());
            
            $insertTransaction = $this->createTransaction($input);
            if ($insertTransaction['result'])
                return redirect('transaction')->with('success', 'Transaction created!');
        }


        $customers = $this->getOptionCustomers();
        // $services = $this->getOptionServices();
        $services = Services::where('status', '00')->get();
        return view('transaction/form', compact('customers', 'services'));
    }

    private function getOptionCustomers() {
        $customers = Customers::select('id', 'customer')->where('status', '00')->get();
        $type_options = [];
        foreach ($customers as $customer) {
            $type_options[$customer->id] = $customer->customer;
        }
        return $type_options;
    }

    private function getOptionServices() {
        $services = Services::select('id', 'service')->where('status', '00')->get();
        $type_options = [];
        foreach ($services as $service) {
            $type_options[$service->id] = $service->service;
        }
        return $type_options;
    }

    private function createTransaction($request) {
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
            'message' => 'Transaction created!'
        ];
        
    }

    public function getTransaction() {
        $data = $this->h->select(
            'tr_service_h.id',
            'tr_service_h.date_time',
            'tr_service_h.service_code',
            'ms_customers.customer',
            'ms_customers.telp',
            'tr_service_h.laptop',
            'tr_service_h.case'
            )
            ->join('ms_customers', 'tr_service_h.customer_id', '=', 'ms_customers.id')
            ->orderBy('date_time', 'DESC')
            ->get();
        return Datatables::of($data)
                            ->addColumn('action', function($row){
                                $btn = '<a href="'.url('transaction/view').'/'.$row->id.'" class="edit btn btn-primary btn-sm">View</a>';
                                $btn = $btn.' <a href="'.url('transaction/finish').'/'.$row->id.'" class="btn btn-danger btn-sm">Finish</a>';
                                return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
    }
}
