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
    public function scopeCategorySearch($query, $contact_id)
    {
        if (!empty($contact_id)) {
            $query->where('id', $contact_id);
        }
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class); // または適切なモデル名
    }



    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            $query->where(function ($query) use ($keyword) {
                $query->where('fullname', 'like', '%' . $keyword . '%')
                    ->orWhere('gender', 'like', '%' . $keyword . '%')
                    ->orWhere('created_at', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            });
        }
    }
}
