<?php

namespace Services;


use Data\ChildViewData;
use Data\TemplatesViewData;

interface ChildServiceInterface
{
    /**
     * @return ChildViewData[]|\Generator
     */
    public function findAllAccepted();

    /**
     * @return ChildViewData[]|\Generator
     */
    public function findAllWaiting();

    /**
     * @param string $admissionDate
     * @return ChildViewData[]|\Generator
     */
    public function findByAdmissionDate(string $admissionDate);

    /**
     * @param string $dismissionDate
     * @return ChildViewData[]|\Generator
     */
    public function findByDismissionDate(string $dismissionDate);

    /**
     * @param string $name
     * @return ChildViewData[]|\Generator
     */
    public function findByName(string $name);

    /**
     * @param string $groupName
     * @return ChildViewData[]|\Generator
     */
    public function findByGroup(string $groupName);

    /**
     * @return ChildViewData[]|\Generator
     */
    public function findByMissingNow();

    /**
     * @return TemplatesViewData
     */
    public function getAddChildViewData();

    public function addChild($name, $surName, $lastName, $egn, $groupName);

    public function changeToMissing(string $reason, string $missingTo, string $id);

    public function changeToPresent(string $id);

}