<?php
namespace Paboda\Company\Api;

interface CompanyInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function saveCompanyData($data);

    /**
     * @return mixed
     */
    public function filterCompanyData();
}
