<?php
    
    namespace Weeq\Init\Http\Controllers\API\USERS;
    
    use Weeq\Init\Http\Resources\UserResource;
    
    final class Destroy extends Controller
    {
        public function __invoke($id)
        {
            if ($user = $this->user->find($id)) {
                $user->delete();
                
                
                return result([
                    'message' => 'Kullanıcı başarılı bir şekilde kaldırıldı!',
                ], 'success', 202);
            }
            
            return result([
                'errors' => [
                    'message' => "Kullanıcı bulunamadı!",
                ],
            ], 'notFound', '404');
        }
    }
