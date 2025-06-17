<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class invoices extends Model
{
    protected $table = 'invoices';
    protected $fillable = 
    [
    'no_invoice',
    'id_client',
    'id_user',
    'total_harga',
    'status'
    ];

    public function client()
    {
        return $this->belongsTo(Clients::class, 'id_client');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function items()
    {
        return $this->hasMany(invoices_items::class, 'id_invoice');
    }
}
