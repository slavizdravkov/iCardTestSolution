<?php

namespace Services;


use Adapter\DatabaseInterface;
use Data\ChildViewData;
use Data\Group;
use Data\TemplatesViewData;

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
              DATE_FORMAT (admission_date, '%e.%m.%Y') AS admissionDate,
              is_present AS isPresent,
			  missing_reason AS missingReason,
			  DATE_FORMAT (missing_from, '%e.%m.%Y') AS missingFrom,
			  DATE_FORMAT (missing_to, '%e.%m.%Y') AS missingTo
		  FROM
				childrens
		  INNER JOIN
				groups
		  ON
				childrens.group_id = groups.id
		  WHERE status = 'accepted' AND dismission_date IS NULL
		  ORDER BY childrens.name";

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
              DATE_FORMAT (admission_date, '%e.%m.%Y') AS admissionDate,
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
        $admDate = $this->extractDate($admissionDate);
        $query = "
          SELECT
              childrens.id,
              childrens.name,
              surname AS surName,
              lastname As lastName,
              egn,
              groups.name AS groupName,
              groups.teacher_name AS teacherName,
              DATE_FORMAT (admission_date, '%e.%m.%Y') AS admissionDate,
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
		  WHERE DATE_FORMAT (childrens.admission_date, '%e.%m.%Y') = ? AND dismission_date IS NULL";

        $statement = $this->db->prepare($query);
        $statement->execute([$admDate]);

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
        $dismDate = $this->extractDate($dismissionDate);
        $query = "
          SELECT
              childrens.id,
              childrens.name,
              surname AS surName,
              lastname As lastName,
              egn,
              group_id AS groupName,
              status AS teacherName,
              DATE_FORMAT (admission_date, '%e.%m.%Y') AS admissionDate,
              is_present AS isPresent,
			  missing_reason AS missingReason,
			  missing_from AS missingFrom,
			  missing_to AS missingTo
		  FROM
				childrens
		  WHERE DATE_FORMAT (childrens.dismission_date, '%e.%m.%Y') = ?";

        $statement = $this->db->prepare($query);
        $statement->execute([$dismDate]);

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
              DATE_FORMAT (admission_date, '%e.%m.%Y') AS admissionDate,
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
              DATE_FORMAT (admission_date, '%e.%m.%Y') AS admissionDate,
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
              DATE_FORMAT (admission_date, '%e.%m.%Y') AS admissionDate,
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
		  WHERE is_present = 'no' AND dismission_date IS NULL";

        $statement = $this->db->prepare($query);
        $statement->execute();

        while ($child = $statement->fetchObject(ChildViewData::class)) {
            yield $child;
        }

    }

    /**
     * @return TemplatesViewData
     */
    public function getAddChildViewData()
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

        $viewData = new TemplatesViewData();
        $viewData->setGroups(
            function ()use ($statement) {
                while ($group = $statement->fetchObject(Group::class)) {
                    yield $group;
                }
            }
        );

        return $viewData;
    }

    public function getIndexViewData()
    {
        $query = "SELECT id, name FROM groups";
        $statement = $this->db->prepare($query);
        $statement->execute();

        $viewData = new TemplatesViewData();
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
        if (empty($name)){
            throw new \Exception('Не е въведено име на детето.');
        }

        if (empty($surName)){
            throw new \Exception('Не е въведено презиме на детето.');
        }

        if (empty($lastName)){
            throw new \Exception('Не е въведена фамилия на детето.');
        }

        if (empty($egn)){
            throw new \Exception('Не е въведено ЕГН на детето.');
        }

        if (strlen($egn) !== 10){
            throw new \Exception('Въведеното ЕГН не е валидно.');
        }

        $admissionDate = null;
        $isPresent = null;
        $status = 'waiting';

        if (intval($groupId)) {
            if (!$this->groupExist($groupId)){
                throw new \Exception('Групата не съществува');
            }
            $admissionDate = new \DateTime();
            $admissionDate = $admissionDate->format('Y-m-d H:i:s');
            $isPresent = 'yes';
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

    public function changeToMissing(string $reason, string $missingTo, string $id)
    {
        if (empty($reason)){
            throw new \Exception('Не е въведена причина за отсъствието');
        }

        if (empty($missingTo)){
            throw new \Exception('Не е въведено до кога ще отсъства');
        }

        if (!$this->childExist($id)){
            throw new \Exception('Детето го няма в регистъра');
        }

        $missingFromDate = new \DateTime();
        $missingFromDate = $missingFromDate->format('Y-m-d H:i:s');
        $missingToDate = new \DateTime($missingTo);
        $missingToDate = $missingToDate->format('Y-m-d H:i:s');

        $query = "UPDATE childrens
                    SET 
                      is_present = ?,
                      missing_reason = ?,
                      missing_from = ?,
                      missing_to = ?
                    WHERE id = ?
                 ";
        $statement = $this->db->prepare($query);
        $statement->execute(['no', $reason, $missingFromDate, $missingToDate, $id]);
    }

    public function changeToPresent(string $id)
    {
        if (!$this->childExist($id)){
            throw new \Exception('Детето го няма в регистъра');
        }

        $query = "UPDATE childrens
                    SET 
                      is_present = ?,
                      missing_reason = ?,
                      missing_from = ?,
                      missing_to = ?
                    WHERE id = ?
                 ";
        $statement = $this->db->prepare($query);
        $statement->execute(['yes', null, null, null, $id]);

    }

    private function groupExist($id)
    {
        $query = "SELECT id FROM groups WHERE id = ?";
        $statement = $this->db->prepare($query);
        $statement->execute([$id]);

        $row = $statement->fetchRow();

        return !!$row;
    }

    private function childExist($id)
    {
        $query = "SELECT id FROM childrens WHERE id = ?";
        $statement = $this->db->prepare($query);
        $statement->execute([$id]);

        $row = $statement->fetchRow();

        return !!$row;
    }

    private function extractDate($inputDate)
    {
        //$spacePosition = strpos($inputDate, " ");
        //return substr($inputDate, 0, $spacePosition - 1);
        return trim(substr($inputDate, 0, 10));
    }
}