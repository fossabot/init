<?php

namespace Weeq\Init\Models;

use Illuminate\Support\Str;

class ResetToken extends Model
{
    protected $table = "reset_tokens";
    protected $fillable = ['user_id', 'token', 'used_at', 'expire_at'];
    
    protected $casts = [
        "used_at" => "DateTime",
        "expire_at" => "DateTime",
    ];
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->token = Str::random(100);
            $model->expire_at = now(config('app.timezone'))->addRealDays(2);
        });
    }
}
