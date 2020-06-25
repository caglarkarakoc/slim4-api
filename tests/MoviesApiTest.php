<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;
use App\Test\HttpTrait;

class MoviesApiTest extends TestCase
{
    use HttpTrait;

    public function testMovieShow()
    {
        $id = 1;
        $request = $this->createRequest('GET', '/api/v1/movies/'.$id);
        $response = $this->request($request);

        $result = json_decode($response->getBody(), true);
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertSame($result['success'], true);
        $this->assertSame($result['data']['id'], $id);
    }

    public function testMovieCreate()
    {
        $request = $this->createRequest('POST', '/api/v1/movies/create');
        $request = $this->withFormData($request, [
            'title' => 'The Green Mile',
            'description' => 'The lives of guards on Death Row are affected by one of their charges: a black man accused of child murder and rape, yet who has a mysterious gift.',
            'year' => 1999
        ]);
        $response = $this->request($request);

        $result = json_decode($response->getBody(), true);
        $this->assertSame($response->getStatusCode(), 201);
        $this->assertSame($result['success'], true);
        $this->assertSame($result['message'], 'Movie successfully added.');
    }

    public function testMovieUpdate()
    {
        $id = 2;

        $movie = [
            'title' => 'Fight Club',
            'description' => 'An insomniac office worker and a devil-may-care soapmaker form an underground fight club that evolves into something much, much more.',
            'year' => 1999
        ];

        $request = $this->createRequest('PUT', '/api/v1/movies/'.$id);
        $request = $this->withFormData($request, $movie);
        $response = $this->request($request);

        $result = json_decode($response->getBody(), true);
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertSame($result['success'], true);
        $this->assertSame($result['message'], 'Movie successfully updated.');
    }

    public function testMovieDelete()
    {
        $id = 1;
        $request = $this->createRequest('DELETE', '/api/v1/movies/'.$id);
        $response = $this->request($request);

        $result = json_decode($response->getBody(), true);
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertSame($result['success'], true);
        $this->assertSame($result['message'], 'Movie successfully deleted.');
    }
}
