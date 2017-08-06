<?php

namespace Services;


use Adapter\DatabaseInterface;
use Data\ChildViewData;
use Data\Group;
use Data\RegisterViewData;

class ChildService implements ChildServiceInterface
{
    /**
     * @var DatabaseInterface
     */
    private $db;

    /**
     * ChildService constructor.
     * @param DatabaseInterface $db
     */
    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }


    /**
     * @return ChildViewData[]|\Generator
     */
    public function findAllAccepted()
    {
        $query = "
          SELECT
              childrens.id,
              childrens.name,
              surname AS surName,
              lastname As lastName,
              egn,
              groups.name AS groupName,
              groups.teacher_name AS teacherName,
              DATE_FORMAT (admission_date, '%d-%m-%Y') AS admissionDate,
              is_present AS isPresent,
			  missing_reason AS missingReason,
			  missing_from AS missingFrom,
			  missing_to AS missingTo
		  FROM
				childrens
		  INNER JOIN
				groups
		  ON
				childrens.group_id = groups.id
		  WHERE status = 'accepted' AND dismission_date IS NULL ";

        $statement = $this->db->prepare($query);
        $statement->execute();

        while ($child = $statement->fetchObject(ChildViewData::class)) {
            yield $child;
        }
    }

    /**
     * @return ChildViewData[]|\Generator
     */
    public function findAllWaiting()
    {
        // TODO: Implement findAllWaiting() method.
    }

    /**
     * @return ChildViewData[]|\Generator
     */
    public function findByAdmissionData()
    {
        // TODO: Implement findByAdmissionData() method.
    }

    /**
     * @return ChildViewData[]|\Generator
     */
    public function findByDismissionData()
    {
        // TODO: Implement findByDismissionData() method.
    }

    /**
     * @return ChildViewData[]|\Generator
     */
    public function findByName()
    {
        // TODO: Implement findByName() method.
    }

    /**
     * @return ChildViewData[]|\Generator
     */
    public function findByGroup()
    {
        // TODO: Implement findByGroup() method.
    }

    /**
     * @return ChildViewData[]|\Generator
     */
    public function findByMissingNow()
    {
        // TODO: Implement findByMissingNow() method.
    }

    /**
     * @return RegisterViewData
     */
    public function getRegisterViewData()
    {
        $query = "SELECT 
                    id, 
                    name
                  FROM groups
                  WHERE
                    (SELECT COUNT(*)
                    FROM childrens
                    WHERE childrens.group_id = groups.id) <= 9";
        $statement = $this->db->prepare($query);
        $statement->execute();

        $viewData = new RegisterViewData();
        $viewData->setGroups(
            function ()use ($statement) {
                while ($group = $statement->fetchObject(Group::class)) {
                    yield $group;
                }
            }
        );

        return $viewData;
    }

    public function addChild($name, $surName, $lastName, $egn, $groupId = null)
    {
        $admissionDAte = null;
        $isPresent = null;
        $status = 'waiting';

        if ($groupId !== null) {
            $admissionDAte = new \DateTime();
            $isPresent = 'да';
            $status = 'accepted';
        }

        $query = "INSERT INTO childrens
                  (
                    name,
                    surname,
                    lastname,
                    egn,
                    admission_date,
                    is_present,
                    group_id,
                    status
                  )
                  VALUES
                  (
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?
                  )";
        $statement = $this->db->prepare($query);
        $statement->execute([
            $name,
            $surName,
            $lastName,
            $egn,
            $admissionDAte->format('Y-m-d H:i:s'),
            $isPresent,
            $groupId,
            $status
        ]);
    }
}