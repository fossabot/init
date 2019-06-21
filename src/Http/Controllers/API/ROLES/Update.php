<?php
    
    namespace Weeq\Init\Http\Controllers\API\ROLES;
    
    final class Update extends Controller
    {
        public function __invoke($id)
        {
            if ($role = $this->role->find($id)) {
    
                $this->validate([
                    'name'  =>  [
                        'required', 'alpha', 'unique:roles,name,' . $id,
                    ],
                    'permissions' => [
                        'required', 'array', 'min:1', 'not_in:*'
                    ]
                ]);
                
                $role->permissions = collect(array_merge($role->permissions, $this->request->permissions))->unique()->values()->toArray();
                $role->save();
    
                return result([
                    'message' => 'Rol başarılı bir şekilde güncellendi!',
                ], 'success', 202);
            }
            
            return result([
                'errors' => [
                    'message' => "Rol bulunamadı!",
                ],
            ], 'notFound', '404');
        }
    }
