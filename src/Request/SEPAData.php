<?php

namespace Globalis\Universign\Request;

class SEPAData extends Base
{
    protected $attributesDefinitions = [
        'rum' => 'string',
        'ics' => 'string',
        'iban' => 'string',
        'bic' => 'string',
        'recurring' => 'bool',
        'debtor' => 'Globalis\Universign\Request\SEPAThirdParty',
        'creditor' => 'Globalis\Universign\Request\SEPAThirdParty',
    ];
}
