<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeException extends Model
{
    use HasFactory;

    protected $table = 'exceptions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 
        'exception_file', 
        'exception_line', 
        'exception_message', 
        'exception_url', 
        'exception_code'
    ];
}
