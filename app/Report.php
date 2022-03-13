<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function transaction() {
        return $this->belongsTo(Transaction::class);
    }

    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}