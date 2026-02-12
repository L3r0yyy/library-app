<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'author', 'isbn', 'category_id', 'is_available'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('due_date');
    }

    public function getIsOverdueAttribute()
    {
        if ($this->users->isEmpty()) {
            return false;
        }
        $dueDate = \Carbon\Carbon::parse($this->users->first()->pivot->due_date);
        return $dueDate->isPast();
    }

    public function getCurrentBorrowerAttribute()
    {
        return $this->users->first();
    }
}
