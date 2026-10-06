<?php

namespace Api\Middlewares\Boletim;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Server\MiddlewareInterface;
use Slim\Routing\RouteContext;
use Api\Http\ErrorResponse;


class ValidateBoletimId implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): Response
    {
        $routeContext = RouteContext::fromRequest($request);

        $route = $routeContext->getRoute();

        $routeArgs = $route->getArguments();

        if (!isset($routeArgs['id_boletim']) || $routeArgs['id_boletim'] === "") {
            throw new ErrorResponse(
                httpCode: 400,
                message: "Erro na validação de dados",
                error: [
                    "message" => "O parâmetro 'id_boletim' é obrigatório!"
                ]
            );
        }

        return $handler->handle(request: $request);
    }
}
