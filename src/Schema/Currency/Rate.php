<?php

namespace VirtualCard\Schema\Currency;

class Rate
{
    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $to;

    /**
     * @var float
     */
    private $rate;

    public function __construct(string $from, string $to, float $rate)
    {
        $this->from = $from;
        $this->to = $to;
        $this->rate = $rate;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }
}