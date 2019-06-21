<?php
    
    namespace Weeq\Init\Http\Controllers\API\USERS;
    
    use Weeq\Init\Http\Resources\UserResource;
    
    final class Show extends Controller
    {
        public function __invoke($id)
        {
            if ($user = $this->user->find($id)) {
                return result(
                    new UserResource($user), 'success', 202);
            }
    
            return result([
                'errors' => [
                    'message' => "Kullanıcı bulunamadı!",
                ],
            ], 'notFound', '404');
        }
    }
