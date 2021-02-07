<?php

namespace VirtualCard\Schema\VirtualCard\Remove;

class Result
{
    /**
     * @var int|null
     */
    private $status;

    /**
     * @return int
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return Result
     */
    public function setStatus(?int $status): Result
    {
        $this->status = $status;

        return $this;
    }
}
