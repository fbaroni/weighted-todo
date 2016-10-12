<?php
namespace Domain\Messages;

interface MessageInterface
{
    public function getCreated();
    public function getDeleted();
    public function getUpdated();
}