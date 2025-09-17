<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;

class Status extends Model
{
    use HasFactory;

    public function ticket()
        {
            return $this->hasManys(Ticket::class);
        }
}
