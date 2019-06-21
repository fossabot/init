<?php
    
    namespace Weeq\Init\Http\Controllers;
    
    use Illuminate\Foundation\Bus\DispatchesJobs;
    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller as BaseController;
    use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
    use Illuminate\Support\Facades\Validator;
    
    class Controller extends BaseController
    {
        use AuthorizesRequests, DispatchesJobs;
        /**
         * @var
         */
        protected $request;
        
        public function __construct(Request $request)
        {
            $this->request = $request;
        }
        
        
        public function validate(array $rules, array $messages = [], callable $callback = null)
        {
            
            $validate = Validator::make($this->request->all(), $rules, $messages);
            
            if (!is_null($callback)) {
                $validate->after(function ($validator) use (&$callback) {
                    return $callback($validator);
                });
            }
            
            $validate->validate();
        }
        
    }
