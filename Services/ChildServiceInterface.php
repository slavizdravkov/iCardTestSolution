<?php

namespace Services;


use Data\ChildViewData;
use Data\RegisterViewData;

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
     * @return ChildViewData[]|\Generator
     */
    public function findByAdmissionData();

    /**
     * @return ChildViewData[]|\Generator
     */
    public function findByDismissionData();

    /**
     * @return ChildViewData[]|\Generator
     */
    public function findByName();

    /**
     * @return ChildViewData[]|\Generator
     */
    public function findByGroup();

    /**
     * @return ChildViewData[]|\Generator
     */
    public function findByMissingNow();

    /**
     * @return RegisterViewData
     */
    public function getRegisterViewData();

    public function addChild($name, $surName, $lastName, $egn, $groupName = null);
}