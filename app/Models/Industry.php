<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CommonModel;

class Industry extends Model
{
    use HasFactory;
    protected $table = 'industries';

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
        return $this->common->storeRecord('industries', $data);
    }
    public function updateRecord($id, $data)
    {
    
        return $this->common->updateRecord('industries', $id, $data);
    }
    public function getAllRecords()
    {
        $data = $this->common->getAllRecords('industries');
        return $data;
    }

    public function getSingleRecord($id)
    {
        $data = $this->common->getSingleRecord('industries', $id);
        return $data;
    }
     
    public function destroyRecord($id, $data)
    {
        return $this->common->destroyRecord('industries', $id, $data);
    }
}
