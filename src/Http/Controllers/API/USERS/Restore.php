<?php
    namespace Weeq\Init\Http\Controllers\API\USERS;
    
    final class Restore extends Controller
    {
        public function __invoke($id)
        {
            if ($user = $this->user->onlyTrashed()->find($id)) {
                $user->restore();
            
                return result([
                    'message' => 'Kullanıcı başarılı bir şekilde kurtarıldı!',
                ], 'success', 202);
            }
        
            return result([
                'errors' => [
                    'message' => "Kullanıcı bulunamadı!",
                ],
            ], 'notFound', '404');
        }
    }
