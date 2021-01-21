<?php
namespace Paboda\Company\Api;

interface CompanyRepositoryInterface
{
    /**
     * @param Data\CompanyInterface $company
     * @return mixed
     */
    public function save(
        \Paboda\Company\Api\Data\CompanyInterface $company
    );
}
