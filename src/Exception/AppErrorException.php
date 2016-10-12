<?php
namespace Domain\Exception;

class AppErrorException extends AppException
{
    public function __construct($message = 'Error', \Exception $previous = null, $type = null, $code = null)
    {
        parent::__construct($message, AppException::ERROR, $previous);
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}
