<?php
    
    namespace Weeq\Init\Console;
    
    
    use Weeq\Init\Models\Role;
    use Illuminate\Console\Command;
    
    class CreatePermissions extends Command
    {
        protected $signature = "permission {name} {--S|scaffold : With Permission Suffix: [ List, ListTrashed, Show, Create, Update, Destroy, Restore, ForceDestroy ] }";
        
        protected $description = 'Create Permissions';
        
        protected $scaffold = [
            'list', 'listTrashed', 'show', 'create', 'update',
            'destroy', 'restore', 'restoreAll',
            'forceDestroy', 'forceDestroyAll',
        ];
        
        public function handle()
        {
            $permissions = config('permissions', []);
            
            $name = trim($this->argument('name'));
            
            if ($this->option('scaffold')) {
                $name = collect($this->scaffold)->map(function ($scaffold) use (&$name) {
                    return $name . "_" . $scaffold;
                });
            } else {
                $name = [$name];
            }
            $configFile = base_path('config/permissions.php');
            $permissions = collect($permissions)->merge($name)->unique()->values()->toArray();
            
            if ($role = Role::sudo()->first()) {
                $role->permissions = $permissions;
                $role->save();
            }
            
            file_put_contents(
                $configFile,
                '<?php' . PHP_EOL . '// last generate ' . now() . PHP_EOL . 'return ' . export($permissions, true) . ';' . PHP_EOL
            );
            $this->call('config:cache');
            $this->info('Permission create successful');
        }
    }
