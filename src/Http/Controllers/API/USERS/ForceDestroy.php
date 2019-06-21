<?php
    
    namespace Weeq\Init\Http\Controllers\API\USERS;
    
    use Weeq\Init\Models\ActivationToken;
    
    final class ForceDestroy extends Controller
    {
        public function __invoke($id)
        {
            if ($user = $this->user->onlyTrashed()->find($id)) {
                $user->forceDelete();;
                
                return result([
                    'message' => 'Kullanıcı kalıcı bir şekilde silindi!',
                ], 'success', 202);
            }
            
            return result([
                'errors' => [
                    'message' => "Kullanıcı bulunamadı!",
                ],
            ], 'notFound', '404');
        }
    }
