<?php
class Brand {

    private $AcceptanceBrandCode;
    private $ProductBrandCode;

    public function setAcceptanceBrandCode($AcceptanceBrandCode)
    {
        $this->AcceptanceBrandCode = $AcceptanceBrandCode;
    }

    public function getAcceptanceBrandCode()
    {
        return $this->AcceptanceBrandCode;
    }

    public function setProductBrandCode($ProductBrandCode)
    {
        $this->ProductBrandCode = $ProductBrandCode;
    }

    public function getProductBrandCode()
    {
        return $this->ProductBrandCode;
    }
}