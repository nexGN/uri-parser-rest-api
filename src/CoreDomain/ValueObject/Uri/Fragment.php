<?php
declare(strict_types=1);

namespace UPA\CoreDomain\ValueObject\Uri;

class Fragment extends Uric
{
    /**
     * Fragment constructor.
     * @param string $uric
     * @throws \InvalidArgumentException
     */
    public function __construct($uric)
    {
        parent::__construct('fragment', $uric);
    }
}
