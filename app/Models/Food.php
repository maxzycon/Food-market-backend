<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use App\Models\Transaction;

class Food extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'description', 'ingredients', 'price', 'rate', 'types', 'picturePath', 'modal', 'total_sold', 'laba'

    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)
            ->getPreciseTimestamp(3);
    }

    public function getUpdateAtAttribute($value)
    {
        return Carbon::parse($value)
            ->getPreciseTimestamp(3);
    }

    public function toArray()
    {
        $toArray = parent::toArray();
        $toArray['picturePath'] = $this->picturePath;
        return $toArray;
    }

    public function getPicturePathAttribute()
    {
        return url('').Storage::url($this->attributes['picturePath']);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function transaction_sum()
    {
        return $this->hasMany(Transaction::class)->whereIn("status",['ON_DELIVERY','DELIVERED'])->withSum("transaction","quantity");
    }
}
