<?php
    
    namespace Weeq\Init\Models;
    
    use Illuminate\Database\Eloquent\Builder;

    class Role extends Model
    {
        protected $table = "roles";
        protected $fillable = ['name', 'permissions'];
        protected $casts = [
            "permissions" => "array",
        ];
        
        protected static function boot()
        {
            parent::boot();
            Builder::macro('sudo', function () {
                return $this->where('name', '=', 'Root');
            });
            Builder::macro('prod', function () {
                return $this->where('name', '!=', 'Root');
            });
        }
    }
