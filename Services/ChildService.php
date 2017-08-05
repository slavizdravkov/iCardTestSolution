<?php

namespace Service;


use Adapter\DatabaseInterface;
use Data\ChildViewData;

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
        // TODO: Implement findAllAccepted() method.
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
}