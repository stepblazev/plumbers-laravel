<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['admin_id', 'name', 'logo'];
    
    public function admin() {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
