<?php
    
    
    namespace Weeq\Init\Http\Controllers\API\ROLES;
    
    
    use Weeq\Init\Models\Role;
    use Illuminate\Http\Request;
    
    abstract class Controller extends \Weeq\Init\Http\Controllers\Controller
    {
        /***
         * @var Role
         */
        protected $role;
        
        public function __construct(Request $request, Role $role)
        {
            parent::__construct($request);
            $this->role = $role->prod();
        }
    }
