<?php
    
    namespace Weeq\Init\Models;
    
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Notifications\Notifiable;
    
    
    class User extends Model
    {
        use Notifiable;
        protected $table = "users";
        protected $fillable = [
            'email', 'password', 'metas', 'permissions',
        ];
        
        protected static function boot()
        {
            parent::boot();
            Builder::macro('sudo', function () {
                return $this->whereHas('role', function ($query) {
                    $query->where('name', '=', 'Root');
                });
            });
            
            Builder::macro('prod', function () {
                return $this->whereHas('role', function ($query) {
                    $query->where('name', '!=', 'Root');
                });
            });
            
            Builder::macro('isActivated', function () {
                return $this->whereHas('activation', function ($query) {
                    $query->whereNotNull('used_at');
                });
            });
            
            Builder::macro('isNotActivated', function () {
                return $this->whereHas('activation', function ($query) {
                    $query->whereNull('used_at');
                });
            });
            
            static::deleting(function ($registry) {
                // Delete registry_detail
                if ($registry->isForceDeleting()) {
                    $registry->role()->detach();
                    ActivationToken::where('user_id', '=', $registry->id)->first()->forceDelete();
                }
            });
        }
        
        protected $casts = [
            'permissions' => 'array',
            'metas' => 'array',
        ];
        
        public function role()
        {
            return $this->belongsToMany(Role::class, 'role_users');
        }
        
        public function activation()
        {
            return $this->hasOne(ActivationToken::class);
        }
        
        public function resetToken()
        {
            return $this->hasOne(ResetToken::class);
        }
    
        public function permissions()
        {
            return $this->role()->pluck('permissions')->flatten()->unique()->values()->toArray();
        }
    }
