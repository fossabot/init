<?php
    
    namespace Weeq\Init\Http\Controllers\API\USERS;
    
    use Weeq\Init\Models\ActivationToken;
    use Weeq\Init\Models\User;
    
    final class ForceDestroyAll extends Controller
    {
        public function __invoke()
        {
            $trashedUsers = $this->user->onlyTrashed();
            if ($trashedUsers->count() > 0) {
                $trashedUsers->get()
                    ->map(function (User $user) {
                        $user->forceDelete();
                    });
                
                return result([
                    'message' => 'Kullanıcılar kalıcı bir şekilde silindi!',
                ], 'success', 202);
            }
            
            return result([
                'errors' => [
                    'message' => "Kalıcı bir şekilde silinecek kullanıcı bulunamadı!",
                ],
            ], 'notFound', '404');
        }
    }
