<?php
    
    namespace Weeq\Init\Http\Controllers\API\ROLES;
    
    use Weeq\Init\Models\ActivationToken;
    use Weeq\Init\Models\Role;
    
    final class ForceDestroyAll extends Controller
    {
        public function __invoke()
        {
            $trashedRoles = $this->role->onlyTrashed();
            if ($trashedRoles->count() > 0) {
                $trashedRoles->get()
                    ->map(function (Role $role) {
                        $role->forceDelete();
                    });
                
                return result([
                    'message' => 'Roller kalıcı bir şekilde silindi!',
                ], 'success', 202);
            }
            
            return result([
                'errors' => [
                    'message' => "Kalıcı bir şekilde silinecek rol bulunamadı!",
                ],
            ], 'notFound', '404');
        }
    }
