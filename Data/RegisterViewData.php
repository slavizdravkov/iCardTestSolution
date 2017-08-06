<?php

namespace Data;


class RegisterViewData
{
    /**
     * @var Group[]|\Generator
     */
    private $groups;

    /**
     * @return Group[]|\Generator
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param callable $groups
     */
    public function setGroups(callable $groups)
    {
        $this->groups = $groups();
    }

}