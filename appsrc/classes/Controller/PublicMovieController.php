<?php


namespace Controller;

use Service\PublicService;

class PublicMovieController
{
    private PublicService $publicServices;

    /**
     * PublicMovieController constructor.
     */
    public function __construct()
    {
        $this->publicServices = new PublicService();
    }



}