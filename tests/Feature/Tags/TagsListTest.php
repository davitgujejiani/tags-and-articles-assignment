<?php

declare(strict_types=1);

namespace Tests\Feature\Tags;

use Tests\TestCase;

class TagsListTest extends TestCase
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

        $response = $this->get('api/tags?' . $queryParameters);
        $response->assertStatus(400);
        $response->assertJsonStructure([$invalidField]);
    }

    /**
     * @test
     */
    public function returns_tags_data(): void
    {
        $response = $this->get('api/tags');

        $response->assertOk();
        $response->assertJsonStructure(
            [
                '*' => [
                    'id',
                    'title',
                    'articles_count'
                ]
            ]
        );
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
