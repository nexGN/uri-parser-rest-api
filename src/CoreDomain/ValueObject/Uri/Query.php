<?php
declare(strict_types=1);

namespace UPA\CoreDomain\ValueObject\Uri;

class Query extends Uric
{
    public function __construct($uric)
    {
        parent::__construct('query', $uric);
    }
}
