<?php

declare(strict_types=1);

namespace Tests\Feature\Articles;

use Tests\TestCase;

class ArticlesListTest extends TestCase
{
    /**
     * @test
     * @dataProvider dataForValidator
     */
    public function validator_works(array $invalidData, string $invalidField): void
    {
        $queryParameters = '';

        foreach ($invalidData as $key => $value) {
            $queryParameters .= '&' . $key . '=' . $value;
        }

        $response = $this->get('api/articles?' . $queryParameters);
        $response->assertStatus(400);
        $response->assertJsonStructure([$invalidField]);
    }

    /**
     * @test
     */
    public function returns_articles_data(): void
    {
        $response = $this->get('api/articles');

        $response->assertOk();
        $response->assertJsonStructure(
            [
                '*' => [
                    'id',
                    'title',
                    'content',
                    'created_at',
                    'comments_count',
                    'tags' => [
                        '*' => [
                            'id',
                            'title',
                        ]
                    ]
                ]
            ]
        );
    }

    /**
     * @test
     */
    public function returns_articles_paginated_data(): void
    {
        $response = $this->get('api/articles?paginate=5');

        $response->assertOk();
        $response->assertJsonStructure([
            'current_page',
            'data'  => [
                '*' => [
                    'id',
                    'title',
                    'content',
                    'created_at',
                    'comments_count',
                    'tags' => [
                        '*' => [
                            'id',
                            'title',
                        ]
                    ]
                ]
            ],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'links' => [
                '*' => [
                    'url',
                    'label',
                    'active',
                ]
            ],
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total'
        ]);
    }

    public function dataForValidator(): array
    {
        return [
            [
                [
                    'sort'  => 'invalid_value',
                    'order' => 'asc',
                ],
                'sort'
            ],
            [
                [
                    'sort'  => 'created_at',
                    'order' => 'invalid_value',
                ],
                'order'
            ]
        ];
    }
}
