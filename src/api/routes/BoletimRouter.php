<?php

namespace Api\Routes;

use Slim\App;
use Api\Controllers\BoletimController;
use Api\Middlewares\Boletim\ValidateBoletimBody;
use Api\Middlewares\Boletim\ValidateBoletimId;

class BoletimRouter
{
    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function setupRoutes(): void
    {
        
        $this->app->post(
            '/boletins',
            [BoletimController::class, 'createController']
        )
            ->add(ValidateBoletimBody::class);

        $this->app->get(
            '/boletins',
            [BoletimController::class, 'findAllController']
        );

        $this->app->get(
            '/boletins/count',
            [BoletimController::class, 'countController']
        );

        $this->app->get(
            '/boletins/{id_boletim}',
            [BoletimController::class, 'findByIdController']
        )
            ->add(ValidateBoletimId::class);

       
        $this->app->put(
            '/boletins/{id_boletim}',
            [BoletimController::class, 'updateController']
        )
            ->add(ValidateBoletimBody::class)
            ->add(ValidateBoletimId::class);


        $this->app->delete(
            '/boletins/{id_boletim}',
            [BoletimController::class, 'deleteController']
        )
            ->add(ValidateBoletimId::class);
    }
}