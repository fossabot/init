<?php
    
    
    namespace Weeq\Init\Http\Controllers\API\AUTH;
    
    
    use Weeq\Init\Http\Controllers\Controller;
    use Weeq\Init\Models\ResetToken;
    use Weeq\Init\Models\User;
    use Weeq\Init\Notifications\PasswordResetMail;
    use Weeq\Init\Rules\Captcha;
    use Illuminate\Http\Request;
    use Illuminate\Support\Str;
    use Illuminate\Validation\Validator;
    
    final class Forget extends Controller
    {
        /**
         * @var \Weeq\Init\Models\ResetToken
         */
        protected $resetToken;
        protected $user;
        
        
        /**
         * Forget constructor.
         *
         * @param \Illuminate\Http\Request $request
         * @param \Weeq\Init\Models\ResetToken   $resetToken
         */
        public function __construct(Request $request, ResetToken $resetToken, User $user)
        {
            parent::__construct($request);
            $this->resetToken = $resetToken;
            $this->user = $user;
        }
        
        /**
         *
         */
        public function __invoke()
        {
            $user = null;
            $this->validate(
                [
                    'email' => [
                        'required', 'email',
                    ],
                ], [],
                function (Validator $validator) use(&$user) {
                    $email = $this->request->email;
                    $user = $this->user->prod()->where('email', '=', $email)->first();
                    if (!$user) {
                        $validator->errors()->add('email', trans('validation.exists', ['attribute' => 'email']));
                    }
                }
            );
            
            $createToken = true;
            
            $checkToken = $user->resetToken()
                ->whereNotNull('expire_at')
                ->whereNull('used_at')
                ->where('is_used', '=', 0)
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($checkToken) {
                $createToken = false;
                if ($checkToken->expire_at->isPast()) {
                    $checkToken->used_at = now(config('app.timezone'));
                    $checkToken->save();
                    $createToken = true;
                }
            }
            
            if($createToken) {
                $user->resetToken()->create([
                    'user_id'    =>  $user->id
                ]);
            }
            
            $user->notify(new PasswordResetMail());
    
            return result([
                'message' => 'Şifre başarılı bir şekilde sıfırlandı!',
            ], 'success', 202);
        }
        
    }
