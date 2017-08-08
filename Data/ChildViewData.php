<?php


namespace Data;


class ChildViewData
{
    private $id;

    private $name;

    private $surName;

    private $lastName;

    private $egn;

    private $groupName;

    private $teacherName;

    private $admissionDate;

    private $isPresent;

    private $missingReason;

    private $missingFrom;

    private $missingTo;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSurName()
    {
        return $this->surName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getEgn()
    {
        return $this->egn;
    }

    /**
     * @return mixed
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * @return mixed
     */
    public function getTeacherName()
    {
        return $this->teacherName;
    }

    /**
     * @return mixed
     */
    public function getAdmissionDate()
    {
        return $this->admissionDate;
    }

    /**
     * @return mixed
     */
    public function getIsPresent()
    {
        return $this->isPresent;
    }

    /**
     * @return mixed
     */
    public function getMissingReason()
    {
        return $this->missingReason;
    }

    /**
     * @return mixed
     */
    public function getMissingFrom()
    {
        return $this->missingFrom;
    }

    /**
     * @return mixed
     */
    public function getMissingTo()
    {
        return $this->missingTo;
    }

    public function getAge()
    {
        $today = new \DateTime();
        $year = intval($today->format('Y')); //Вземаме текущата година
        $kidBornYear = $year - (($year - intval(substr($this->getEgn(),0,2))) % 10); //Изчисляване годината на раждане на детето
        $kidBornMonth = intval(substr($this->getEgn(),2,2)) - 40; //Изчисляваме месеца на раждане
        $kidBornDay = intval(substr($this->getEgn(),4,2));  //Вземаме дена на раждане на детето
        $kidBornDate = new \DateTime("{$kidBornYear}-{$kidBornMonth}-{$kidBornDay}");
        $interval = $today->diff($kidBornDate); //Намираме разликата между днешната дата и датата на раждане

        return $interval->format('%y'); //Връщаме разликата конвертирана в години
    }

    public function getPresentStatus()
    {
        if ($this->getIsPresent() === 'yes') {
            return 'Да';
        }

        if ($this->getIsPresent() === null) {
            return 'Детето е отписано';
        }

        return 'Не';
    }

    public function isPresentNow()
    {
        return $this->getIsPresent() === 'yes';
    }

    public function getMissingPeriod()
    {
        if ($this->getIsPresent() === 'no'){
            return "от {$this->getMissingFrom()} до {$this->getMissingTo()}";
        }
    }
}