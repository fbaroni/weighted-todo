<?php
namespace Domain\Exception;

class AppWarningException extends AppException
{
    public function __construct($message = 'Warning', \Exception $previous = null, $type = null, $code = null)
    {
        parent::__construct($message, AppException::WARNING, $previous);
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
