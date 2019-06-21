<?php
    
    namespace Weeq\Init\Http\Middleware;
    
    use Weeq\Init\Exceptions\TokenException;
    use Weeq\Init\Models\User;
    use Carbon\Carbon;
    use Closure;
    use Illuminate\Contracts\Encryption\DecryptException;
    use Illuminate\Http\Request;
    
    class TokenAuthenticate
    {
        /**
         * @var array
         */
        private $claims = [
            'id',
            'remember_token',
            'expire_at',
            'refresh_at',
        ];
        /**
         * @var int
         */
        protected $leeway = 0;
        /**
         * @var \Weeq\Init\Models\User
         */
        protected $user;
        
        /**
         * TokenAuthenticate constructor.
         *
         * @param \Weeq\Init\Models\User $user
         */
        public function __construct(User $user)
        {
            $this->user = $user;
        }
        
        /****
         * @param \Illuminate\Http\Request $request
         * @param \Closure                 $next
         *
         * @return mixed
         * @throws \Weeq\Init\Exceptions\TokenException
         */
        public function handle(Request $request, Closure $next)
        {
            try {
                $token = $request->bearerToken();
                
                if ($token === null) {
                    throw new TokenException("Token Required", 400);
                }
                
                $payload = decrypt($token);
                
                $this->verifyClaims($payload);
    
    
                if(app()->environment() !== "local" && config('app.debug') === false) {
                    if ($this->validate($payload['expire_at'], $this->leeway)) {
                        throw new TokenException("Token Expired", 400);
                    }
                }
    
                if (!$user = $this->findUser($payload)) {
                    throw new TokenException("User Not Found", 400);
                }
                
                $request->setUserResolver(function () use (&$user) {
                    return $user;
                });
                
                return $next($request);
            } catch (DecryptException $exception) {
                throw new TokenException('Token Invalid', 401);
            }
        }
    
        private function findUser($payload)
        {
            return $this->user
                ->where('remember_token', '=', $payload['remember_token'])
                ->find($payload['id']);
        }
        
        /****
         * @param $payload
         *
         * @throws \Weeq\Init\Exceptions\TokenException
         */
        private function verifyClaims($payload)
        {
            foreach ($this->claims as $claim) {
                if (!array_key_exists($claim, $payload)) {
                    throw new TokenException('Token Invalid', 401);
                }
            }
        }
        
        /**
         * @param     $timestamp
         * @param int $leeway
         *
         * @return bool
         */
        private function validate($timestamp, $leeway = 0)
        {
            $timestamp = $this->timestamp($timestamp);
            return $leeway > 0
                ? $timestamp->addSeconds($leeway)->isPast()
                : $timestamp->isPast();
        }
        
        /**
         * @param $timestamp
         *
         * @return \Carbon\Carbon|\Carbon\CarbonInterface
         */
        private function timestamp($timestamp)
        {
            return Carbon::createFromTimestamp($timestamp)->timezone(config('app.timezone'));
        }
    }
