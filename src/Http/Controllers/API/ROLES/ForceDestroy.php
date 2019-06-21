<?php
    
    namespace Weeq\Init\Http\Controllers\API\ROLES;
    
    use Weeq\Init\Models\ActivationToken;
    
    final class ForceDestroy extends Controller
    {
        public function __invoke($id)
        {
            if ($role = $this->role->onlyTrashed()->find($id)) {
                $role->forceDelete();;
                
                return result([
                    'message' => 'Rol kalıcı bir şekilde silindi!',
                ], 'success', 202);
            }
            
            return result([
                'errors' => [
                    'message' => "Rol bulunamadı!",
                ],
            ], 'notFound', '404');
        }
    }
