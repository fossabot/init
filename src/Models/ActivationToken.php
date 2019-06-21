<?php
    
    namespace Weeq\Init\Models;
    
    use Illuminate\Support\Str;

    class ActivationToken extends Model
    {
        protected $table = "activation_tokens";
        protected $fillable = ['user_id', 'token'];
        
        protected $casts = [
            "used_at" => "DateTime",
        ];
        
        protected static function boot()
        {
            parent::boot();
            static::creating(function ($model) {
                $model->token = Str::random(100);
            });
        }
    }
