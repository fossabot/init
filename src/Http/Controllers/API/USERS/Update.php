<?php
    
    namespace Weeq\Init\Http\Controllers\API\USERS;
    
    final class Update extends Controller
    {
        public function __invoke($id)
        {
            if ($user = $this->user->find($id)) {
                
                $this->validate([
                    'firstName' => [
                        'required', 'alpha',
                    ],
                    'lastName' => [
                        'required', 'alpha',
                    ],
                ]);
                
                $user->metas = array_merge($user->metas, [
                    'firstName' => $this->request->firstName,
                    'lastName' => $this->request->lastName,
                ]);
                $user->save();
    
                return result([
                    'message' => 'Kullanıcı başarılı bir şekilde güncellendi!',
                ], 'success', 202);
            }
            
            return result([
                'errors' => [
                    'message' => "Kullanıcı bulunamadı!",
                ],
            ], 'notFound', '404');
        }
    }
