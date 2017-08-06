<?php

namespace UPA\GenericDomain;

interface ValueObject
{
    public function getValue();
    public function __toString(): string;
}
