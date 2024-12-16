<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    protected $table = 'timesheets';

    protected $fillable = [
        'user_id',
        'clock_in_time',
        'clock_out_time',
    ];

    protected $casts = [
        'clock_in_time' => 'datetime',
        'clock_out_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalTimeAttribute()
    {
        $clock_in = Carbon::parse($this->clock_in);
        $clock_out = Carbon::parse($this->clock_out);

        return $clock_in->diffForHumans($clock_out, true);
    }
}
