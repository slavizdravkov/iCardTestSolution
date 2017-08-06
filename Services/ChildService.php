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
		  WHERE status = 'accepted' AND dismission_date IS NULL";

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
        $query = "
          SELECT
              childrens.id,
              childrens.name,
              surname AS surName,
              lastname As lastName,
              egn,
              group_id AS groupName,
              dismission_date AS teacherName,
              DATE_FORMAT (admission_date, '%d-%m-%Y') AS admissionDate,
              is_present AS isPresent,
			  missing_reason AS missingReason,
			  missing_from AS missingFrom,
			  missing_to AS missingTo
		  FROM
			  childrens
		  WHERE status = 'waiting' AND dismission_date IS NULL";

        $statement = $this->db->prepare($query);
        $statement->execute();

        while ($child = $statement->fetchObject(ChildViewData::class)) {
            yield $child;
        }
    }

    /**
     * @param string $admissionDate
     * @return ChildViewData[]|\Generator
     */
    public function findByAdmissionDate(string $admissionDate)
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
		  WHERE DATE_FORMAT (childrens.admission_date, '%d-%m-%Y') = ? AND dismission_date IS NULL";

        $statement = $this->db->prepare($query);
        $statement->execute([$admissionDate]);

        while ($child = $statement->fetchObject(ChildViewData::class)) {
            yield $child;
        }

    }

    /**
     * @param string $dismissionDate
     * @return ChildViewData[]|\Generator
     */
    public function findByDismissionDate(string $dismissionDate)
    {
        $query = "
          SELECT
              childrens.id,
              childrens.name,
              surname AS surName,
              lastname As lastName,
              egn,
              group_id AS groupName,
              status AS teacherName,
              DATE_FORMAT (admission_date, '%d-%m-%Y') AS admissionDate,
              is_present AS isPresent,
			  missing_reason AS missingReason,
			  missing_from AS missingFrom,
			  missing_to AS missingTo
		  FROM
				childrens
		  WHERE DATE_FORMAT (childrens.dismission_date, '%d-%m-%Y') = ?";

        $statement = $this->db->prepare($query);
        $statement->execute([$dismissionDate]);

        while ($child = $statement->fetchObject(ChildViewData::class)) {
            yield $child;
        }


    }

    /**
     * @param string $name
     * @return ChildViewData[]|\Generator
     */
    public function findByName(string $name)
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
		  WHERE childrens.name = ? AND dismission_date IS NULL";

        $statement = $this->db->prepare($query);
        $statement->execute([$name]);

        while ($child = $statement->fetchObject(ChildViewData::class)) {
            yield $child;
        }
    }

    /**
     * @param string $groupName
     * @return ChildViewData[]|\Generator
     */
    public function findByGroup(string $groupName)
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
		  WHERE groups.name = ? AND childrens.dismission_date IS NULL";

        $statement = $this->db->prepare($query);
        $statement->execute([$groupName]);

        while ($child = $statement->fetchObject(ChildViewData::class)) {
            yield $child;
        }
    }

    /**
     * @return ChildViewData[]|\Generator
     */
    public function findByMissingNow()
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
		  WHERE is_present = 'не' AND dismission_date IS NULL";

        $statement = $this->db->prepare($query);
        $statement->execute();

        while ($child = $statement->fetchObject(ChildViewData::class)) {
            yield $child;
        }

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

    public function addChild($name, $surName, $lastName, $egn, $groupId)
    {
        $admissionDate = null;
        $isPresent = null;
        $status = 'waiting';

        if (intval($groupId)) {
            $admissionDate = new \DateTime();
            $admissionDate = $admissionDate->format('Y-m-d H:i:s');
            $isPresent = 'да';
            $status = 'accepted';
        }
        else {
            $groupId = null;
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
            $admissionDate,
            $isPresent,
            $groupId,
            $status
        ]);
    }
}