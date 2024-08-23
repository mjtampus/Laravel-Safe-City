<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccidentReport extends Model
{
  // AccidentReport model
protected $fillable = ['latitude', 'longitude', 'description', 'name', 'email', 'user_id', 'image_url','location_status'];


    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}