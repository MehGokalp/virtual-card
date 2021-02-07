<?php

namespace VirtualCard\Schema\Vendor\Remove;

use Symfony\Component\Validator\Constraints as Assert;

class Result
{
    /**
     * @var int|null
     *
     * @Assert\NotBlank()
     */
    private $status;

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int|null $status
     * @return Result
     */
    public function setStatus(?int $status): Result
    {
        $this->status = $status;

        return $this;
    }
}