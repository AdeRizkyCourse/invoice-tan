<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class clients extends Model
{
    protected $table = 'clients';
    protected $fillable = ['nama', 'alamat', 'no_hp', 'email'];

    public function invoices()
    {
        return $this->hasMany(invoices::class, 'id');
    }
}
