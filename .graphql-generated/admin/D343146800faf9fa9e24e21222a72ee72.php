<?php

 /** GENERATED CODE -- DO NOT MODIFY **/

namespace SSGraphQLSchema_21232f297a57a5a743894a0e4a801fc3;
use GraphQL\Type\Definition\EnumType;
// @type:DBTextFormattingOption
class D343146800faf9fa9e24e21222a72ee72 extends EnumType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'DBTextFormattingOption',
            'values' => [
                        'CONTEXT_SUMMARY' => [
                    'value' => 'ContextSummary',
                                ],
                        'FIRST_PARAGRAPH' => [
                    'value' => 'FirstParagraph',
                                ],
                        'LIMIT_SENTENCES' => [
                    'value' => 'LimitSentences',
                                ],
                        'SUMMARY' => [
                    'value' => 'Summary',
                                ],
                    ],
                    'description' => 'Formatting options for fields that map to DBText data types',
                ]);
    }
}
