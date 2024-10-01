<?php

declare(strict_types=1);

namespace SergeyZatulivetrov\TinkoffAcquiring\Data;

/**
 * Create Beneficiaries
 *
 * @url https://developer.tbank.ru/docs/api/post-api-v-1-nominal-accounts-beneficiaries
 *
 * @property string       $type          Name of product
 * @property string       $firstName     Number or weight of the goods
 * @property string       $middleName    Cost of goods in kopecks
 * @property string       $lastName      Price per unit of goods in kopecks

 */
class CreateBeneficiaries extends AbstractData
{
}
