<?php
namespace App\Positive;

use App\Util\Lingual;

class PositiveGreeting implements Lingual {
    public function phrase() {
        return 'Salutation';
    }

    public function sentence(){
        return 'Salutation, glad to meet you';
    }
}
