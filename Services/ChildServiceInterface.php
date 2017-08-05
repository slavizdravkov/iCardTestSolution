<?php

namespace Service;


use Data\ChildViewData;

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

}