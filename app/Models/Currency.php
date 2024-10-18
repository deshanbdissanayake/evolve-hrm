<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\CommonModel;

class Currency extends Model
{
    use HasFactory;

    // Table associated with the model
    protected $table = 'com_currencies';

    // Fields that are mass assignable
    protected $fillable = [
        'id',
        'country_name',
        'iso_code',
        'conversion_rate',
        'is_default',
        'previous_rate',
        'status',
        'created_date',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
    ];

    // Instance of CommonModel for reusable database operations
    private $common = null;

    // Constructor to initialize CommonModel
    public function __construct()
    {
        $this->common = new CommonModel();
    }

    /**
     * Store a new company record
     *
     * @param array $data
     * @return mixed
     */
    public function storeRecord($data)
    {
        return $this->common->storeRecord('com_currencies', $data);
    }

    /**
     * Update an existing company record
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function updateRecord($id, $data)
    {
        return $this->common->updateRecord('com_currencies', $id, $data);
    }

    /**
     * Get all company records
     *
     * @return mixed
     */
    public function getAllRecords()
    {
        return $this->common->getAllRecords('com_currencies');
    }

    /**
     * Get a single company record by ID
     *
     * @param int $id
     * @return mixed
     */
    public function getSingleRecord($id)
    {
        return $this->common->getSingleRecord('com_currencies', $id);
    }

    /**
     * Soft delete a company record
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function destroyRecord($id, $data)
    {
        return $this->common->destroyRecord('com_currencies', $id, $data);
    }
}
