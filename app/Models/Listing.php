<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model {
    use HasFactory;

    protected $fillable = ['title', 'user_id', 'company', 'location', 'logo', 'description', 'website', 'email', 'tags'];

    public function scopeFilter($query, array $filters) {
        //This is to have a query filter
        if ($filters['tag'] ?? false) {
            $query->where('tags', 'like', '%' . request('tag') . '%');
        }

        //This is to search for values that match specific coloums in our database
        if ($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('description', 'like', '%' . request('search') . '%')
                ->orWhere('tags', 'like', '%' . request('search') . '%');
        }
    }

    /**
     * DATABASE RELATIONSHIP WITH USERS
     */
    public function User() {
        //Here we have a many to one relationship with users so we use,
        return $this->belongsTo(User::class, 'user_id');
    }
}
