<?php

namespace Api\Server;

use Slim\App;
use Psr\Http\Message\ServerRequestInterface;
use Api\Http\ErrorResponse;
use Api\Routes\CursoRouter;  
use Api\Routes\ProfessorRouter;
use Api\Routes\AlunoRouter; 
use Api\Routes\DisciplinaRouter;
use Api\Routes\BoletimRouter;

class Server
{
    private App $app;
   
    private CursoRouter $cursoRouter;
    private ProfessorRouter $professorRouter;
    private AlunoRouter $alunoRouter;
    private DisciplinaRouter $disciplinaRouter;
    private BoletimRouter $boletimRouter;

    public function __construct(
        App $app,
        CursoRouter $cursoRouter,
        ProfessorRouter $professorRouter,
        AlunoRouter $alunoRouter,
        DisciplinaRouter $disciplinaRouter,
        BoletimRouter $boletimRouter
    ) {
        $this->app = $app;
        $this->cursoRouter = $cursoRouter;
        $this->professorRouter = $professorRouter;
        $this->alunoRouter = $alunoRouter;
        $this->disciplinaRouter = $disciplinaRouter;
        $this->boletimRouter = $boletimRouter;
        
        $this->setupMiddlewares();
        $this->setupRoutes();
        $this->setupErrorHandling();
    }

    private function setupMiddlewares(): void
    {
        $this->app->addBodyParsingMiddleware();

        $this->app->add(function ($request, $handler) {
            $response = $handler->handle($request);

            return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        });
    }

    private function setupRoutes(): void
    {
        $this->cursoRouter->setupRoutes();
        $this->professorRouter->setupRoutes();
        $this->alunoRouter->setupRoutes();
        $this->disciplinaRouter->setupRoutes();
        $this->boletimRouter->setupRoutes();

        $this->app->get('/', function ($request, $response) {
            return $response
                ->withHeader('Location', '/login.html')
                ->withStatus(302);
        });
    }

    private function setupErrorHandling(): void
    {
        $errorMiddleware = $this->app->addErrorMiddleware(true, true, true);

        $errorMiddleware->setDefaultErrorHandler(
            function (ServerRequestInterface $request, \Throwable $exception)  {
                  $response = new \Slim\Psr7\Response();  
                  
                $status = 500;

                if ($exception instanceof ErrorResponse) {
                    $payload = [
                        'success' => false,
                        'message' => $exception->getMessage(),
                        'error' => $exception->getError() ?? (object) [],
                    ];
                    $status = $exception->getHttpCode();
                }
                else {
                    $payload = [
                        'success' => false,
                        'message' => $exception->getMessage(),
                        'error' => [
                            'code' => $exception->getCode(),
                            'sack' => $exception->getTrace(),
                            'file' => $exception->getFile(),
                            'line' => $exception->getLine(),
                        ],
                    ];
                }

                $response->getBody()->write(json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus($status);
            }
        );
    }

    public function run(): void
    {
        $this->app->run();
    }
}