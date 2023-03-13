<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function getAll()
    {
        return self::all();
    }

    public function getName($id)
    {
        try {
            return $this->where('id',$id)->first();
        }catch (\Exception $e){
            return false;
        }

    }

    public function get($id)
    {
        return $this->where('id',$id)->get();
    }

    public function thread()
    {
        return $this->hasMany(Thread::class);
    }
}
