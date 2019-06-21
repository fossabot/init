<?php
    
    
    namespace Weeq\Init\Http\Controllers\API\USERS;
    
    
    use Weeq\Init\Models\User;
    use Illuminate\Http\Request;
    
    abstract class Controller extends \Weeq\Init\Http\Controllers\Controller
    {
        /***
         * @var \Weeq\Init\Models\User
         */
        protected $user;
        
        public function __construct(Request $request, User $user)
        {
            parent::__construct($request);
            $this->user = $user->prod();
        }
    }
