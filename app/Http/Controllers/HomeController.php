<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Util\Lingual;

class HomeController extends BaseController
{
    public function __invoke(Lingual $lingual_greeting) {
        $build = array(
            'greeting' => $lingual_greeting->phrase(),
            'message' => $lingual_greeting->sentence(),
        );
        return view('home', $build);
    }
}
