<?php

 /** GENERATED CODE -- DO NOT MODIFY **/

namespace SSGraphQLSchema_21232f297a57a5a743894a0e4a801fc3;
use GraphQL\Type\Definition\EnumType;
// @type:DBDecimalFormattingOptions
class Dcebdadc14cd88b76b9bb092c11c5c332 extends EnumType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'DBDecimalFormattingOptions',
            'values' => [
                        'INT' => [
                    'value' => 'Int',
                                ],
                    ],
                    'description' => 'Formatting options for fields that map to DBDecimal data types',
                ]);
    }
}
