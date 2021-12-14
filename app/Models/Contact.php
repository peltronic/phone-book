<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Contact extends EloquentModel
{
    use HasFactory;

    protected $guarded = [ 'id', 'created_at', 'updated_at' ];
    protected $with = [ 'phonenumbers' ]; // eager-load by default

    //--------------------------------------------
    // %%% Relationships
    //--------------------------------------------

    public function phonenumbers() {
        return $this->hasMany(Phonenumber::class);
    }
}
