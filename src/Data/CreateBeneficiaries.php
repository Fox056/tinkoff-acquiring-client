<?php

declare(strict_types=1);

namespace SergeyZatulivetrov\TinkoffAcquiring\Data;

/**
 * Create Beneficiaries
 *
 * @url https://developer.tbank.ru/docs/api/post-api-v-1-nominal-accounts-beneficiaries
 *
 * @property string $type          Type
 * @property string $phoneNumber   Phone
 * @property string $email         Email
 * @property string $addresses     Addresses
 * @property string $registrationDate Date
 * @property string $inn           INN
 * @property string $ogrn          OGRN
 * @property string $firstName     Name
 * @property string $middleName    Surname
 * @property string $lastName      Family name
 * @property string $birthDate     Date
 * @property string $birthPlace    Place
 * @property string $citizenship   Citizen
 * @property string $documents     Docs
 * @property string $name          Name company
 * @property string $opf           OPF
 *name
 */
class CreateBeneficiaries extends AbstractDataWithToken
{
    function uuidv4()
    {
        $data = random_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

}
