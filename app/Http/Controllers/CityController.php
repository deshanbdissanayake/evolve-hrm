<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CommonModel;

class CityController extends Controller
{
    private $city = null;
    private $common = null;

    public function __construct()
    {
        $this->middleware('permission:view user', ['only' => ['index']]);
        $this->middleware('permission:create user', ['only' => ['create','store']]);
        $this->middleware('permission:update user', ['only' => ['update','edit']]);
        $this->middleware('permission:delete user', ['only' => ['destroy']]);

        $this->city = new City();
        $this->common = new CommonModel();
    }

    public function index()
    {
        $cities = City::all(); // Fetch all students
        return view('cities.index', ['cities' => $cities]);
    }
    public function create(Request $request)
     {
        try {
            return DB::transaction(function () use ($request) {
                $request->validate([
                    'city_name' => 'required',
                    // 'company_id' => 'required',
                ]);
                $data = [
                    'city_name' => $request->city_name,
                    'province_id' => $request->province_id,
                    'status' => 'active',
                    'created_date' => date("Y-m-d H:i:s"),
                    'created_by' => Auth::user()->id,
                ];
                //store the record in the transaction_classes table
                $insertId = $this->city->storeRecord($data);

                if ($insertId) {
                    return response()->json(['message' => 'city  Added Successfully' , 'data' => ['id' => $insertId]], 200);
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
         $student = City::findOrFail($id);
         return 'cities.edit';
     }
 
     
     public function update(Request $request, $id)
     {
        $request->validate([
            'country_name' => 'required',
            // 'company_id' => 'required',
        ]);
        $record = $this->city->getSingleRecord($id);
        if ($record) {
            $data = [
                'city_name' => $request->city_name,
                'province_id' => $request->province_id,
                'status' => $request->status,
                'updated_date' => date("Y-m-d H:i:s"),
                'updated_by' => Auth::user()->id,
            ];
            $this->city->updateRecord($id, $data);
            return response()->json(['message' => 'city Updated Successfully',  'data' => ['id' => $id]], 200);
        } else {
            return response()->json(['message' => 'No city Found', 'data' => []], 404);
        }
     }

     public function show($id)
     {
        $data = $this->city->getSingleRecord($id);
        if ($data) {
            return response()->json(['city' => $data[0]], 200);
        } else {
            return response()->json(['message' => 'No city Found'], 404);
        }
     }

     public function delete($id)
     {
        $record = $this->city->getSingleRecord($id);
        if ($record) {
            $data = [
                'deleted_date' => date("Y-m-d H:i:s"),
                'deleted_by' => Auth::user()->id,
                'status'          => 'delete',
            ];
            $this->city->destroyRecord($id, $data);
            return response()->json(['message' => 'city Deleted Successfully',  'data' => ['id' => $id]], 200);
        } else {
            return response()->json(['message' => 'No city Found', 'data' => []], 404);
        }
     }
}
