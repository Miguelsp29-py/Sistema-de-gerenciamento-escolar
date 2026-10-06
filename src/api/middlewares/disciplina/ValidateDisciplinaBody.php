<?php

namespace Api\Middlewares\Disciplina;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Server\MiddlewareInterface;
use Api\Http\ErrorResponse;



class ValidateDisciplinaBody implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): Response
    {
        $body = $request->getBody()->getContents();

        $objPHP = json_decode($body);

        if (!isset($objPHP->disciplina)) {
            throw new ErrorResponse(
                httpCode: 400,
                message: "Erro na validação de dados",
                error: [
                    "message" => "O campo 'disciplina' é obrigatório!"
                ]
            );
        }

        $disciplina = $objPHP->disciplina;

        if (!isset($disciplina->nomeDisciplina) || trim((string) $disciplina->nomeDisciplina) === "") {
            throw new ErrorResponse(
                httpCode: 400,
                message: "Erro na validação de dados",
                error: [
                    "message" => "O campo 'nomeDisciplina' é obrigatório!"
                ]
            );
        }

        return $handler->handle($request);
    }
}