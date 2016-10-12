<?php
namespace Domain\Exception;

class AppException extends \RuntimeException
{
    protected $type;
    protected $originalException;

    const ERROR = 1;
    const WARNING = 2;
    const INFO = 2;

    public function __construct($message = null, $type = null,  \Exception $previous = null)
    {
        $this->type = $type;
        $this->originalException = $previous;
        parent::__construct($message, null, $previous);
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

    /**
     * @return \Exception
     */
    public function getOriginalException()
    {
        return $this->originalException;
    }

    /**
     * @return string
     */
    public function getOriginalExceptionMessage()
    {
        if ($this->originalException instanceof \Exception) {
            return $this->originalException->getMessage();
        }

        return '';
    }
}
