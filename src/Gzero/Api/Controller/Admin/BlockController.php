<?php namespace Gzero\Api\Controller\Admin;

use Gzero\Api\Controller\ApiController;
use Gzero\Api\UrlParamsProcessor;
use Gzero\Repository\BlockRepository;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class BlockController
 *
 * @package    Gzero\Admin\Controllers\Resource
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class BlockController extends ApiController {

    protected $processor;

    protected $blockRepo;

    /**
     * BlockController constructor
     *
     * @param BlockRepository    $block     Block repository
     * @param UrlParamsProcessor $processor Url processor
     */
    public function __construct(BlockRepository $block, UrlParamsProcessor $processor)
    {
        $this->blockRepo = $block;
        $this->processor = $processor;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->blockRepo->get($this->processor->getPage(), $this->processor->getOrderByParams());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $id Block id
     *
     * @return Response
     */
    public function show($id)
    {
        return $this->blockRepo->getById($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id Block id
     *
     * @return Response
     * @SuppressWarnings("unused")
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id Block id
     *
     * @return Response
     * @SuppressWarnings("unused")
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id Block id
     *
     * @return Response
     * @SuppressWarnings("unused")
     */
    public function destroy($id)
    {
        //
    }
}
