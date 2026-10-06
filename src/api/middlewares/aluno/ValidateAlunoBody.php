<?php

namespace Api\Middlewares\Aluno;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Server\MiddlewareInterface;
use Api\Http\ErrorResponse;

class ValidateAlunoBody implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): Response
    {
        $body = $request->getBody()->getContents();

        $objPHP = json_decode($body);

        if (!isset($objPHP->aluno)) {
            throw new ErrorResponse(
                httpCode: 400,
                message: "Erro na validação de dados",
                error: [
                    "message" => "O campo 'aluno' é obrigatório!"
                ]
            );
        }

        $aluno = $objPHP->aluno;

        if (!isset($aluno->nomeAluno) || trim((string) $aluno->nomeAluno) === "") {
            throw new ErrorResponse(
                httpCode: 400,
                message: "Erro na validação de dados",
                error: [
                    "message" => "O campo 'nomeAluno' é obrigatório!"
                ]
            );
        }

        return $handler->handle($request);
    }
}