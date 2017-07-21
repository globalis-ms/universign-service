<?php

namespace Globalis\Universign\Response;

class TransactionDocument extends Base
{
    protected $attributesDefinitions = [
        /**
         * This TransactionDocument type
         */
        'documentType' => true,
        /**
         * The raw content of the PDF document. You can
         * provide the document using the url field, other-
         * wise this field is mandatory.
         */
        'content' => true,
        /**
         * The file name of this document.
         */
        'name' => true,
        /**
         * A description of a visible PDF signature field.
         */
        'signatureFields' => true,
        /**
         * checkBoxTexts
         */
        'checkBoxTexts' => true,
        /**
         * Texts of the agreement checkboxes. The last one
         * should be the text of the checkbox related to sig-
         * nature fields labels agreement.
         */
        'metaData' => true,
        /**
         * A name used for display purpose. If it is null,
         * then the name attribute is displayed.
         */
        'displayName' => true,
        /**
         * A description of a visible PDF signature field.
         */
        'signatureFields' => true,
        /**
         * A structure containing data to create a SEPA mandate PDF.
         */
        'SEPAData' => true,
    ];
}
