<?php

namespace Data;


class TemplatesViewData
{
    /**
     * @var Group[]|\Generator
     */
    private $groups;

    private $error = null;

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

    /**
     * @return null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param null $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

}