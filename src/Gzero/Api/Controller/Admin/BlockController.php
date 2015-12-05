<?php namespace Gzero\Api\Controller\Admin;

use Gzero\Api\Controller\ApiController;
use Gzero\Api\Transformer\BlockTransformer;
use Gzero\Api\UrlParamsProcessor;
use Gzero\Api\Validator\BlockValidator;
use Gzero\Repository\BlockRepository;
use Illuminate\Support\Facades\Auth;

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

    /**
     * @var BlockRepository
     */
    protected $repository;

    /**
     * @var BlockValidator
     */
    protected $validator;

    /**
     * BlockController constructor.
     *
     * @param UrlParamsProcessor $processor Url processor
     * @param BlockRepository    $block     Block repository
     * @param BlockValidator     $validator Block validator
     */
    public function __construct(UrlParamsProcessor $processor, BlockRepository $block, BlockValidator $validator)
    {
        parent::__construct($processor);
        $this->validator  = $validator->setData(\Input::all());
        $this->repository = $block;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $input  = $this->validator->validate('list');
        $params = $this->processor->process($input)->getProcessedFields();
        $results = $this->repository->getBlocks(
            $params['filter'],
            $params['orderBy'],
            $params['page'],
            $params['perPage']
        );
        return $this->respondWithSuccess($results, new BlockTransformer);
    }

    /**
     * Display list of soft deleted blocks
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexOfDeleted()
    {
        $input  = $this->validator->validate('list');
        $params = $this->processor->process($input)->getProcessedFields();

        $results = $this->repository->getDeletedBlocks(
            $params['filter'],
            $params['orderBy'],
            $params['page'],
            $params['perPage']
        );

        return $this->respondWithSuccess($results, new BlockTransformer);
    }

    /**
     * Display a specified resource.
     *
     * @param int $id Id of the resource
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $block = $this->repository->getById($id);
        if (!empty($block)) {
            return $this->respondWithSuccess($block, new BlockTransformer);
        }
        return $this->respondNotFound();
    }

    /**
     * Stores newly created block in database.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $input   = $this->validator->validate('create');
        $block = $this->repository->create($input, Auth::user());
        return $this->respondWithSuccess($block, new BlockTransformer);
    }

    /**
     * Updates the specified resource in the database.
     *
     * @param int $id Block id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        $block = $this->repository->getById($id);
        if (!empty($block)) {
            $input   = $this->validator->validate('update');
            $block = $this->repository->update($block, $input, Auth::user());
            return $this->respondWithSuccess($block, new BlockTransformer);
        }
        return $this->respondNotFound();
    }

    /**
     * Removes the specified resource from database.
     *
     * @param int  $id          Block id
     *
     * @param bool $forceDelete if true use forceDelete
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, $forceDelete = false)
    {
        $forceDelete = filter_var($forceDelete, FILTER_VALIDATE_BOOLEAN);

        $block = $forceDelete ? $this->repository->getDeletedById($id) : $this->repository->getById($id);

        if (!empty($block)) {
            if ($forceDelete) {
                $this->repository->forceDelete($block);
            } else {
                $this->repository->delete($block);
            }
            return $this->respondWithSimpleSuccess(['success' => true]);
        }
        return $this->respondNotFound();
    }

    /**
     * Restore soft deleted block
     *
     * @param int $id Block id
     *
     * @return mixed
     */
    public function restore($id)
    {
        $block = $this->repository->getDeletedById($id);
        if (!empty($block)) {
            $block->restore();
            return $this->respondWithSimpleSuccess(['success' => true]);
        }
        return $this->respondNotFound();
    }

}

/*
|--------------------------------------------------------------------------
| START API DOCS
|--------------------------------------------------------------------------
*/
/**
 * @api                 {get} /admin/blocks 1. GET collection of entities
 * @apiVersion          0.1.0
 * @apiName             GetBlockList
 * @apiGroup            Block
 * @apiPermission       admin
 * @apiDescription      Get root blocks
 * @apiUse              Meta
 * @apiUse              Params
 * @apiUse              BlockCollection
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/blocks
 */
/**
 * @api                 {get} /admin/blocks/:id 5. GET single entity
 * @apiVersion          0.1.0
 * @apiName             GetBlock
 * @apiGroup            Block
 * @apiPermission       admin
 * @apiDescription      Get the specified block from database
 * @apiUse              Block
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/blocks/123
 */
