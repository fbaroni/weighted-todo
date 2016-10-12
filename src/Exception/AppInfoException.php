<?php
namespace Domain\Exception;

class AppInfoException extends AppException
{
    public function __construct($message = 'Info', \Exception $previous = null, $type = null, $code = null)
    {
        parent::__construct($message, AppException::INFO, $previous);
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
