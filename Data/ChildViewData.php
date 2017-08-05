<?php


namespace Data;


class ChildViewData
{
    private $name;

    private $surName;

    private $lastName;

    private $egn;

    private $admissionDate;

    private $dismissionDate;

    private $isPresent;

    private $missingReason;

    private $missingFrom;

    private $missingTo;

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
    public function getAdmissionDate()
    {
        return $this->admissionDate;
    }

    /**
     * @return mixed
     */
    public function getDismissionDate()
    {
        return $this->dismissionDate;
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


}