<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'role_name',
    ]; 

    public function users()
    {
        return $this->hasMany(User::class,  'role_id'); // Sesuaikan dengan nama foreign key
    }
}
