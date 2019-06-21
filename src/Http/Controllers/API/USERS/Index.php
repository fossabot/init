<?php
    
    namespace Weeq\Init\Http\Controllers\API\USERS;
    
    use Weeq\Init\Http\Resources\UserResource;
    
    final class Index extends Controller
    {
        /***
         * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
         */
        public function __invoke()
        {
            dd($this->request->user()->permissions());
            return result(
                UserResource::collection(
                    $this->user
                        ->selectRaw("id, metas")
                        ->get()
                ),
                'success',
                '202'
            );
        }
    }
