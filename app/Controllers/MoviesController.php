<?php

namespace App\Controllers;

use App\Models\Movie;
use Psr\Log\LoggerInterface;
use Slim\Exception\NotFoundException;
use Fig\Http\Message\StatusCodeInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MoviesController extends DefaultController
{
    /**
     *
     * @var $logger
     */
    private $logger;

    /**
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Get All Movies
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function index(Request $request, Response $response) : Response
    {
        try {
            $movies = Movie::all();
        } catch (\PDOException $exception) {
            $this->logger->error($exception);
            return $response->withStatus(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            $this->logger->error($th);
            return $response->withStatus(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }

        return $this->jsonResponse($response, [
            'success' => true,
            'data' => $movies
        ], StatusCodeInterface::STATUS_OK);
    }

    /**
     * Get One Movie
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function show(Request $request, Response $response) : Response
    {
        try {
            $movie = Movie::findOrFail($request->getAttribute('id'));
        } catch (ModelNotFoundException $ModelNotFoundException) {
            $this->logger->error($ModelNotFoundException);
            return $response->withStatus(StatusCodeInterface::STATUS_NOT_FOUND);
        }

        return $this->jsonResponse($response, [
            'success' => true,
            'data' => $movie
        ], StatusCodeInterface::STATUS_OK);
    }

    /**
     * Create Movie
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function create(Request $request, Response $response) : Response
    {
        $input = $request->getParsedBody();

        try {
            $movie = Movie::create([
                'title' => $input['title'],
                'description' => $input['description'],
                'year' => $input['year']
            ]);
        } catch (\PDOException $exception) {
            $this->logger->error($exception);
            return $response->withStatus(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            $this->logger->error($th);
            return $response->withStatus(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }

        return $this->jsonResponse($response, [
            'success' => true,
            'message' => 'Movie successfully added.',
            'data' => Movie::find($movie->id)
        ], StatusCodeInterface::STATUS_CREATED);
    }

    /**
     * Update Movie
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function update(Request $request, Response $response) : Response
    {
        $id = $request->getAttribute('id');
        $input = $request->getParsedBody();

        try {
            $movie = Movie::findOrFail($id);
        } catch (ModelNotFoundException $ModelNotFoundException) {
            $this->logger->error($ModelNotFoundException);
            return $response->withStatus(StatusCodeInterface::STATUS_NOT_FOUND);
        }

        $movie->title = $input['title'];
        $movie->description = $input['description'];
        $movie->year = $input['year'];

        if (!$movie->save()) {
            $this->logger->error(
                'An error encountered while updating.',
                ['id' => $id]
            );
            return $reponse->withStatus(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }

        return $this->jsonResponse($response, [
            'success' => true,
            'message' => 'Movie successfully updated.',
            'data' => Movie::find($id)
        ], StatusCodeInterface::STATUS_OK);
    }

    /**
     * Delete Movie
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function delete(Request $request, Response $response) : Response
    {
        try {
            $movie = Movie::findOrFail($request->getAttribute('id'));
        } catch (ModelNotFoundException $ModelNotFoundException) {
            $this->logger->error($ModelNotFoundException);
            return $response->withStatus(StatusCodeInterface::STATUS_NOT_FOUND);
        }

        if (!$movie->delete()) {
            $this->logger->error(
                'An error encountered while deleting.',
                ['id' => $request->getAttribute('id')]
            );
            return $reponse->withStatus(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }

        return $this->jsonResponse($response, [
            'success' => true,
            'message' => 'Movie successfully deleted.'
        ], StatusCodeInterface::STATUS_OK);
    }
}
