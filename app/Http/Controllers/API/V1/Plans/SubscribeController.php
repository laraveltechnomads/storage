<?php

namespace App\Http\Controllers\API\V1\Plans;

use App\Http\Controllers\Controller;
use App\Models\Admin\Plan;
use App\Utils\API\SubscribeUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SubscribeController extends Controller
{

    protected $subscribeUtil;
    public function __construct(SubscribeUtil $subscribeUtil)
    {
        $this->subscribeUtil = $subscribeUtil;
    }

    /** plans list*/
    public function plansList(Request $request)
    {
        $plans = Plan::get();
        return sendDataHelper('Plans List.', $plans->toArray(), $code = 200);
    }

    /** subscribe */
    public function subscribe(Request $request)
    {
        return $this->subscribeUtil->subscribe($request);
    }
}
