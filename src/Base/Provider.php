<?php

namespace GurmesoftInvoice\Base;

use Exception;

class Provider
{
    public function check($requirements, $class)
    {
        foreach ($requirements as $prop) {
            if (empty($class->$prop)) {
                throw new Exception($prop. " cannot be empty.");
            }
        }
    }
}
