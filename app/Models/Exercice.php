<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exercice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function machine(){
        return $this->belongsTo(Machine::class);
    }

    public function session(){
        return $this->belongsTo(Seance::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
