<?php

namespace Services;


use Adapter\DatabaseInterface;
use Data\ChildViewData;
use Data\Group;
use Data\TemplatesViewData;

class ChildService implements ChildServiceInterface
{
    const BASE_SELECT_QUERY = "          
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
          ";
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
     * Функция, показваща всички деца, посещаващи градината
     */
    public function findAllAccepted()
    {
        $query = self::BASE_SELECT_QUERY
                    . " WHERE status = 'accepted' AND dismission_date IS NULL
                      ORDER BY childrens.name";

        $statement = $this->db->prepare($query);
        $statement->execute();

        while ($child = $statement->fetchObject(ChildViewData::class)) {
            yield $child;
        }
    }

    /**
     * @return ChildViewData[]|\Generator
     * Показва всички деца, чакащи за постъпване
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
     * Намира всички деца по зададена дата на постъпване
     */
    public function findByAdmissionDate(string $admissionDate)
    {
        $admDate = $this->extractDate($admissionDate);
        $query = self::BASE_SELECT_QUERY
                    . " WHERE DATE_FORMAT (childrens.admission_date, '%e.%m.%Y') = ? AND dismission_date IS NULL";

        $statement = $this->db->prepare($query);
        $statement->execute([$admDate]);

        while ($child = $statement->fetchObject(ChildViewData::class)) {
            yield $child;
        }

    }

    /**
     * @param string $dismissionDate
     * @return ChildViewData[]|\Generator
     * Намира всички отписани деца по здадена дата
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
     * Намира деца по зададено име
     */
    public function findByName(string $name)
    {
        $query = self::BASE_SELECT_QUERY
                    ." WHERE childrens.name = ? AND dismission_date IS NULL";

        $statement = $this->db->prepare($query);
        $statement->execute([$name]);

        while ($child = $statement->fetchObject(ChildViewData::class)) {
            yield $child;
        }
    }

    /**
     * @param string $groupName
     * @return ChildViewData[]|\Generator
     * Намира деца по зададена група
     */
    public function findByGroup(string $groupName)
    {
        $query = self::BASE_SELECT_QUERY
                    . " WHERE groups.name = ? AND childrens.dismission_date IS NULL";

        $statement = $this->db->prepare($query);
        $statement->execute([$groupName]);

        while ($child = $statement->fetchObject(ChildViewData::class)) {
            yield $child;
        }
    }

    /**
     * @return ChildViewData[]|\Generator
     * Намира всички деца, които отсъстват в момента
     */
    public function findByMissingNow()
    {
        $query = self::BASE_SELECT_QUERY
                    . " WHERE is_present = 'no' AND dismission_date IS NULL";

        $statement = $this->db->prepare($query);
        $statement->execute();

        while ($child = $statement->fetchObject(ChildViewData::class)) {
            yield $child;
        }

    }

    /**
     * @return TemplatesViewData
     * Връща всички групи, в които има свободни места
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
                    WHERE childrens.group_id = groups.id) < 9";
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

    /**
     * @return TemplatesViewData
     * Връща всички групи в детската градина
     */
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

    /**
     * @param $name
     * @param $surName
     * @param $lastName
     * @param $egn
     * @param $groupId
     * @throws \Exception
     * Функция за добавяне на дете в регистъра
     */
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

        if (!$this->isValidEgn($egn)){
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

    /**
     * @param string $reason
     * @param string $missingTo
     * @param string $id
     * @throws \Exception
     * Функция за отбелязване на дадено дете като отсъстващо
     */
    public function changeToMissing(string $reason, string $missingTo, string $id)
    {
        if (empty($reason)){
            throw new \Exception('Не е въведена причина за отсъствието.');
        }

        if (empty($missingTo)){
            throw new \Exception('Не е въведено до кога ще отсъства.');
        }

        if (!$this->childExist($id)){
            throw new \Exception('Детето го няма в регистъра.');
        }

        if (!$this->isValidDate($missingTo)){
            throw new \Exception('Въведената дата е грешна.');
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

    /**
     * @param string $id
     * @throws \Exception
     * Функция за отбелязване на дадено дете като присъстващо
     */
    public function changeToPresent(string $id)
    {
        if (!$this->childExist($id)){
            throw new \Exception('Детето го няма в регистъра.');
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

    /**
     * @param $id
     * @return bool
     * Проверка дали има група с даденото id
     */
    private function groupExist($id)
    {
        $query = "SELECT id FROM groups WHERE id = ?";
        $statement = $this->db->prepare($query);
        $statement->execute([$id]);

        $row = $statement->fetchRow();

        return !!$row;
    }

    /**
     * @param $id
     * @return bool
     * Проверка дали има дете с даденото id
     */
    private function childExist($id)
    {
        $query = "SELECT id FROM childrens WHERE id = ?";
        $statement = $this->db->prepare($query);
        $statement->execute([$id]);

        $row = $statement->fetchRow();

        return !!$row;
    }

    /**
     * @param $inputDate
     * @return string
     * Взема само датата от полето за въвеждане на дата
     */
    private function extractDate($inputDate)
    {
        return trim(substr($inputDate, 0, 10));
    }

    /**
     * @param $egn
     * @return bool
     * Функция за проверка валидността на цифрите, показващи месеца в ЕГН-то
     */
    private function isValidEgn($egn)
    {
        $today = new \DateTime();
        $currentYear = intval($today->format('Y')) % 100;
        $egnYear = intval(substr($egn, 0, 2));
        $egnMonth = intval(substr($egn, 2, 2));
        $egnDay = intval(substr($egn, 4, 2));

        if (strval($egnYear) !== substr($egn, 0, 2)){
            return false;
        }

        if ($currentYear <= $egnYear){
            return false;
        }

        if ($egnMonth < 41 ||  $egnMonth > 52){
            return false;
        }

        if ($egnDay < 1 || $egnDay > 31){
            return false;
        }

        return true;
    }

    /**
     * @param $userDate
     * @return bool
     * Функция за провека дали въведената дата не е преди текущата
     */
    private function isValidDate($userDate)
    {
        $now = new \DateTime();
        $inputDate = new \DateTime($userDate);
        //$interval = $inputDate->diff($now);

        return $now < $inputDate;
    }
}