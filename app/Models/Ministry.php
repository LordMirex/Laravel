<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ministry extends Model
{
    protected $fillable = ['name', 'description', 'leader_name'];

    public function members()
    {
        return $this->hasMany(Member::class);
    }
}
