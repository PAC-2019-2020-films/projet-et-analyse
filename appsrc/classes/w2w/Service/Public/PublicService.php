<?php
/**
 * Created by PhpStorm.
 * User: Meh
 * Date: 14/11/2019
 * Time: 20:27
 */

namespace Service;


use DAO\MovieDAO;
use DAO\CategoryDAO;
use DAO\RatingDAO;
use DAO\ReviewDAO;
use DAO\UserDAO;
use DAO\RoleDAO;
use DAO\MovieActorDAO;
use DAO\MovieDirectorDAO;
use DAO\MovieTagsDAO;

use Model\Artist;
use Model\Category;
use Model\Movie;
use Model\Rating;
use Model\Review;
use Model\Role;
use Model\Tag;
use Model\User;

class PublicService extends BaseService
{

    protected MovieDAO $movieDAO;
    protected CategoryDAO $categoryDAO;
    protected ReviewDAO $reviewDAO;
    protected UserDAO $userDAO;
    protected RoleDAO $roleDAO;
    protected RatingDAO $ratingDAO;
    protected MovieActorDAO $movieActorDAO;
    protected MovieDirectorDAO $movieDirectorDAO;
    protected MovieTagsDAO $movieTagsDAO;

    /**
     * PublicService constructor.
     */
    public function __construct()
    {
        $this->movieDAO = new MovieDAO();
        $this->categoryDAO = new CategoryDAO();
        $this->reviewDAO = new ReviewDAO();
        $this->userDAO = new UserDAO();
        $this->roleDAO = new RoleDAO();
        $this->ratingDAO = new RatingDAO();
        $this->movieActorDAO = new MovieActorDAO();
        $this->movieDirectorDAO = new MovieDirectorDAO();
        $this->movieTagsDAO = new MovieTagsDAO();
    }







}