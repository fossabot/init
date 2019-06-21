<?php
    namespace Weeq\Init\Http\Controllers\API\ROLES;
    
    final class Restore extends Controller
    {
        public function __invoke($id)
        {
            if ($role = $this->role->onlyTrashed()->find($id)) {
                $role->restore();
            
                return result([
                    'message' => 'Rol başarılı bir şekilde kurtarıldı!',
                ], 'success', 202);
            }
        
            return result([
                'errors' => [
                    'message' => "Rol bulunamadı!",
                ],
            ], 'notFound', '404');
        }
    }
