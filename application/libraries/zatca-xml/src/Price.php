<?php

namespace BaseetApp\UBL;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class Price implements XmlSerializable
{
    private $priceAmount;
    private $baseQuantity;
    private $unitCode = UnitCode::UNIT;

    private $allowanceCharges;

    /**
     * @return float
     */
    public function getPriceAmount(): ?float
    {
        return $this->priceAmount;
    }

    /**
     * @param float $priceAmount
     * @return Price
     */
    public function setPriceAmount(?float $priceAmount): Price
    {
        $this->priceAmount = $priceAmount;
        return $this;
    }

    /**
     * @return float
     */
    public function getBaseQuantity(): ?float
    {
        return $this->baseQuantity;
    }

    /**
     * @param float $baseQuantity
     * @return Price
     */
    public function setBaseQuantity(?float $baseQuantity): Price
    {
        $this->baseQuantity = $baseQuantity;
        return $this;
    }

    /**
     * @return string
     */
    public function getUnitCode(): ?string
    {
        return $this->unitCode;
    }

    /**
     * @param string $unitCode
     * See also: src/UnitCode.php
     * @return Price
     */
    public function setUnitCode(?string $unitCode): Price
    {
        $this->unitCode = $unitCode;
        return $this;
    }

    /**
     * @return array
     */
    public function getAllowanceCharges(): ?array
    {
        return $this->allowanceCharges;
    }

    /**
     * @param array $allowanceCharges
     * See also: src/UnitCode.php
     * @return Price
     */
    public function setAllowanceCharges(?array $allowanceCharges): Price
    {
        $this->allowanceCharges = $allowanceCharges;
        return $this;
    }
    
    /**
     * The xmlSerialize method is called during xml writing.
     *
     * @param Writer $writer
     * @return void
     */
    public function xmlSerialize(Writer $writer)
    {
        $writer->write([
            [
                'name' => Schema::CBC . 'PriceAmount',
                'value' => $this->priceAmount, //number_format($this->priceAmount, 2, '.', ''),
                'attributes' => [
                    'currencyID' => Generator::$currencyID
                ]
            ],
            // [
            //     'name' => Schema::CBC . 'BaseQuantity',
            //     'value' => number_format($this->baseQuantity, 2, '.', ''),
            //     'attributes' => [
            //         'unitCode' => $this->unitCode
            //     ]
            // ],
        ]);

        if ($this->allowanceCharges !== null) {
            foreach ($this->allowanceCharges as $allowanceCharge) {
                $writer->write([
                    Schema::CAC . 'AllowanceCharge' => $allowanceCharge
                ]);
            }
        }

    }
}
