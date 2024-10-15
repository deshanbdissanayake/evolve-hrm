<?php
namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TableSequence;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class CommonModel extends Model
{
    use HasFactory;
    // function getSequenceData($sequence_table_name)
    // {
    //     $data = TableSequence::where('sequence_table_name', $sequence_table_name)
    //         ->where('is_deleted', 0)
    //         ->where('active_status', 1)
    //         ->first();
    //     return $data;
    // }
    function updateSequenceData($sequence_table_name, $data)
    {
        return DB::table('table_sequences')
            ->where('sequence_table_name', $sequence_table_name)
            ->update($data);
    }
    function generateSequenceCodeWithPrefix($sequence_table_name, $sequence_data)
    {
        //set sequence data for variables
        $minimum_value = $sequence_data->minimum_value;
        $maximum_value = $sequence_data->maximum_value;
        $increment_value = $sequence_data->increment_value;
        $current_value = $sequence_data->current_value;
        $prefix_value = $sequence_data->prefix_value;
        $bit_year_value = $sequence_data->bit_year_value;
        $year_pos_value = $sequence_data->year_pos_value;
        $year_seperator = $sequence_data->year_seperator;
        $year_format = $sequence_data->year_format;
        $maximum_value_digit_count = strlen((string) $maximum_value);
        //check if current value is greater than or equal to maximum value
        if ($current_value >= $maximum_value) {
            // Set updated sequence data
            $updated_sequence_maximum_value_data = [
                'maximum_value' => $maximum_value + 10,
                'updated_at' => date("Y-m-d H:i:s"),
                'updated_by' => Auth::user()->id,
            ];
            $this->updateSequenceData($sequence_table_name, $updated_sequence_maximum_value_data);
        }
        //increment current value
        $current_value += $increment_value;
        //generate sequence number based on current value
        if ($current_value < 10) {
            $sequence_number = '0000000' . $current_value;
        } elseif ($current_value < 100) {
            $sequence_number = '000000' . $current_value;
        } elseif ($current_value < 1000) {
            $sequence_number = '00000' . $current_value;
        } elseif ($current_value < 10000) {
            $sequence_number = '0000' . $current_value;
        } elseif ($current_value < 100000) {
            $sequence_number = '000' . $current_value;
        } elseif ($current_value < 1000000) {
            $sequence_number = '00' . $current_value;
        } elseif ($current_value < 10000000) {
            $sequence_number = '0' . $current_value;
        } else {
            $sequence_number = (string) $current_value;
        }
        //handle year-based logic
        if ($bit_year_value === '1') {
            $yearValue = $year_format === 'yy' ? date('y') : date('Y');
            if ($year_pos_value === 'F') {
                $sequence_number = $yearValue . $year_seperator . $sequence_number;
            } else {
                $sequence_number .= $year_seperator . $yearValue;
            }
        }
        //generate the full sequence number
        $generated_sequence_number = strtoupper($prefix_value) . $sequence_number;
        //update current value in the sequences table
        $updated_sequence_current_value_data = [
            'current_value' => $current_value,
            'updated_at' => date("Y-m-d H:i:s"),
            'updated_by' => Auth::user()->id,
        ];
        $this->updateSequenceData($sequence_table_name, $updated_sequence_current_value_data);
        //return generated sequence number
        return $generated_sequence_number;
    }
    function generateSequenceCodeWithoutPrefix($sequence_table_name, $sequence_data, $maximum_value_digit_count)
    {
        //set sequence data for variables
        $minimum_value = $sequence_data->minimum_value;
        $maximum_value = $sequence_data->maximum_value;
        $increment_value = $sequence_data->increment_value;
        $current_value = $sequence_data->current_value;
        //check if current value less than maximum value
        if ($current_value < $maximum_value) {
            $current_value += $increment_value;
        }
        //if maximum_value_digit_count = 4
        if ($maximum_value_digit_count === 4) {
            if ($current_value < 10) {
                $sequence_number = '000' . $current_value;
            } elseif ($current_value < 100) {
                $sequence_number = '00' . $current_value;
            } elseif ($current_value < 1000) {
                $sequence_number = '0' . $current_value;
            } elseif ($current_value < 10000) {
                $sequence_number = (string) $current_value;
            }
        }
        //if maximum_value_digit_count = 3
        elseif ($maximum_value_digit_count === 3) {
            if ($current_value < 10) {
                $sequence_number = '00' . $current_value;
            } elseif ($current_value < 100) {
                $sequence_number = '0' . $current_value;
            } elseif ($current_value < 1000) {
                $sequence_number = (string) $current_value;
            }
        }
        //if maximum_value_digit_count = 2
        elseif ($maximum_value_digit_count === 2) {
            if ($current_value < 10) {
                $sequence_number = '0' . $current_value;
            } elseif ($current_value < 100) {
                $sequence_number = (string) $current_value;
            }
        }
        //update current value in the sequences table
        $updated_sequence_current_value_data = [
            'current_value' => $current_value,
            'updated_at' => date("Y-m-d H:i:s"),
            'updated_by' => Auth::user()->id,
        ];
        $this->updateSequenceData($sequence_table_name, $updated_sequence_current_value_data);
        //return generated sequence number
        return $sequence_number;
    }
    function generateSequenceCode($sequence_table_name)
    {
        //get sequence data
        $sequence_data = $this->getSequenceData($sequence_table_name);
        // return $sequence_data;
        //if no sequence data found, return null
        if (!$sequence_data) {
            return null;
        }
        //get maximum digit count
        $maximum_value_digit_count = strlen((string) ($sequence_data->maximum_value));
        if ($maximum_value_digit_count > 4) {
            //generate sequence code with prefix
            $sequence_number = $this->generateSequenceCodeWithPrefix($sequence_table_name, $sequence_data);
        } else {
            //generate sequence code without prefix
            $sequence_number = $this->generateSequenceCodeWithoutPrefix($sequence_table_name, $sequence_data, $maximum_value_digit_count);
        }
        //return generated sequence number
        return $sequence_number;
    }
    function getSpecificColumnValueByGivenColumnName($table_name, $given_column_name, $select_column_name, $given_column_value, $delete_flag, $delete_status)
    {
        $data = DB::table($table_name)
            ->select($select_column_name)
            ->where($delete_flag, $delete_status)
            ->where([$given_column_name => $given_column_value])
            ->distinct()
            ->get()
            ->toArray();
        return $data;
    }
    function getLastInsertedID($table_name)
    {
        $data = DB::table($table_name)
        ->orderBy('id', 'desc')
        ->limit(1)
        ->get()
        ->pluck('id')
        ->toArray();
        return $data;
    }
    function getAllRecords($table_name)
    {
        $data = DB::table($table_name)
            ->select('*')
            ->where('is_deleted', 0)
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();
        return $data;
    }
    function getAllRecordsWithLimit($table_name)
    {
        $data = DB::table($table_name)
            ->select('*')
            ->where('is_deleted', 0)
            ->orderBy('id', 'desc')
            ->limit(100)
            ->get()
            ->toArray();
        return $data;
    }
    function getSingleRecord($table_name, $id)
    {
        $data = DB::table($table_name)
            ->select('*')
            ->where('id', $id)
            ->where('is_deleted', 0)
            ->get()
            ->toArray();
            // var_dump(->get());
        return $data;
    }
    function destroyRecord($table_name, $id, $data)
    {
        return DB::table($table_name)
            ->where('id', $id)
            ->update($data);
    }
    function updateRecord($table_name, $id, $data)
    {
        return DB::table($table_name)
            ->where('id', $id)
            ->update($data);
    }
    function storeRecord($table_name, $data)
    {   
        return DB::table($table_name)
              ->insertGetId($data);  // This will return the last inserted ID     
    }
    function getAllActiveRecords($table_name)
    {
        $data = DB::table($table_name)
            ->select('*')
            ->where('is_deleted', 0)
            ->where('active_status', 1)
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();
        return $data;
    }
    function getAllInActiveRecords($table_name)
    {
        $data = DB::table($table_name)
            ->select('*')
            ->where('is_deleted', 0)
            ->where('active_status', 0)
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();
        return $data;
    }
    function getSingleActiveRecord($table_name, $id)
    {
        $data = DB::table($table_name)
            ->select('*')
            ->where('id', $id)
            ->where('is_deleted', 0)
            ->where('active_status', 1)
            ->get()
            ->toArray();
        return $data;
    }
    function getAllRecordsWithSelectedFields($table_name, $selection_fields_list)
    {
        $data = DB::table($table_name)
            ->select($selection_fields_list)
            ->where('is_deleted', 0)
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();
        return $data;
    }
    function getAllActiveRecordsWithSelectedFields($table_name, $selection_fields_list)
    {
        $data = DB::table($table_name)
            ->select($selection_fields_list)
            ->where('is_deleted', 0)
            ->where('active_status', 1)
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();
        return $data;
    }
    function getSingleRecordWithSelectedFields($table_name, $id, $selection_fields_list)
    {
        $data = DB::table($table_name)
            ->select($selection_fields_list)
            ->where('id', $id)
            ->where('is_deleted', 0)
            ->get()
            ->toArray();
        return $data;
    }
    function getSingleActiveRecordWithSelectedFields($table_name, $id, $selection_fields_list)
    {
        $data = DB::table($table_name)
            ->select($selection_fields_list)
            ->where('id', $id)
            ->where('is_deleted', 0)
            ->where('active_status', 1)
            ->get()
            ->toArray();
        return $data;
    }
    function getAllPendingRecords($table_name)
    {
        $data = DB::table($table_name)
            ->select('*')
            ->where('is_deleted', 0)
            ->where('active_status', 1)
            ->where('approval_status', 0)
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();
        return $data;
    }
    function getIdsForSpecificMatchingKey($table_name, $key_column, $key_value)
    {
        $data = DB::table($table_name)
            ->where($key_column, $key_value)
            ->where('is_deleted', 0)
            ->where('active_status', 1)
            ->orderBy('id', 'asc')
            ->pluck('id')
            ->toArray();
        return $data;
    }
    function getAllActiveRecordsByGivenColumn($table_name, $given_column_name, $given_column_value)
    {
        $data = DB::table($table_name)
            ->select('*')
            ->where($given_column_name, $given_column_value)
            ->where('is_deleted', 0)
            ->where('active_status', 1)
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();
        return $data;
    }
    function getMatchingValuesForSpecificColumn($table_name, $given_column_name, $given_column_value_array, $select_column_name)
    {
        $data = DB::table($table_name)
            ->where('is_deleted', 0)
            ->where('active_status', 1)
            ->whereIn($given_column_name, $given_column_value_array)
            ->pluck($select_column_name)
            ->toArray();
        return $data;
    }
    function getMatchingForSpecificColumn($table_name, $given_column_name, $given_column_value_array, $select_column_name)
    {
        $data = DB::table($table_name)
            ->where('is_deleted', 0)
            ->where($given_column_name, $given_column_value_array)
            ->pluck($select_column_name)
            ->toArray();
        return $data;
    }
    function getAllMatchingForSpecificColumn($table_name, $given_column_name, $given_column_value)
    {
        $data = DB::table($table_name)
            ->select('*')
            ->where($given_column_name, $given_column_value)
            ->where('is_deleted', 0)
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();
        return $data;
    }
    function getBalanceLeaves($val_1, $val_2)
    {
        $data = DB::table('user_leave')
            ->select('*')
            ->where('leave_type_id', $val_1)
            ->where('employee_id', $val_2)
            ->where('is_deleted', 0)
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();
        return $data;
    }
    function checkIfAllocateAttendance($id, $description)
    {
        $data = DB::table('payroll_summary')
            ->select('*')
            ->where('description', $description)
            ->where('payroll_month_id', $id)
            ->where('is_deleted', 0)
            ->get()
            ->toArray();
        return $data;
    }
    function getAllEmployee($table_name)
    {
        $data = DB::table($table_name)
            ->select('id')
            ->where('active_status', 1)
            ->where('is_deleted', 0)
            ->distinct()
            ->get()
            ->toArray();
        return $data;
    }
    function timeDiffInMinutes($out_time, $in_time) {
        $time_1 = strtotime($in_time);
        $time_2 = strtotime($out_time);
        return round(abs($time_2 - $time_1) / 60, 2);
    }
    function getMatchingForSpecificColumns($table_name, $given_column_name_1, 
    $given_column_value_array_1,$given_column_name_2, 
    $given_column_value_array_2, $select_column_name)
    {
        $data = DB::table($table_name)
            ->where('is_deleted', 0)
            ->where($given_column_name_1, $given_column_value_array_1)
            ->where($given_column_name_2, $given_column_value_array_2)
            ->pluck($select_column_name)
            ->toArray();
        return $data;
    }
    function getAllMatchingForSpecificColumns($table_name, $given_column_name_1, 
    $given_column_value_array_1,$given_column_name_2, 
    $given_column_value_array_2)
    {
        $data = DB::table($table_name)
            ->where('is_deleted', 0)
            ->where($given_column_name_1, $given_column_value_array_1)
            ->where($given_column_name_2, $given_column_value_array_2)
            ->get()
            ->toArray();
        return $data;
    }
    function getDatesBetween($startDate, $endDate) {
        $dates = [];
    
        $currentDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);
    
        while ($currentDate->lte($endDate)) {
            $dates[] = $currentDate->toDateString();
            $currentDate->addDay();
        }
    
        return $dates;
    }
}