<?php
    
    
    namespace Weeq\Init\Http\Controllers\API\AUTH;
    
    
    use Weeq\Init\Http\Controllers\Controller;
    use Weeq\Init\Models\ActivationToken;
    use Illuminate\Http\Request;

    final class Activation extends Controller
    {
        /**
         * @var \Weeq\Init\Models\ActivationToken
         */
        protected $activationToken;
    
        /**
         * Activation constructor.
         *
         * @param \Illuminate\Http\Request    $request
         * @param \Weeq\Init\Models\ActivationToken $activationToken
         */
        public function __construct(Request $request, ActivationToken $activationToken) {
            parent::__construct($request);
            $this->activationToken = $activationToken;
        }
        
        public function __invoke($code)
        {
        
        }
    }
