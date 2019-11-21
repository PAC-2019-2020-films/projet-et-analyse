<?php


namespace DAO;


use Model\Report;
use DateTime;
use Model\Review;
use Model\User;

class ReportDAO extends BaseDAO
{
    private string $table = 'reports';

    /**
     * ReportDAO constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @return bool|Report[]
     */
    public function selectAllReports()
    {
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.message,
                        {$this->table}.created_at, 
                        {$this->table}.treated, 
                        {$this->table}.fk_user_id, 
                        {$this->table}.fk_review_id
                FROM {$this->table}
                ORDER BY {$this->table}.created_at;
                ";

        $result = $this->select($sql);

        if (is_array($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param int $id
     * @return bool|Report
     */
    public function selectReportById(int $id)
    {
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.message, 
                        {$this->table}.created_at, 
                        {$this->table}.treated, 
                        {$this->table}.fk_user_id, 
                        {$this->table}.fk_review_id
                FROM {$this->table}
                WHERE {$this->table}.id = :id;
                ";

        $condition = [':id' => $id];

        $result = $this->select($sql, $condition);

        if (is_array($result)) {
            return $result[0];
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param DateTime $date
     * @return bool|Report[]
     */
    public function selectReportsByDate(DateTime $date)
    {
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.message, 
                        {$this->table}.created_at, 
                        {$this->table}.treated, 
                        {$this->table}.fk_user_id, 
                        {$this->table}.fk_review_id
                FROM {$this->table}
                WHERE {$this->table}.id = :date
                ORDER BY {$this->table}.created_at;
                ";

        $condition = [':date' => $date];

        $result = $this->select($sql, $condition);

        if (is_array($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param bool $treated
     * @return bool|Report[]
     */
    public function selectReportsByTreated(bool $treated)
    {
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.message, 
                        {$this->table}.created_at, 
                        {$this->table}.treated, 
                        {$this->table}.fk_user_id, 
                        {$this->table}.fk_review_id
                FROM {$this->table}
                WHERE {$this->table}.treated = :treated
                ORDER BY {$this->table}.created_at;
                ";

        $condition = [':treated' => $treated];

        $result = $this->select($sql, $condition);

        if (is_array($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param User $user
     * @return bool|Report[]
     */
    public function selectReportsByUser(User $user)
    {
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.message, 
                        {$this->table}.created_at, 
                        {$this->table}.treated, 
                        {$this->table}.fk_user_id, 
                        {$this->table}.fk_review_id
                FROM {$this->table}
                WHERE {$this->table}.fk_user_id = :userId
                ORDER BY {$this->table}.created_at;
                ";

        $condition = [':userId' => $user->getId()];

        $result = $this->select($sql, $condition);

        if (is_array($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param Review $review
     * @return bool|Report[]
     */
    public function selectReportsByReview(Review $review)
    {
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.message, 
                        {$this->table}.created_at, 
                        {$this->table}.treated, 
                        {$this->table}.fk_user_id, 
                        {$this->table}.fk_review_id
                FROM {$this->table}
                WHERE {$this->table}.fk_review_id = :reviewId
                ORDER BY {$this->table}.created_at;
                ";

        $condition = [':reviewId' => $review->getId()];

        $result = $this->select($sql, $condition);

        if (is_array($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }


    /**
     * @param Report $report
     * @return bool|int
     */
    public function insertReport(Report $report)
    {
        $data = [
            'message' => $report->getMessage(),
            'created_at' => $report->getCreatedAt(),
            'treated' => $report->getCreatedAt(),
            'fk_user_id' => $report->getUser()->getId(),
            'fk_review_id' => $report->getReview()->getId()
        ];

        $result = $this->insert($this->table, $data);

        if (is_int($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param Report $report
     * @return bool|int
     */
    public function updateReport(Report $report)
    {
        $data = [
            'message' => $report->getMessage(),
            'created_at' => $report->getCreatedAt(),
            'treated' => $report->getCreatedAt(),
            'fk_user_id' => $report->getUser()->getId(),
            'fk_review_id' => $report->getReview()->getId()
        ];

        $condition = "{$this->table}.id = {$report->getId()}";

        $result = $this->update($this->table, $data, $condition);

        if (is_int($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */
        return false;
    }

    /**
     * @param Report $report
     * @return bool|int
     */
    public function deleteReport(Report $report)
    {
        $condition = "{$this->table}.id = {$report->getId()}";

        $result = $this->delete($this->table, $condition);

        if (is_int($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

}