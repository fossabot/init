<?php
    
    use Illuminate\Database\Seeder;
    
    class DefaultUser extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            $user = $this->createUser();
            $user->role()->attach($this->createRole());
            
            \App\Models\ActivationToken::create([
                'user_id' => $user->id,
                'used_at' => now(),
            ]);
            
            \App\Models\Role::create([
                'name' => "User",
            ]);
            
            $this->command->call('permission', [
                'name' => 'users', '-S' => true,
            ]);
            $this->command->call('permission', [
                'name' => 'roles', '-S' => true,
            ]);
        }
        
        private function createUser()
        {
            return \App\Models\User::create([
                'email' => config('app_constants.ROOT_EMAIL'),
                'password' => bcrypt(
                    config('app_constants.ROOT_PASSWORD')
                ),
                'metas' => [
                    'firstName' => config('app_constants.ROOT_NAME'),
                    'lastName' => config('app_constants.ROOT_SURNAME'),
                ],
            ]);
        }
        
        private function createRole()
        {
            return \App\Models\Role::create([
                'name' => "Root",
                "permissions" => ["*"],
            ]);
        }
    }
