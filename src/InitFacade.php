<?php

namespace Weeq\Init;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Weeq\Init\Skeleton\SkeletonClass
 */
class InitFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'init';
    }
}
