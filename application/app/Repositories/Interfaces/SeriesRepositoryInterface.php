<?php


namespace App\Repositories\Interfaces;


use App\Models\Series;
use Symfony\Component\HttpFoundation\Request;

interface SeriesRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param array $series
     * @return Series
     */
    public function store(array $series): Series;

    /**
     * @param array $series
     * @return bool
     */
    public function update(array $series): bool;

    /**
     * @param Request $request
     * @return mixed
     */
    public function list(Request $request);
}
