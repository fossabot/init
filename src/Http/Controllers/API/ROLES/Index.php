<?php
    
    namespace Weeq\Init\Http\Controllers\API\ROLES;
    
    use Weeq\Init\Http\Resources\RoleResource;
    
    final class Index extends Controller
    {
        /***
         * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
         */
        public function __invoke()
        {
            return result(
                RoleResource::collection(
                    $this->role->get()
                ),
                'success',
                '202'
            );
        }
    }
