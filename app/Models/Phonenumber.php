<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Phonenumber extends EloquentModel
{
    use HasFactory;

    protected $guarded = [ 'id', 'created_at', 'updated_at' ];
    //protected $appends = [ 'phonedigits' ];

    public static $countries = [ 
        'US' => [
            'country_code' => 1,
            'mask' => '###-###-####',
        ],
        'JP' => [
            'country_code' => 81,
            'mask' => null,
        ],
        'UK' => [
            'country_code' => 44,
            'mask' => null,
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
        return $this->phonenumber; // %TODO
        //return preg_replace('/\D/', '', $this->phonenumber);
    }

    //--------------------------------------------
    // %%% Relationships
    //--------------------------------------------

    public function contact() {
        return $this->belongsTo(Contact::class);
    }
}
