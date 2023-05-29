<?php

namespace Abelvan\Dashboard;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Abelvan\Dashboard\Skeleton\SkeletonClass
 */
class DashboardFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'abelvan';
    }

    public static function getCustomFunction($id)
    {
       dd($id);
    }
}
