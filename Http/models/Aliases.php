<?php

namespace Http\models;

class Aliases
{
    private array $aliases;

    public function __construct(array $aliases)
    {
        $this->aliases = $aliases;
    }

    public function setAliases(array $aliases)
    {
        $this->aliases = $aliases;
    }

    public function getAliases(): array
    {
        return $this->aliases;
    }
}
