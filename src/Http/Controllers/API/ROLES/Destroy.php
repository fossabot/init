<?php
    
    namespace Weeq\Init\Http\Controllers\API\ROLES;
    
    use Weeq\Init\Http\Resources\RoleResource;
    
    final class Destroy extends Controller
    {
        public function __invoke($id)
        {
            if ($role = $this->role->find($id)) {
                $role->delete();
                
                
                return result([
                    'message' => 'Rol başarılı bir şekilde kaldırıldı!',
                ], 'success', 202);
            }
            
            return result([
                'errors' => [
                    'message' => "Rol bulunamadı!",
                ],
            ], 'notFound', '404');
        }
    }
