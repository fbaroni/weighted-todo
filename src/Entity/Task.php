<?php
namespace Domain\Entity;

class Task extends AbstractEntity
{
    /* @var double $progress */
    public $progress;

    /* @var integer $priority */
    public $priority;

    /* @var string $description */
    public $description;

    /* @var string $name */
    public $name;

    /* @var \DateTime $name */
    public $date;
}
