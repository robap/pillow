<?php

class Pillow_Zestimate extends Pillow_Base
{
    /**
     * Zestimate Amount
     * @var string $amount
     */
    public $amount;

    /**
     * Last updated
     * @var string $lastUpdated
     */
    public $lastUpdated;

    /**
     * Value Change
     * @var string $valueChange
     */
    public $valueChange;

    /**
     * Valuation Range (low, high)
     * @var stdClass $valuationRange
     */
    public $valuationRange;

    /**
     * Percentile
     * @var string $percentile
     */
    public $percentile;

    public function __construct()
    {
        $this->valuationRange = new stdClass;
        $this->valuationRange->low = NULL;
        $this->valuationRange->high = NULL;
    }
}

