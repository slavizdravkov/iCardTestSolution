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
    public function getisPresent()
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
        return 5;
    }
}