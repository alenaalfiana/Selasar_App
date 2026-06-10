<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    protected $table = 'jenis';
    protected $fillable = ['nama'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
