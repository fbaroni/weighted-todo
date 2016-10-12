<?php
namespace Domain\Messages;

class TaskMessages implements MessageInterface
{
    public function getCreated()
    {
        return 'Task created succesfully.';
    }

    public function getDeleted()
    {
        return 'Task deleted succesfully.';
    }

    public function getUpdated()
    {
        return 'Task updated succesfully.';
    }
}