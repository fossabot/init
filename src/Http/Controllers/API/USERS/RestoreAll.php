<?php
    namespace Weeq\Init\Http\Controllers\API\USERS;
    
    final class RestoreAll extends Controller
    {
        public function __invoke()
        {
            $trashedUsers = $this->user->onlyTrashed();
            if($trashedUsers->count() > 0) {
                $trashedUsers->restore();
    
                return result([
                    'message' => 'Kullanıcılar başarılı bir şekilde kurtarıldı!',
                ], 'success', 202);
            }
            
            return result([
                'errors' => [
                    'message' => "Kurtarılacak kullanıcı bulunamadı!",
                ],
            ], 'notFound', '404');
        }
    }
