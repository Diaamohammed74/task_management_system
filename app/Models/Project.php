<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $with = ['category', 'manager'];
    protected $fillable=[
        'id',
        'name',
        'description',
        'status',
        'manager_id',
        'category_id',
        'start_date',
        'end_date',
    ];
    public function category(){
    return $this->belongsTo(Category::class,'category_id');
    }
    public function manager(){
    return $this->belongsTo(User::class,'manager_id');
    }
    public function task(){
        return $this->hasMany(Task::class);
    }

}
