<?php namespace Gzero\Api\Controller;

use Gzero\Api\UrlParamsProcessor;
use Gzero\Core\BlockHandler;
use Gzero\Repository\BlockRepository;
use Gzero\Repository\LangRepository;


//use Illuminate\Support\Facades\Response;

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
        $blockRepo,
        $handler;

    public function __construct(
        BlockRepository $block,
        BlockHandler $blockHandler,
        UrlParamsProcessor $processor,
        LangRepository $lang
    ) {
        $this->blockRepo = $block;
        $this->processor = $processor;
        $this->langRepo  = $lang;
        $this->handler   = $blockHandler;
    }

    /**
     * Display a listing of the resource.
     *
     * @api        {get} /bocks Get blocks list
     * @apiVersion 0.1.0
     * @apiName    GetBlockList
     * @apiGroup   Block
     * @apiExample Example usage:
     * curl -i http://localhost/api/v1/blocks
     * @apiSuccess {Array} data List of blocks (Array of Objects)
     * @return Response
     */
    public function index()
    {
        $lang = $this->langRepo->getCurrent();
        if (!empty($lang)) {
            $regions = array();
            $blocks  = $this->blockRepo->getAllActive($lang);
            foreach ($blocks as $block) {
                $this->handler->build($block, $lang);

                foreach ($block->getRegions() as $region) {
                    $regions[$region][] = $block->view;
                }

            }
            return $this->respondWithSuccess(
                [
                    'data' => $regions,
                ]
            );
        }
        return $this->respondNotFound();
    }

    /**
     * Display a listing of the resource.
     *
     * @api        {get} /blocks/:id Get single block
     * @apiVersion 0.1.0
     * @apiName    GetBlock
     * @apiGroup   Block
     *
     * @apiParam {Number} id Block unique ID.
     *
     * @apiSuccess {Object[]} rendered view in HTML.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $lang  = $this->langRepo->getCurrent();
        $block = $this->blockRepo->getById($id);

        if (!empty($block) and !empty($lang)) {
            $this->handler->build($block, $lang);

            return $this->respondWithSuccess(
                [
                    'data' => $block->view,
                ]
            );
        }
        return $this->respondNotFound();
    }
} 
