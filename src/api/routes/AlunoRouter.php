<?php

namespace Api\Routes;

use Slim\App;
use Api\Controllers\AlunoController;
use Api\Middlewares\Aluno\ValidateAlunoBody;
use Api\Middlewares\Aluno\ValidateAlunoId;

class AlunoRouter
{
    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function setupRoutes(): void
    {
       
        $this->app->post(
            '/alunos',
            [AlunoController::class, 'createController']
        )
            ->add(ValidateAlunoBody::class);

        
        $this->app->get(
            '/alunos',
            [AlunoController::class, 'findAllController']
        );

     
        $this->app->get(
            '/alunos/count',
            [AlunoController::class, 'countController']
        );

       
        $this->app->get(
            '/alunos/{id_aluno}',
            [AlunoController::class, 'findByIdController']
        )
            ->add(ValidateAlunoId::class);

      
        $this->app->put(
            '/alunos/{id_aluno}',
            [AlunoController::class, 'updateController']
        )
            ->add(ValidateAlunoBody::class)
            ->add(ValidateAlunoId::class);

      
        $this->app->delete(
            '/alunos/{id_aluno}',
            [AlunoController::class, 'deleteController']
        )
            ->add(ValidateAlunoId::class);
    }
}