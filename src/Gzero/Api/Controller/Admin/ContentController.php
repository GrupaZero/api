<?php namespace Gzero\Api\Controller\Admin;

use Gzero\Api\Controller\ApiController;
use Gzero\Api\Transformer\ContentTransformer;
use Gzero\Api\UrlParamsProcessor;
use Gzero\Api\Validator\ContentValidator;
use Gzero\Repository\ContentRepository;
use Illuminate\Support\Facades\Auth;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class ContentController
 *
 * @package    Gzero\Admin\Controllers\Resource
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class ContentController extends ApiController {

    /**
     * @var ContentRepository
     */
    protected $repository;

    /**
     * @var ContentValidator
     */
    protected $validator;

    /**
     * ContentController constructor.
     *
     * @param UrlParamsProcessor $processor Url processor
     * @param ContentRepository  $content   Content repository
     * @param ContentValidator   $validator Content validator
     */
    public function __construct(UrlParamsProcessor $processor, ContentRepository $content, ContentValidator $validator)
    {
        parent::__construct($processor);
        $this->validator  = $validator->setData(\Input::all());
        $this->repository = $content;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int|null $id Id used for nested resources
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id = null)
    {
        $input  = $this->validator->validate('list');
        $params = $this->processor->process($input)->getProcessedFields();
        if ($id) { // content/id/children
            $content = $this->repository->getById($id);
            if (!empty($content)) {
                $results = $this->repository->getChildren(
                    $content,
                    $params['filter'],
                    $params['orderBy'],
                    $params['page'],
                    $params['perPage']
                );
                return $this->respondWithSuccess($results, new ContentTransformer);
            } else {
                return $this->respondNotFound();
            }
        }
        $results = $this->repository->getContents(
            $params['filter'],
            $params['orderBy'],
            $params['page'],
            $params['perPage']
        );
        return $this->respondWithSuccess($results, new ContentTransformer);
    }

    /**
     * Display a listing of the resource as nested tree.
     *
     * @param int|null $id Id used for nested resources
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexTree($id = null)
    {
        $input  = $this->validator->validate('tree');
        $params = $this->processor->process($input)->getProcessedFields();
        $this->getSerializer()->parseIncludes('children'); // We need to enable children include to return tree from api
        if ($id) { // Single tree
            $content = $this->repository->getById($id);
            if (!empty($content)) {
                return $this->respondWithSuccess(
                    $this->repository->getTree(
                        $content,
                        $params['filter'],
                        $params['orderBy']
                    ),
                    new ContentTransformer
                );
            } else {
                return $this->respondNotFound();
            }
        }
        // All trees
        $params['filter'] = array_merge(['type' => ['value' => 'category', 'relation' => null]], $params['filter']);

        $roots = $this->repository->getRoots(
            $params['filter'],
            $params['orderBy']
        );
        $roots->transform(
            function ($item) use ($params) {
                return $this->repository->getTree(
                    $item,
                    $params['filter'],
                    $params['orderBy']
                );
            }
        );
        return $this->respondWithSuccess(
            $roots,
            new ContentTransformer
        );
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
        $content = $this->repository->getById($id);
        if (!empty($content)) {
            return $this->respondWithSuccess($content, new ContentTransformer);
        }
        return $this->respondNotFound();
    }

    /**
     * Stores newly created content in database.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $input   = $this->validator->validate('create');
        $content = $this->repository->create($input, Auth::user());
        return $this->respondWithSuccess($content, new ContentTransformer);
    }

    /**
     * Updates the specified resource in the database.
     *
     * @param int $id Content id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        $content = $this->repository->getById($id);
        if (!empty($content)) {
            $input   = $this->validator->validate('update');
            $content = $this->repository->update($content, $input, Auth::user());
            return $this->respondWithSuccess($content, new ContentTransformer);
        }
        return $this->respondNotFound();
    }

    /**
     * Remove the specified resource from database.
     *
     * @param int $id Content id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $content = $this->repository->getById($id);
        if (!empty($content)) {
            $this->repository->delete($content);
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
 * @api                 {get} /admin/contents 1. GET collection of root entities
 * @apiVersion          0.1.0
 * @apiName             GetContentList
 * @apiGroup            Content
 * @apiPermission       admin
 * @apiDescription      Get root contents
 * @apiUse              Meta
 * @apiUse              Params
 * @apiUse              ContentCollection
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/contents
 */
/**
 * @api                 {get} /admin/contents/tree 2. GET trees for all root entities
 * @apiVersion          0.1.0
 * @apiName             GetContentTree
 * @apiGroup            Content
 * @apiPermission       admin
 * @apiDescription      Get all root contents with children as tree
 * @apiUse              ContentTree
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/contents/tree
 */
/**
 * @api                 {get} /admin/contents/tree/:id 3. GET tree for single root entity
 * @apiVersion          0.1.0
 * @apiName             GetContentChildrenTree
 * @apiGroup            Content
 * @apiPermission       admin
 * @apiParam {Number} id The Content ID
 * @apiDescription      Get content with children as tree
 * @apiUse              ContentTree
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/contents/tree/1
 */
/**
 * @api                 {get} /admin/contents/:id/children 4. GET collection of entities
 * @apiVersion          0.1.0
 * @apiName             GetContentChildrenList
 * @apiGroup            Content
 * @apiPermission       admin
 * @apiParam {Number} id The Content ID
 * @apiDescription      Get children contents
 * @apiUse              Meta
 * @apiUse              Params
 * @apiUse              ContentCollection
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/contents/1/children
 */
/**
 * @api                 {get} /admin/contents/:id 5. GET single entity
 * @apiVersion          0.1.0
 * @apiName             GetContent
 * @apiGroup            Content
 * @apiPermission       admin
 * @apiDescription      Get the specified content from database
 * @apiUse              Content
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/contents/123
 */
/**
 * @api                 {post} /admin/contents 6. POST newly created entity
 * @apiVersion          0.1.0
 * @apiName             PostContent
 * @apiGroup            Content
 * @apiPermission       admin
 * @apiDescription      Store newly created content in database
 * @apiUse              Content
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/api/v1/admin/contents
 */
/**
 * @api                 {put} /admin/contents 7. PUT the specified entity
 * @apiVersion          0.1.0
 * @apiName             PutContent
 * @apiGroup            Content
 * @apiPermission       admin
 * @apiDescription      Update the specified content in database
 * @apiUse              Content
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/api/v1/admin/contents
 */
/**
 * @api                 {delete} /admin/contents 8. DELETE the specified entity
 * @apiVersion          0.1.0
 * @apiName             DeleteContent
 * @apiGroup            Content
 * @apiPermission       admin
 * @apiDescription      Delete the specified content from database
 * @apiSuccess {Boolean} success Success flag
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/api/v1/admin/contents
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 * {"success":true}
 */

/**
 * @apiDefine           Content
 * @apiSuccess {Number} id Content id
 * @apiSuccess {Number} rating Content rating
 * @apiSuccess {Number} visits Content visit counter
 * @apiSuccess {Array} path Tree path for this node
 * @apiSuccess {Object} route Route for this Content
 * @apiSuccess {Object} author Author of this Content
 * @apiSuccess {Array} translations List of active translations (Array of Objects)
 * @apiSuccess {Boolean} isOnHome Home page flag
 * @apiSuccess {Boolean} isCommentAllowed Is comment allowed flag
 * @apiSuccess {Boolean} isPromoted Is promoted flag
 * @apiSuccess {Boolean} isSticky Is sticky flag
 * @apiSuccess {Boolean} isActive Is content active flag
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
 * @apiDefine           ContentTree
 * @apiSuccess {Number} id Content id
 * @apiSuccess {Number} rating Content rating
 * @apiSuccess {Number} visits Content visit counter
 * @apiSuccess {Array} path Tree path for this node
 * @apiSuccess {Object} route Route for this Content
 * @apiSuccess {Object} author Author of this Content
 * @apiSuccess {Array} translations List of active translations (Array of Objects)
 * @apiSuccess {Array} children List of children (Array of Objects)
 * @apiSuccess {Boolean} isOnHome Home page flag
 * @apiSuccess {Boolean} isCommentAllowed Is comment allowed flag
 * @apiSuccess {Boolean} isPromoted Is promoted flag
 * @apiSuccess {Boolean} isSticky Is sticky flag
 * @apiSuccess {Boolean} isActive Is content active flag
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
 *        {Content},
 *        ...
 *    ]
 *}
 */

/**
 * @apiDefine           ContentCollection
 * @apiSuccess {Array[]} data Array of Contents
 * @apiSuccess {Number} data.id Content id
 * @apiSuccess {Number} data.rating Content rating
 * @apiSuccess {Number} data.visits Content visit counter
 * @apiSuccess {Array} data.path Tree path for this node
 * @apiSuccess {Object} data.route Route for this Content
 * @apiSuccess {Object} data.author Author of this Content
 * @apiSuccess {Array} data.translations List of active translations (Array of Objects)
 * @apiSuccess {Boolean} data.isOnHome Home page flag
 * @apiSuccess {Boolean} data.isCommentAllowed Is comment allowed flag
 * @apiSuccess {Boolean} data.isPromoted Is promoted flag
 * @apiSuccess {Boolean} data.isSticky Is sticky flag
 * @apiSuccess {Boolean} data.isActive Is content active flag
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
 *        "link": "http://api.gzero.dev:8000/v1/admin/contents"
 *    },
 *    "params": {
 *        "page": 1,
 *        "perPage": 20,
 *        "filter": [],
 *        "orderBy": []
 *    },
 *    "data": [
 *        {Content},
 *        ...
 *    ]
 *}
 */

/*
|--------------------------------------------------------------------------
| END API DOCS
|--------------------------------------------------------------------------
*/
