<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['gender', 'email', 'postcode', 'address', 'building_name', 'opinion', 'fullname'];

    public static $rules = array(
        'fullname' => 'required',
        'gender' => 'integer|min:1|max:2',
        'email' => 'email',
        'postcode' => 'regex:/^\d{3}-\d{4}$/',
        'address' => 'required',
        'building_name' => 'nullable',
        'opinion' => 'required',
    );
}
