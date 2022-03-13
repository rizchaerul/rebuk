<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function book() {
        return $this->belongsTo(Book::class);
    }

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function customer() {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function review() {
        return $this->hasMany(Review::class);
    }

    public function report() {
        return $this->hasMany(Report::class);
    }
}
