<?php

declare(strict_types=1);

namespace Tests\Feature\Articles;

use Tests\TestCase;

class ArticleCommentsListTest extends TestCase
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

        $response = $this->get('api/articles/1/comments?' . $queryParameters);
        $response->assertStatus(400);
        $response->assertJsonStructure([$invalidField]);
    }

    /**
     * @test
     */
    public function should_respond_with_not_found(): void
    {
        $response = $this->get('api/articles/99999/comments');

        $response->assertNotFound();
    }

    /**
     * @test
     */
    public function returns_article_comments_data(): void
    {
        $response = $this->get('api/articles/1/comments');

        $response->assertOk();
        $response->assertJsonStructure(
            [
                '*' => [
                    'id',
                    'content',
                    'created_at'
                ]
            ]
        );
    }

    public function dataForValidator(): array
    {
        return [
            [
                [
                    'order' => 'invalid_value',
                ],
                'order'
            ]
        ];
    }
}
