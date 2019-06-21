<?php
    
    
    namespace Weeq\Init\Http\Controllers\API\AUTH;
    
    
    use Weeq\Init\Http\Controllers\Controller;
    use Weeq\Init\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Str;
    use Illuminate\Validation\Validator;
    
    final class Login extends Controller
    {
        /**
         * @var float|int|null
         */
        protected $expireAt = null;
        /**
         * @var \Weeq\Init\Models\User|null
         */
        protected $user = null;
        
        /**
         * Login constructor.
         *
         * @param \Illuminate\Http\Request $request
         * @param \Weeq\Init\Models\User         $user
         */
        public function __construct(Request $request, User $user)
        {
            parent::__construct($request);
            $this->user = $user;
            $this->expireAt = now()->addSeconds(
                config('app_constants.TOKEN_EXPIRE') * 60
            )->timezone(config('app.timezone'))->timestamp;
        }
        
        /**
         *
         */
        public function __invoke()
        {
            $user = null;
            $this->validate([
                'email' => [
                    'required', 'email', 'exists:users,email',
                ],
                'password' => [
                    'required',
//                    'between:6,16  ',
                ],
            ], [], function (Validator $validator) use (&$user) {
                if ($validator->errors()->count() === 0) {
                    if ($user = $this->findUser()) {
                        if (app('hash')->check($this->request->password, $user->password) === false) {
                            $validator->errors()->add('email', 'Email address or password is incorrect');
                        }
                    }
                }
            });
            
            $rememberToken = Str::random(100);
            $user->remember_token = $rememberToken;
            $user->save();
            
            return $this->respondWithToken(
                encrypt([
                    'id' => $user->id,
                    'remember_token' => $rememberToken,
                    'expire_at' => $this->expireAt,
                    'refresh_at' => now()->addWeeks(2),
                ])
            );
        }
        
        /***
         * @return \Weeq\Init\Models\User|\Illuminate\Database\Eloquent\Model|object|null
         */
        private function findUser()
        {
            return $this->user
                ->isActivated()
                ->where('email', '=', $this->request->email)
                ->first();
        }
        
        
        /***
         * @param $token
         *
         * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
         */
        protected function respondWithToken($token)
        {
            return result([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => $this->expireAt * 1000,
            ], 'token', 202);
        }
    }
