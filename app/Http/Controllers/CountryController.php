<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CommonModel;

class CountryController extends Controller
{
    private $country = null;
    private $common = null;

    public function __construct()
    {
        $this->middleware('permission:view user', ['only' => ['index']]);
        $this->middleware('permission:create user', ['only' => ['create','store']]);
        $this->middleware('permission:update user', ['only' => ['update','edit']]);
        $this->middleware('permission:delete user', ['only' => ['destroy']]);

        $this->country = new Country();
        $this->common = new CommonModel();
    }

    public function index()
    {
        $countries = Country::all(); // Fetch all students
        return view('countries.index', ['countries' => $countries]);
    }
    public function create(Request $request)
     {
        try {
            return DB::transaction(function () use ($request) {
                $request->validate([
                    'country_name' => 'required',
                    // 'company_id' => 'required',
                ]);
                $data = [
                    'country_name' => $request->country_name,
                    'country_code' => $request->country_code,
                    'status' => 'active',
                    'created_date' => date("Y-m-d H:i:s"),
                    'created_by' => Auth::user()->id,
                ];
                //store the record in the transaction_classes table
                $insertId = $this->country->storeRecord($data);

                if ($insertId) {
                    return response()->json(['message' => 'country  Added Successfully' , 'data' => ['id' => $insertId]], 200);
                } else {
                    return response()->json(['message' => 'Error storing record', 'data' => [], 'error_code' => 500], 500);
                }
            });
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'Error occurred due to ' . $e->getMessage(), 'error_code' => 500], 500);
        }
     }

     public function edit($id)
     {
         $student = Country::findOrFail($id);
         return 'countries.edit';
     }
 
     
     public function update(Request $request, $id)
     {
        $request->validate([
            'country_name' => 'required',
            // 'company_id' => 'required',
        ]);
        $record = $this->country->getSingleRecord($id);
        if ($record) {
            $data = [
                'country_name' => $request->country_name,
                'country_code' => $request->country_code,
                'status' => $request->status,
                'updated_date' => date("Y-m-d H:i:s"),
                'updated_by' => Auth::user()->id,
            ];
            $this->country->updateRecord($id, $data);
            return response()->json(['message' => 'Department Updated Successfully',  'data' => ['id' => $id]], 200);
        } else {
            return response()->json(['message' => 'No Department Found', 'data' => []], 404);
        }
     }

     public function show($id)
     {
        $data = $this->country->getSingleRecord($id);
        if ($data) {
            return response()->json(['country' => $data[0]], 200);
        } else {
            return response()->json(['message' => 'No industry Found'], 404);
        }
     }

     public function delete($id)
     {
        $record = $this->country->getSingleRecord($id);
        if ($record) {
            $data = [
                'deleted_date' => date("Y-m-d H:i:s"),
                'deleted_by' => Auth::user()->id,
                'status'          => 'delete',
            ];
            $this->country->destroyRecord($id, $data);
            return response()->json(['message' => 'country Deleted Successfully',  'data' => ['id' => $id]], 200);
        } else {
            return response()->json(['message' => 'No country Found', 'data' => []], 404);
        }
     }
}
