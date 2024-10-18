<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CommonModel;

class Industry extends Model
{
    use HasFactory;
    protected $table = 'com_industries';

   /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   protected $fillable = [
       'id',
       'industry_name',
       'status',
       'created_date',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by',
   ];
   private $common = null;
    public function __construct()
    {
        $this->common = new CommonModel();
    }
    public function storeRecord($data)
    {
        return $this->common->storeRecord('com_industries', $data);
    }
    public function updateRecord($id, $data)
    {
    
        return $this->common->updateRecord('com_industries', $id, $data);
    }
    public function getAllRecords()
    {
        $data = $this->common->getAllRecords('com_industries');
        return $data;
    }

    public function getSingleRecord($id)
    {
        $data = $this->common->getSingleRecord('com_industries', $id);
        return $data;
    }
     
    public function destroyRecord($id, $data)
    {
        return $this->common->destroyRecord('com_industries', $id, $data);
    }
}
