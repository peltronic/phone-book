<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Phonenumber extends EloquentModel
{
    use HasFactory;

    protected $guarded = [ 'id', 'created_at', 'updated_at' ];
    protected $appends = [ 'formatted' ];

    public static $countries = [ 
        'US' => [
            'country_code' => 1,
            //'length' => 1+10,
            'mask' => '+1 ###-###-####',
        ],
        'JP' => [ 
            'country_code' => 81,
            //'length' => 2+10,
            'mask' => '+03 ##-####-####', // for 2-digit area codes
        ],
        //'JP2' => [ // %TODO
            //'country_code' => 81,
            //'length' => 10,
            //'mask' => null,
        //],
        'UK' => [
            'country_code' => 44,
            //'length' => 2+11,
            'mask' => '+44 ###-####-####',
        ],
    ];


    //-----------------------------------------------
    // %%% Boot
    //-----------------------------------------------

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->phonenumber = preg_replace('/\D/', '', $model->phonenumber); // store only digits
        });
    }

    //--------------------------------------------
    // %%% Accessors & Mutators
    //--------------------------------------------

    // returns formatted number based on country code
    public function getFormattedAttribute($value) {
        $mask = Phonenumber::$countries[$this->country]['mask'] ?? null;
        if ( !$mask ) {
            return $this->phonenumber;
        }

        $pnA = str_split($this->phonenumber);
        $maskA = str_split($mask);

        // Format the number using the given mask
        // %TODO: make robust in case lenght of mask and number don't match
        $formatted = collect($maskA)->map( function($c) use($pnA) {
            static $idx = 0;
            if ($c === '#') { 
                return $pnA[$idx++];
            } else {
               return $c;
            }
        });

        return implode('', $formatted->toArray());
    }

    //--------------------------------------------
    // %%% Relationships
    //--------------------------------------------

    public function contact() {
        return $this->belongsTo(Contact::class);
    }
}
