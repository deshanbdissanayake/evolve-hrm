<?php

namespace App\Http\Controllers;

use App\Models\company;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CommonModel;

class CompanyController extends Controller
{
    private $company = null;
    private $common = null;

    public function __construct()
    {
        $this->middleware('permission:view user', ['only' => ['index']]);
        $this->middleware('permission:create user', ['only' => ['create','store']]);
        $this->middleware('permission:update user', ['only' => ['update','edit']]);
        $this->middleware('permission:delete user', ['only' => ['destroy']]);

        $this->company = new company();
        $this->common = new CommonModel();
    }

    public function index()
    {
        $companies = company::all(); // Fetch all students
        return view('industry.index', ['companies' => $companies]);
    }

    public function create(Request $request)
    {
       try {
           return DB::transaction(function () use ($request) {
               $request->validate([
                   'company_name' => 'required',
               ]);
               $data = [

                    'company_name'        => $request->company_name,
                    'company_short_name'  => $request->company_short_name,
                    'industry_id'         => $request->industry_id,
                    'business_reg_no'     => $request->business_reg_no,
                    'address_1'           => $request->address_1,
                    'address_2'           => $request->address_2,
                    'city_id'             => $request->city_id,
                    'province_id'         => $request->province_id,
                    'country_id'          => $request->country_id,
                    'postal_code'         => $request->postal_code,
                    'contact_1'           => $request->contact_1,
                    'contact_2'           => $request->contact_2,
                    'email'               => $request->email,
                    'epf_reg_no'          => $request->epf_reg_no,
                    'tin_no'              => $request->tin_no,
                    'admin_contact_id'    => $request->admin_contact_id,
                    'billing_contact_id'  => $request->billing_contact_id,
                    'primary_contact_id'  => $request->primary_contact_id,
                    'logo'                => $request->logo,
                    'logo_small'          => $request->logo_small,
                    'website'             => $request->website,
                    'status'              => 'active',

                    'created_at'          => date("Y-m-d H:i:s"),
                    'created_by'          => Auth::user()->id,
               ];
               //store the record in the transaction_classes table
               if($request->file(key:'image'))
               {
                    $path = $request->file(key:'image')->store(path:'company');
               }

               $insertId = $this->company->storeRecord($data);

               if ($insertId) {
                   return response()->json(['message' => 'company  Added Successfully' , 'data' => ['id' => $insertId]], 200);
               } else {
                   return response()->json(['message' => 'Error storing record', 'data' => [], 'error_code' => 500], 500);
               }
           });
       } catch (\Illuminate\Database\QueryException $e) {
           return response()->json(['message' => 'Error occurred due to ' . $e->getMessage(), 'error_code' => 500], 500);
       }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'company_name' => 'required',
        ]);
        $record = $this->company->getSingleRecord($id);
        if ($record) {
            $data = [
                'company_name'        => $request->company_name,
                'company_short_name'  => $request->company_short_name,
                'industry_id'         => $request->industry_id,
                'business_reg_no'     => $request->business_reg_no,
                'address_1'           => $request->address_1,
                'address_2'           => $request->address_2,
                'city_id'             => $request->city_id,
                'province_id'         => $request->province_id,
                'country_id'          => $request->country_id,
                'postal_code'         => $request->postal_code,
                'contact_1'           => $request->contact_1,
                'contact_2'           => $request->contact_2,
                'email'               => $request->email,
                'epf_reg_no'          => $request->epf_reg_no,
                'tin_no'              => $request->tin_no,
                'admin_contact_id'    => $request->admin_contact_id,
                'billing_contact_id'  => $request->billing_contact_id,
                'primary_contact_id'  => $request->primary_contact_id,
                'logo'                => $request->logo,
                'logo_small'          => $request->logo_small,
                'website'             => $request->website,
                'status'              => 'active',

                'updated_date' => date("Y-m-d H:i:s"),
                'updated_by' => Auth::user()->id,
            ];
            $this->company->updateRecord($id, $data);
            return response()->json(['message' => 'Company Updated Successfully',  'data' => ['id' => $id]], 200);
        } else {
            return response()->json(['message' => 'No Company Found', 'data' => []], 404);
        }
    }

    public function show($id)
    {
        $data = $this->company->getSingleRecord($id);
        if ($data) {
            return response()->json(['Company' => $data[0]], 200);
        } else {
            return response()->json(['message' => 'No Company Found'], 404);
        }
    }

    public function delete($id)
    {
        $record = $this->company->getSingleRecord($id);
        if ($record) {
            $data = [
                'deleted_date'    => date("Y-m-d H:i:s"),
                'deleted_by'      => Auth::user()->id,
                'status'          => 'delete',
            ];
            $this->company->destroyRecord($id, $data);
            return response()->json(['message' => 'Company Deleted Successfully',  'data' => ['id' => $id]], 200);
        } else {
            return response()->json(['message' => 'No Company Found', 'data' => []], 404);
        }
    }
}
