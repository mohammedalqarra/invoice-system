<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class , 'invoice_id', 'id');
    }

    public function unitText()
    {
        if($this->unit == 'piece')
        {
            $text = __('frontend/frontend.piece');
        }elseif ($this->unit == 'g')
        {
            $text = __('frontend/frontend.gram');
        }elseif($this->unit == 'kg')
        {
            $text = __('frontend/frontend.kilo_gram');
        }

        return $text;
    }
}
