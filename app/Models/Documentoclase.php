<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Documentoclase extends Model
{

    public function documentotipos(): HasMany
    {
        return $this->hasMany(Documentotipo::class);
    }

        public function comprobantes(): HasMany
    {
        return $this->hasMany(Comprobante::class);
    }


            public function solicitudes(): HasMany
    {
        return $this->hasMany(Solicitud::class);
    }
}
