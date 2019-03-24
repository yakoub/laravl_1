<?php
namespace App\Util;

class Greeting implements Lingual {
    public function phrase() {
        return 'Hellow';
    }

    public function sentence(){
        return 'Hellow my friend';
    }
}
