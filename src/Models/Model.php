<?php
    
    
    namespace Weeq\Init\Models;
    
    
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Support\Str;

    /***
     * Class Model
     * @Thanks https://dev.to/wilburpowery/easily-use-uuids-in-laravel-45be
     * @package Weeq\Init\Models
     */

    abstract class Model extends \Illuminate\Database\Eloquent\Model
    {
        use SoftDeletes;
        protected static function boot()
        {
            parent::boot();
            static::creating(function ($model) {
                $model->{$model->primaryKey} = (string) Str::uuid();
            });
        }
    
        protected $hidden = [
            'password', 'remember_token',
            'deleted_at', 'updated_at',
        ];
        
        public function getIncrementing()
        {
            return false;
        }
    
        public function getKeyType()
        {
            return "string";
        }
    }
