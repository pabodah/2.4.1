<?php
namespace Paboda\Company\Api;

interface CompanyRepositoryInterface
{
    /**
     * @param $data
     * @return mixed
     */
    /*public function saveCompanyData($data);*/

    /**
     * @return mixed
     */
    /*public function filterCompanyData();*/

    public function save(
        \Paboda\Company\Api\Data\CompanyInterface $company
    );
}
