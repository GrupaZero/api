<?php namespace Gzero\Api\Controllers;

use Gzero\Api\UrlParamsProcessor;
use Gzero\Repositories\Block\BlockRepository;

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

    protected
        $processor,
        $blockRepo;

    public function __construct(BlockRepository $block, UrlParamsProcessor $processor)
    {
        $this->blockRepo = $block;
        $this->processor = $processor;
    }

    /**
     * Display a listing of the resource.
     *
     * @api        {get} /bocks Get blocks list
     * @apiVersion 0.1.0
     * @apiName    GetBlockList
     * @apiGroup   Block
     * @apiExample Example usage:
     * curl -i http://localhost/api/v1/contents
     * @apiSuccess {Array} data List of blocks (Array of Objects)
     * @apiSuccess {Number} total Total count of all elements
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
     * @api        {get} /blocks/:id Get single block
     * @apiVersion 0.1.0
     * @apiName    GetBlock
     * @apiGroup   Block
     *
     * @apiParam {Number} id Content unique ID.
     *
     * @apiSuccess {Object[]} translations List of translations (Array of Objects).
     *
     * @param  int $id
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
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
} 
