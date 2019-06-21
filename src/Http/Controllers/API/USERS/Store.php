<?php
    
    namespace Weeq\Init\Http\Controllers\API\USERS;
    
    use Weeq\Init\Models\ActivationToken;
    use Weeq\Init\Models\Role;
    use Weeq\Init\Models\User;
    use Weeq\Init\Notifications\RegisterMail;
    use Epigra\TcKimlik;
    use Illuminate\Http\Request;
    use Illuminate\Validation\Validator;
    
    final class Store extends Controller
    {
        /**
         * @var \Weeq\Init\Models\ActivationToken
         */
        protected $activationToken;
        
        /**
         * Store constructor.
         *
         * @param \Illuminate\Http\Request    $request
         * @param \Weeq\Init\Models\User            $user
         * @param \Weeq\Init\Models\ActivationToken $activationToken
         */
        public function __construct(Request $request, User $user, ActivationToken $activationToken)
        {
            parent::__construct($request, $user);
            $this->activationToken = $activationToken;
        }
        
        /**
         *
         */
        public function __invoke()
        {
            $this->validate([
                'email' => [
                    'required', 'email', 'unique:users,email',
                ],
                'password' => [
                    'required', 'between:6,16',
                ],
                'firstName' => [
                    'required', 'alpha',
                ],
                'lastName' => [
                    'required', 'alpha',
                ],
                'identityNumber' => [
                    'required', 'between:11,11',
                ],
                'dateOfBirth' => [
                    'required', 'date_format:Y-m-d',
                ],
                'role_id' => [
                    'required', 'exists:roles,id',
                ],
            ], [], function (Validator $validator) {
                if ($validator->errors()->count() > 0) return;
                $firstName = $this->request->firstName;
                $lastName = $this->request->lastName;
                $identityNumber = $this->request->identityNumber;
                
                if (!!$identityNumber && !!$this->request->dateOfBirth && !!$firstName && !!$lastName) {
                    
                    $birthYear = date('Y', strtotime($this->request->dateOfBirth));
                    
                    if (TcKimlik::verify($identityNumber) === false) {
                        
                        return $validator->errors()->add('identityNumber', trans('validation.exists', ['attribute' => 'identityNumber']));
                        
                    }
                    
                    $verify = TcKimlik::validate([
                        'tcno' => $identityNumber,
                        'isim' => $firstName,
                        'soyisim' => $lastName,
                        'dogumyili' => $birthYear,
                    ]);
                    
                    if ($verify === false) {
                        return $validator->errors()->add('identityNumber', "Belirtilen T.C. Kimlik Numarası doğrulanamadı.");
                    }
                }
                
            });
            
            $user = $this->user->create([
                'email' => $this->request->email,
                'password' => bcrypt($this->request->password),
                'metas' => [
                    'firstName' => $this->request->firstName,
                    'lastName' => $this->request->lastName,
                    'identityNumber' => bcrypt($this->request->identityNumber),
                    'dateOfBirth' => $this->request->dateOfBirth,
                ],
            ]);
            
            $this->activationToken->create([
                'user_id' => $user->id,
            ]);
            
            $user->role()->attach([$this->request->role_id]);
            
            $user->notify(new RegisterMail());
            
            return result([
                'message' => 'Kullanıcı başarılı bir şekilde oluşturuldu!',
            ], 'success', 202);
        }
    }
