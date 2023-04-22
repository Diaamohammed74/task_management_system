<?php

namespace App\Models;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        'id',
        'name',
        'description',
        'status',
        'priority',
        'employee_id',
        'project_id',
        'start_date',
        'end_date',
    ];
    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }
    public function employee(){
        return $this->belongsTo(User::class,'employee_id');
    }
}
