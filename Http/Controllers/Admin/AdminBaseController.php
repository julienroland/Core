<?php namespace Core\Http\Controllers\Admin;

use Illuminate\Routing\Controller;

/**
 * @Before("auth.admin")
 */
class AdminBaseController extends Controller
{
    public function __construct()
    {
    }
}
