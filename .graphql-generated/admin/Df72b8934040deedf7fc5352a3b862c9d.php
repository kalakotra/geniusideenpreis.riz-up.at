<?php

 /** GENERATED CODE -- DO NOT MODIFY **/

namespace SSGraphQLSchema_21232f297a57a5a743894a0e4a801fc3;
use GraphQL\Type\Definition\EnumType;
// @type:DBTimeFormattingOptions
class Df72b8934040deedf7fc5352a3b862c9d extends EnumType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'DBTimeFormattingOptions',
            'values' => [
                        'TIMESTAMP' => [
                    'value' => 'Timestamp',
                                ],
                        'NICE' => [
                    'value' => 'Nice',
                                ],
                        'SHORT' => [
                    'value' => 'Short',
                                ],
                        'CUSTOM' => [
                    'value' => 'CUSTOM',
                                ],
                    ],
                    'description' => 'Formatting options for fields that map to DBTime data types',
                ]);
    }
}
