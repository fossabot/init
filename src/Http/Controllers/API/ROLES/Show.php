<?php
    
    namespace Weeq\Init\Http\Controllers\API\ROLES;
    
    use Weeq\Init\Http\Resources\RoleResource;
    
    final class Show extends Controller
    {
        public function __invoke($id)
        {
            if ($role = $this->role->find($id)) {
                return result(
                    new RoleResource($role), 'success', 202);
            }
    
            return result([
                'errors' => [
                    'message' => "Rol bulunamadı!",
                ],
            ], 'notFound', '404');
        }
    }
