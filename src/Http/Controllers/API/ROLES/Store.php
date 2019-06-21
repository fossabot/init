<?php
    
    namespace Weeq\Init\Http\Controllers\API\ROLES;
    
    use Weeq\Init\Models\Role;
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
         * @param Role            $role
         */
        public function __construct(Request $request, Role $role)
        {
            parent::__construct($request, $role);
        }
        
        /**
         *
         */
        public function __invoke()
        {
            $this->validate([
                'name'  =>  [
                    'required', 'alpha', 'unique:roles,name',
                ],
                'permissions' => [
                    'required', 'array', 'min:1', 'not_in:*'
                ]
            ]);
            
            $this->role->create($this->request->only('name', 'permissions'));
            
            return result([
                'message' => 'Rol başarılı bir şekilde oluşturuldu!',
            ], 'success', 202);
        }
    }
