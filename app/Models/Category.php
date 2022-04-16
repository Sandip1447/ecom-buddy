<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'title',
        'body',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // one to one relationship with User
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
