<?php

namespace Api\Middlewares\Boletim;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Server\MiddlewareInterface;
use Api\Http\ErrorResponse;



class ValidateBoletimBody implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): Response
    {
        $body = $request->getBody()->getContents();

        $objPHP = json_decode($body);

        if (!isset($objPHP->boletim)) {
            throw new ErrorResponse(
                httpCode: 400,
                message: "Erro na validação de dados",
                error: [
                    "message" => "O campo 'boletim' é obrigatório!"
                ]
            );
        }


        $boletim = $objPHP->boletim;
        $camposObrigatorios = ['nota', 'frequencia', 'situacao', 'id_aluno', 'id_disciplina'];
        foreach ($camposObrigatorios as $campo) {
            if (!isset($boletim->$campo)) {
                throw new ErrorResponse(400, "Erro na validação", ["message" => "O campo '$campo' é obrigatório dentro de boletim."]);
            }
        }
        return $handler->handle($request);
    }
}