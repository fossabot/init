<?php
    namespace Weeq\Init\Http\Controllers\API\ROLES;
    
    final class RestoreAll extends Controller
    {
        public function __invoke()
        {
            $trashedRoles = $this->role->onlyTrashed();
            if($trashedRoles->count() > 0) {
                $trashedRoles->restore();
    
                return result([
                    'message' => 'Roller başarılı bir şekilde kurtarıldı!',
                ], 'success', 202);
            }
            
            return result([
                'errors' => [
                    'message' => "Kurtarılacak rol bulunamadı!",
                ],
            ], 'notFound', '404');
        }
    }
