<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\CommonModel;

class Country extends Model
{
    use HasFactory;
    // Table associated with the model
    protected $table = 'loc_countries';

    protected $fillable = [
        'id',
        'country_name',
        'country_code',
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
        return $this->common->storeRecord('loc_countries', $data);
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
        return $this->common->updateRecord('loc_countries', $id, $data);
    }

    /**
     * Get all company records
     *
     * @return mixed
     */
    public function getAllRecords()
    {
        return $this->common->getAllRecords('loc_countries');
    }

    /**
     * Get a single company record by ID
     *
     * @param int $id
     * @return mixed
     */
    public function getSingleRecord($id)
    {
        return $this->common->getSingleRecord('loc_countries', $id);
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
        return $this->common->destroyRecord('loc_countries', $id, $data);
    }
}
