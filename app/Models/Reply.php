<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    // Table name to be used by the model.
    protected $table = 'replies';

    // Columns to be used in mass-assignment.
    protected $fillable = ['user_id', 'comment_id', 'body'];

    /** Relations */

    // One-to-Many inverse relation with User model.
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // One-to-Many inverse relation with Comment model.
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }
}

