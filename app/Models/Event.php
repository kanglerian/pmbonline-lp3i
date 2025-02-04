<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pmb',
        'code',
        'title',
        'description',
        'is_scholarship',
        'is_files',
        'is_employee',
        'is_program',
        'program',
        'is_status'
    ];

    protected $table = 'events';
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function eventdetail(){
        return $this->hasMany(EventDetail::class, 'event_id');
    }
}
