<?php
namespace Domain\Entity;

interface TaskInterface
{
    public function getProgress();
    public function getPriority();
}