/**
 * @api                 {post} /admin/blocks 6. POST newly created entity
 * @apiVersion          0.1.0
 * @apiName             PostBlock
 * @apiGroup            Block
 * @apiPermission       admin
 * @apiDescription      Store newly created block in database
 * @apiUse              Block
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/api/v1/admin/blocks
 */
/**
 * @api                 {put} /admin/blocks 7. PUT the specified entity
 * @apiVersion          0.1.0
 * @apiName             PutBlock
 * @apiGroup            Block
 * @apiPermission       admin
 * @apiDescription      Update the specified block in database
 * @apiUse              Block
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/api/v1/admin/blocks
 */
/**
 * @api                 {delete} /admin/blocks 8. DELETE the specified entity
 * @apiVersion          0.1.0
 * @apiName             DeleteBlock
 * @apiGroup            Block
 * @apiPermission       admin
 * @apiDescription      Delete the specified block from database
 * @apiSuccess {Boolean} success Success flag
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/api/v1/admin/blocks
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 * {"success":true}
 */

/**
 * @apiDefine           Block
 * @apiSuccess {Number} id Block id
 * @apiSuccess {Number} rating Block rating
 * @apiSuccess {Number} visits Block visit counter
 * @apiSuccess {Array} path Tree path for this node
 * @apiSuccess {Object} route Route for this Block
 * @apiSuccess {Object} author Author of this Block
 * @apiSuccess {Array} translations List of active translations (Array of Objects)
 * @apiSuccess {Boolean} isOnHome Home page flag
 * @apiSuccess {Boolean} isCommentAllowed Is comment allowed flag
 * @apiSuccess {Boolean} isPromoted Is promoted flag
 * @apiSuccess {Boolean} isSticky Is sticky flag
 * @apiSuccess {Boolean} isActive Is block active flag
 * @apiSuccess {Date} publishedAt Date of publication
 * @apiSuccess {Date} createdAt Creation date
 * @apiSuccess {Date} updatedAt Update date
 *
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 *{
 *   "id": 1,
 *   "type": "category",
 *   "weight": 3,
 *   "isActive": false,
 *   "path": [
 *       1
 *   ],
 *   "createdAt": "2014-12-23T13:28:23+0000",
 *   "updatedAt": "2014-12-23T13:28:23+0000",
 *   "route": {
 *       "id": 1,
 *       "createdAt": "2014-12-23T13:28:23+0000",
 *       "updatedAt": "2014-12-23T13:28:23+0000",
 *       "translations": [
 *           {
 *               "id": 1,
 *               "lang": "en",
 *               "url": "example-url",
 *               "isActive": 1,
 *               "createdAt": "2014-12-23T13:28:23+0000",
 *               "updatedAt": "2014-12-23T13:28:23+0000"
 *           },
 *           {
 *               "id": 2,
 *               "lang": "pl",
 *               "url": "non",
 *               "isActive": 1,
 *               "createdAt": "2014-12-23T13:28:23+0000",
 *               "updatedAt": "2014-12-23T13:28:23+0000"
 *           }
 *       ]
 *   },
 *   "author": {
 *       "id": 1,
 *       "email": "a@a.pl",
 *       "firstName": "John",
 *       "lastName": "Doe"
 *   },
 *   "translations": [
 *       {
 *           "id": 1,
 *           "lang": "en",
 *           "title": "Example title",
 *           "body": "Example body",
 *           "isActive": 1,
 *           "createdAt": "2014-12-23T13:28:23+0000",
 *           "updatedAt": "2014-12-23T13:28:23+0000"
 *       },
 *       {
 *           "id": 2,
 *           "lang": "pl",
 *           "title": "title",
 *           "body": "Example body",
 *           "isActive": 1,
 *           "createdAt": "2014-12-23T13:28:23+0000",
 *           "updatedAt": "2014-12-23T13:28:23+0000"
 *       }
 *   ]
 *}
 */
