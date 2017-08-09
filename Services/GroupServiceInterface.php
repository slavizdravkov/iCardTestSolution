<?php

namespace Services;


use Data\Group;

interface GroupServiceInterface
{
    public function addGroup(string $name, string $teacherName);

}