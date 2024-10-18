<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Province;
use App\Models\City;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CommonModel;

class LocationController extends Controller
{
    private $country = null;
    private $province = null;
    private $city = null;
    private $common = null;

    public function __construct()
    {
        $this->middleware('permission:view user', ['only' => [
            'index', 
            'getAllCountries', 
            'getCountryByCountryId', 
            'getAllProvinces',
            'getProvinceByProvinceId', 
            'getProvincesByCountryId', 
            'getAllCities',
            'getCityByCityId', 
            'getCitiesByProvinceId'
        ]]);
        $this->middleware('permission:create user', ['only' => ['createCountry', 'createProvince', 'createCity']]);
        $this->middleware('permission:update user', ['only' => ['updateCountry', 'updateProvince', 'updateCity']]);
        $this->middleware('permission:delete user', ['only' => ['deleteCountry', 'deleteProvince', 'deleteCity']]);

        $this->country = new Country();
        $this->province = new Province();
        $this->city = new City();
        $this->common = new CommonModel();
    }

    public function index()
    {
        return view('location.index');
    }

    //================================================================================================================================
    // country
    //================================================================================================================================
    public function createCountry(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $request->validate([
                    'country_name' => 'required',
                    'country_code' => 'required',
                ]);
                $data = [
                    'country_name' => $request->country_name,
                    'country_code' => $request->country_code,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ];
                //store the record in the transaction_classes table
                $insertId = $this->country->storeRecord($data);

                if ($insertId) {
                    return response()->json(['status' => 'success', 'message' => 'Country  added successfully' , 'data' => ['id' => $insertId]], 200);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Failed adding Country', 'data' => []], 500);
                }
            });
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => 'Error occurred due to ' . $e->getMessage(), 'data' => []], 500);
        }
    }
 
    public function updateCountry(Request $request, $id)
    {
        $request->validate([
            'country_name' => 'required',
            'country_code' => 'required',
        ]);
        $record = $this->country->getSingleRecord($id);
        if ($record) {
            $data = [
                'country_name' => $request->country_name,
                'country_code' => $request->country_code,
                'updated_by' => Auth::user()->id,
            ];
            $this->country->updateRecord($id, $data);
            return response()->json(['status' => 'success', 'message' => 'Country updated successfully',  'data' => ['id' => $id]], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed updating Country', 'data' => []], 404);
        }
    }

    public function deleteCountry($id)
    {
        $record = $this->country->getSingleRecord($id);
        if ($record) {
            $data = [
                'status' => 'delete',
                'updated_by' => Auth::user()->id,
            ];
            $this->country->destroyRecord($id, $data);
            return response()->json(['status' => 'success', 'message' => 'Country deleted successfully',  'data' => ['id' => $id]], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed deleting country', 'data' => []], 404);
        }
    }

    public function getAllCountries()
    {
        $countries = $this->country->where('status', '!=', 'delete')->get();
        return response()->json(['data' => $countries], 200);
    }

    public function getCountryByCountryId($id)
    {
        $data = $this->country->getSingleRecord($id);
        if ($data) {
            return response()->json(['country' => $data[0]], 200);
        } else {
            return response()->json(['message' => 'No industry Found'], 404);
        }
    }

    //================================================================================================================================
    // province
    //================================================================================================================================
    public function createProvince(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $request->validate([
                    'province_name' => 'required',
                    'country_id' => 'required',
                ]);
                $data = [
                    'province_name' => $request->province_name,
                    'country_id' => $request->country_id,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ];
                //store the record in the transaction_classes table
                $insertId = $this->province->storeRecord($data);

                if ($insertId) {
                    return response()->json(['status' => 'success', 'message' => 'Province added successfully' , 'data' => ['id' => $insertId]], 200);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Failed adding province', 'data' => []], 500);
                }
            });
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => 'Error occurred due to ' . $e->getMessage(), 'data' => []], 500);
        }
    }
    
    public function updateProvince(Request $request, $id)
    {
        $request->validate([
            'province_name' => 'required',
            'country_id' => 'required',
        ]);
        $record = $this->province->getSingleRecord($id);
        if ($record) {
            $data = [
                'province_name' => $request->province_name,
                'country_id' => $request->country_id,
                'updated_by' => Auth::user()->id,
            ];
            $this->province->updateRecord($id, $data);
            return response()->json(['status' => 'success', 'message' => 'Province updated successfully',  'data' => ['id' => $id]], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed updating province', 'data' => []], 404);
        }
    }

    public function deleteProvince($id)
    {
        $record = $this->province->getSingleRecord($id);
        if ($record) {
            $data = [
                'status'     => 'delete',
                'updated_by' => Auth::user()->id,
            ];
            $this->province->destroyRecord($id, $data);
            return response()->json(['status' => 'success', 'message' => 'Province deleted successfully',  'data' => ['id' => $id]], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed deleting province', 'data' => []], 404);
        }
    }

    public function getAllProvinces()
    {
        $provinces = $this->province->where('status', '!=', 'delete')->get();
        return response()->json(['data' => $provinces], 200);
    }

    public function getProvinceByProvinceId(){}
    public function getProvincesByCountryId(){}

    //================================================================================================================================
    // city
    //================================================================================================================================
    public function createCity(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $request->validate([
                    'city_name' => 'required',
                    'province_id' => 'required',
                ]);
                $data = [
                    'city_name' => $request->city_name,
                    'province_id' => $request->province_id,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ];
                //store the record in the transaction_classes table
                $insertId = $this->city->storeRecord($data);

                if ($insertId) {
                    return response()->json(['status' => 'success', 'message' => 'City  added successfully' , 'data' => ['id' => $insertId]], 200);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Failed adding city', 'data' => []], 500);
                }
            });
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => 'Error occurred due to ' . $e->getMessage(), 'data' => []], 500);
        }
    }

    public function updateCity(Request $request, $id)
    {
        $request->validate([
            'country_name' => 'required',
            'province_id' => 'required',
        ]);
        $record = $this->city->getSingleRecord($id);
        if ($record) {
            $data = [
                'city_name' => $request->city_name,
                'province_id' => $request->province_id,
                'updated_by' => Auth::user()->id,
            ];
            $this->city->updateRecord($id, $data);
            return response()->json(['status' => 'success', 'message' => 'City updated successfully',  'data' => ['id' => $id]], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed updating city', 'data' => []], 404);
        }
    }

    public function deleteCity($id)
    {
        $record = $this->city->getSingleRecord($id);
        if ($record) {
            $data = [
                'status'          => 'delete',
                'updated_by' => Auth::user()->id,
            ];
            $this->city->destroyRecord($id, $data);
            return response()->json(['status' => 'success', 'message' => 'City deleted successfully',  'data' => ['id' => $id]], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed deleting city', 'data' => []], 404);
        }
    }

    
    public function getAllCities()
    {
        $cities = $this->city->where('status', '!=', 'delete')->get();
        return response()->json(['data' => $cities], 200);
    }

    public function getCityByCityId(){}
    public function getCitiesByProvinceId(){}


}