/**
 * @apiDefine           BlockTree
 * @apiSuccess {Number} id Block id
 * @apiSuccess {Number} rating Block rating
 * @apiSuccess {Number} visits Block visit counter
 * @apiSuccess {Array} path Tree path for this node
 * @apiSuccess {Object} route Route for this Block
 * @apiSuccess {Object} author Author of this Block
 * @apiSuccess {Array} translations List of active translations (Array of Objects)
 * @apiSuccess {Array} children List of children (Array of Objects)
 * @apiSuccess {Boolean} isOnHome Home page flag
 * @apiSuccess {Boolean} isCommentAllowed Is comment allowed flag
 * @apiSuccess {Boolean} isPromoted Is promoted flag
 * @apiSuccess {Boolean} isSticky Is sticky flag
 * @apiSuccess {Boolean} isActive Is block active flag
 * @apiSuccess {Date} publishedAt Date of publication
 * @apiSuccess {Date} createdAt Creation date
 * @apiSuccess {Date} updatedAt Update date
 *
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 *{
 *   "id": 1,
 *   "type": "category",
 *   "weight": 3,
 *   "isActive": false,
 *   "path": [
 *       1
 *   ],
 *   "createdAt": "2014-12-23T13:28:23+0000",
 *   "updatedAt": "2014-12-23T13:28:23+0000",
 *   "route": {
 *       "id": 1,
 *       "createdAt": "2014-12-23T13:28:23+0000",
 *       "updatedAt": "2014-12-23T13:28:23+0000",
 *       "translations": [
 *           {
 *               "id": 1,
 *               "lang": "en",
 *               "url": "example-url",
 *               "isActive": 1,
 *               "createdAt": "2014-12-23T13:28:23+0000",
 *               "updatedAt": "2014-12-23T13:28:23+0000"
 *           },
 *           {
 *               "id": 2,
 *               "lang": "pl",
 *               "url": "non",
 *               "isActive": 1,
 *               "createdAt": "2014-12-23T13:28:23+0000",
 *               "updatedAt": "2014-12-23T13:28:23+0000"
 *           }
 *       ]
 *   },
 *   "author": {
 *       "id": 1,
 *       "email": "a@a.pl",
 *       "firstName": "John",
 *       "lastName": "Doe"
 *   },
 *   "translations": [
 *       {
 *           "id": 1,
 *           "lang": "en",
 *           "title": "Example title",
 *           "body": "Example body",
 *           "isActive": 1,
 *           "createdAt": "2014-12-23T13:28:23+0000",
 *           "updatedAt": "2014-12-23T13:28:23+0000"
 *       },
 *       {
 *           "id": 2,
 *           "lang": "pl",
 *           "title": "title",
 *           "body": "Example body",
 *           "isActive": 1,
 *           "createdAt": "2014-12-23T13:28:23+0000",
 *           "updatedAt": "2014-12-23T13:28:23+0000"
 *       }
 *   ]
 *    "children": [
 *        {Block},
 *        ...
 *    ]
 *}
 */

/**
 * @apiDefine           BlockCollection
 * @apiSuccess {Array[]} data Array of Blocks
 * @apiSuccess {Number} data.id Block id
 * @apiSuccess {Number} data.rating Block rating
 * @apiSuccess {Number} data.visits Block visit counter
 * @apiSuccess {Array} data.path Tree path for this node
 * @apiSuccess {Object} data.route Route for this Block
 * @apiSuccess {Object} data.author Author of this Block
 * @apiSuccess {Array} data.translations List of active translations (Array of Objects)
 * @apiSuccess {Boolean} data.isOnHome Home page flag
 * @apiSuccess {Boolean} data.isCommentAllowed Is comment allowed flag
 * @apiSuccess {Boolean} data.isPromoted Is promoted flag
 * @apiSuccess {Boolean} data.isSticky Is sticky flag
 * @apiSuccess {Boolean} data.isActive Is block active flag
 * @apiSuccess {Date} data.publishedAt Date of publication
 * @apiSuccess {Date} data.createdAt Creation date
 * @apiSuccess {Date} data.updatedAt Update date
 *
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 *{
 *        "meta": {
 *        "total": 75,
 *        "perPage": 20,
 *        "currentPage": 1,
 *        "lastPage": 4,
 *        "link": "http://api.gzero.dev:8000/v1/admin/blocks"
 *    },
 *    "params": {
 *        "page": 1,
 *        "perPage": 20,
 *        "filter": [],
 *        "orderBy": []
 *    },
 *    "data": [
 *        {Block},
 *        ...
 *    ]
 *}
 */

/*
|--------------------------------------------------------------------------
| END API DOCS
|--------------------------------------------------------------------------
*/
