<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\CommonModel;

class Country extends Model
{
    use HasFactory;

    private $common = null; // Instance of CommonModel for reusable database operations
    protected $table = 'loc_countries';

    protected $fillable = [
        'id',
        'country_name',
        'country_code',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

    // Constructor to initialize CommonModel
    public function __construct()
    {
        $this->common = new CommonModel();
    }

    public function storeRecord($data)
    {
        return $this->common->storeRecord($table, $data);
    }

    public function updateRecord($id, $data)
    {
        return $this->common->updateRecord($table, $id, $data);
    }

    public function getAllRecords()
    {
        return $this->common->getAllRecords($table);
    }

    public function getSingleRecord($id)
    {
        return $this->common->getSingleRecord($table, $id);
    }

    public function destroyRecord($id, $data)
    {
        return $this->common->destroyRecord($table, $id, $data);
    }
}
