<?php

 /** GENERATED CODE -- DO NOT MODIFY **/

namespace SSGraphQLSchema_21232f297a57a5a743894a0e4a801fc3;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\InputObjectType;
use SilverStripe\GraphQL\Schema\Resolver\ComposedResolver;
// @type:FileInterfaceConnectionEdge
class Fd7ffebd3d42a3b2db3ba1612abb44f00 extends ObjectType{
    public function __construct()
    {
        parent::__construct([
            'name' => 'FileInterfaceConnectionEdge',
                    'description' => 'The collections edge',
                'fields' => function () {
                $fields = [];
                                                        $resolverInst =     ComposedResolver::create([
            ['SilverStripe\GraphQL\Schema\Plugin\PaginationPlugin', 'noop'],
        ])
;
                    $fields[] = [
                        'name' => 'node',
                        'type' => Types::nonNull(Types::FileInterface()),
                        'resolve' => $resolverInst->toClosure(),
                        'resolverComposition' => [
                                                            [
                                    ['SilverStripe\GraphQL\Schema\Plugin\PaginationPlugin', 'noop'],
                                ],
                                                    ],
                                            'description' => 'The node at the end of the collections edge',
                                                            ]; // field
                                return $fields;
            },
        ]);
    }
}
