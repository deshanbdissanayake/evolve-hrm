<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CommonModel;

class ProvinceController extends Controller
{
    private $province = null;
    private $common = null;

    public function __construct()
    {
        $this->middleware('permission:view user', ['only' => ['index']]);
        $this->middleware('permission:create user', ['only' => ['create','store']]);
        $this->middleware('permission:update user', ['only' => ['update','edit']]);
        $this->middleware('permission:delete user', ['only' => ['destroy']]);

        $this->province = new Province();
        $this->common = new CommonModel();
    }

    public function index()
    {
        $provinces = Province::all(); // Fetch all students
        return view('provinces.index', ['provinces' => $provinces]);
    }
    public function create(Request $request)
     {
        try {
            return DB::transaction(function () use ($request) {
                $request->validate([
                    'province_name' => 'required',
                ]);
                $data = [
                    'province_name' => $request->province_name,
                    'country_id' => $request->country_id,
                    'status' => 'active',
                    'created_date' => date("Y-m-d H:i:s"),
                    'created_by' => Auth::user()->id,
                ];
                //store the record in the transaction_classes table
                $insertId = $this->province->storeRecord($data);

                if ($insertId) {
                    return response()->json(['message' => 'currency  Added Successfully' , 'data' => ['id' => $insertId]], 200);
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
         $student = Province::findOrFail($id);
         return 'provinces.edit';
     }
 
     
     public function update(Request $request, $id)
     {
        $request->validate([
            'province_name' => 'required',
        ]);
        $record = $this->province->getSingleRecord($id);
        if ($record) {
            $data = [
                'province_name' => $request->province_name,
                'country_id' => $request->country_id,
                'status' => 'active',
                'updated_date' => date("Y-m-d H:i:s"),
                'updated_by' => Auth::user()->id,
            ];
            $this->province->updateRecord($id, $data);
            return response()->json(['message' => 'province Updated Successfully',  'data' => ['id' => $id]], 200);
        } else {
            return response()->json(['message' => 'No Department Found', 'data' => []], 404);
        }
     }

     public function show($id)
     {
        $data = $this->province->getSingleRecord($id);
        if ($data) {
            return response()->json(['province' => $data[0]], 200);
        } else {
            return response()->json(['message' => 'No province Found'], 404);
        }
     }

     public function delete($id)
     {
        $record = $this->province->getSingleRecord($id);
        if ($record) {
            $data = [
                'deleted_date' => date("Y-m-d H:i:s"),
                'deleted_by' => Auth::user()->id,
                'status'     => 'delete',
            ];
            $this->province->destroyRecord($id, $data);
            return response()->json(['message' => 'province Deleted Successfully',  'data' => ['id' => $id]], 200);
        } else {
            return response()->json(['message' => 'No province Found', 'data' => []], 404);
        }
     }
}
