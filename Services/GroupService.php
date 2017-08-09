<?php

namespace Services;


use Adapter\DatabaseInterface;
use Data\Group;

class GroupService implements GroupServiceInterface
{
    /**
     * @var DatabaseInterface
     */
    private $db;

    /**
     * GroupService constructor.
     * @param DatabaseInterface $db
     */
    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $name
     * @param string $teacherName
     * @throws \Exception
     * Функция за добавяне на група
     */
    public function addGroup(string $name, string $teacherName)
    {
        if (empty($name)){
            throw new \Exception('Не е въведено име на групата.');
        }

        if (empty($teacherName)){
            throw new \Exception('Не е въведено име на учителката.');
        }

        if ($this->nameExist($name)){
            throw new \Exception('Вече има група с това име.');
        }

        $query = "INSERT into groups
                  (
                    name,
                    teacher_name
                  )
                  VALUES
                  (
                    ?,
                    ?
                  )";
        $statement = $this->db->prepare($query);
        $statement->execute([$name, $teacherName]);
    }

    private function nameExist($name)
    {
        $query = "SELECT name FROM groups WHERE name = ?";
        $statement = $this->db->prepare($query);
        $statement->execute([$name]);

        $row = $statement->fetchRow();

        return !!$row;
    }
}