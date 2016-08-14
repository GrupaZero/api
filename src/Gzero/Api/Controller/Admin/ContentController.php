<?php namespace Gzero\Api\Controller\Admin;

use Gzero\Api\Controller\ApiController;
use Gzero\Api\Transformer\ContentTransformer;
use Gzero\Api\UrlParamsProcessor;
use Gzero\Api\Validator\ContentValidator;
use Gzero\Entity\Content;
use Gzero\Repository\ContentRepository;
use Illuminate\Support\Collection as LaravelCollection;

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
        $this->authorize('readList', Content::class);
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
     * Display list of soft deleted contents
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexOfDeleted()
    {
        $this->authorize('readList', Content::class);
        $input  = $this->validator->validate('list');
        $params = $this->processor->process($input)->getProcessedFields();

        $results = $this->repository->getDeletedContents(
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
        $this->authorize('readList', Content::class);
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
        //$params['filter'] = array_merge(['type' => ['value' => 'category', 'relation' => null]], $params['filter']);
        $nodes = $this->repository->getContentsByLevel(
            $params['filter'],
            $params['orderBy'],
            null
        );

        $trees = $this->repository->buildTree($nodes);
        // We need to guarantee LaravelCollection here because buildTree will return single root
        // if we have only one
        if (!empty($trees) && !$trees instanceof LaravelCollection) {
            $trees = new LaravelCollection([$trees]);
        }
        return $this->respondWithSuccess($trees, new ContentTransformer);
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
            $this->authorize('read', $content);
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
        $this->authorize('create', Content::class);
        $input   = $this->validator->validate('create');
        $content = $this->repository->create($input, auth()->user());
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
            $this->authorize('update', $content);
            $input   = $this->validator->validate('update');
            $content = $this->repository->update($content, $input, auth()->user());
            return $this->respondWithSuccess($content, new ContentTransformer);
        }
        return $this->respondNotFound();
    }

    /**
     * Removes the specified resource from database.
     *
     * @param int  $id          Content id
     *
     * @param bool $forceDelete if true use forceDelete
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id, $forceDelete = false)
    {
        $forceDelete = filter_var($forceDelete, FILTER_VALIDATE_BOOLEAN);

        $content = $forceDelete ? $this->repository->getDeletedById($id) : $this->repository->getById($id);

        if (!empty($content)) {
            $this->authorize('delete', $content);
            if ($forceDelete) {
                $this->repository->forceDelete($content);
            } else {
                $this->repository->delete($content);
            }
            return $this->respondWithSimpleSuccess(['success' => true]);
        }
        return $this->respondNotFound();
    }

    /**
     * Restore soft deleted content
     *
     * @param int $id Content id
     *
     * @return mixed
     */
    public function restore($id)
    {
        $content = $this->repository->getDeletedById($id);
        if (!empty($content)) {
            $this->authorize('update', $content);
            $content->restore();
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
 * @apiSuccess {Number} parentId Content parent id
 * @apiSuccess {String} type Content type
 * @apiSuccess {String} theme Content theme
 * @apiSuccess {Number} weight Content weight
 * @apiSuccess {Number} rating Content rating
 * @apiSuccess {Number} visits Content visit counter
 * @apiSuccess {Boolean} isActive Is content active flag
 * @apiSuccess {Boolean} isOnHome Home page flag
 * @apiSuccess {Boolean} isCommentAllowed Is comment allowed flag
 * @apiSuccess {Boolean} isPromoted Is promoted flag
 * @apiSuccess {Boolean} isSticky Is sticky flag
 * @apiSuccess {Array} path Tree path for this node
 * @apiSuccess {Date} publishedAt Date of publication
 * @apiSuccess {Date} createdAt Creation date
 * @apiSuccess {Date} updatedAt Update date
 * @apiSuccess {Object} route Route for this Content
 * @apiSuccess {Object} author Author of this Content
 * @apiSuccess {Array} translations List of active translations (Array of Objects)
 *
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 *{
 *   "id": 1,
 *   "type": "category",
 *   "weight": 3,
 *   "theme": null,
 *   "weight": 0,
 *   "isActive": false,
 *   "isOnHome": false,
 *   "isCommentAllowed": true,
 *   "isPromoted": false,
 *   "isSticky": true,
 *   "rating": 1,
 *   "visits": 1,
 *   "path": [
 *       1
 *   ],
 *   "publishedAt": "2015-12-13 12:10:59",
 *   "createdAt": "2015-12-13 12:10:59",
 *   "updatedAt": "2015-12-13 12:10:59",
 *   "route": {
 *       "id": 1,
 *       "createdAt": "2015-12-13 12:10:59",
 *       "updatedAt": "2015-12-13 12:10:59",
 *       "translations": [
 *           {
 *               "id": 1,
 *               "lang": "en",
 *               "url": "example-url",
 *               "isActive": 1,
 *               "createdAt": "2015-12-13 12:10:59",
 *               "updatedAt": "2015-12-13 12:10:59"
 *           },
 *           {
 *               "id": 2,
 *               "lang": "pl",
 *               "url": "example-url",
 *               "isActive": true,
 *               "createdAt": "2015-12-13 12:10:59",
 *               "updatedAt": "2015-12-13 12:10:59"
 *           }
 *       ]
 *   },
 *   "author": {
 *       "id": 1,
 *       "email": "admin@gzero.pl",
 *       "firstName": "John",
 *       "lastName": "Doe"
 *   },
 *   "translations": [
 *       {
 *           "id": 1,
 *           "lang": "en",
 *           "title": "Example title",
 *           "body": "Example body",
 *           "isActive": true,
 *           "createdAt": "2015-12-13 12:10:59",
 *           "updatedAt": "2015-12-13 12:10:59"
 *       },
 *       {
 *           "id": 2,
 *           "lang": "pl",
 *           "title": "title",
 *           "body": "Example body",
 *           "isActive": true,
 *           "createdAt": "2015-12-13 12:10:59",
 *           "updatedAt": "2015-12-13 12:10:59"
 *       }
 *   ]
 *}
 */
/**
 * @apiDefine           ContentTree
 * @apiSuccess {Number} id Content id
 * @apiSuccess {Number} parentId Content parent id
 * @apiSuccess {String} type Content type
 * @apiSuccess {String} theme Content theme
 * @apiSuccess {Number} weight Content weight
 * @apiSuccess {Number} rating Content rating
 * @apiSuccess {Number} visits Content visit counter
 * @apiSuccess {Boolean} isActive Is content active flag
 * @apiSuccess {Boolean} isOnHome Home page flag
 * @apiSuccess {Boolean} isCommentAllowed Is comment allowed flag
 * @apiSuccess {Boolean} isPromoted Is promoted flag
 * @apiSuccess {Boolean} isSticky Is sticky flag
 * @apiSuccess {Array} path Tree path for this node
 * @apiSuccess {Date} publishedAt Date of publication
 * @apiSuccess {Date} createdAt Creation date
 * @apiSuccess {Date} updatedAt Update date
 * @apiSuccess {Object} route Route for this Content
 * @apiSuccess {Object} author Author of this Content
 * @apiSuccess {Array} translations List of active translations (Array of Objects)
 *
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 *{
 *   "id": 1,
 *   "type": "category",
 *   "weight": 3,
 *   "theme": null,
 *   "weight": 0,
 *   "isActive": false,
 *   "isOnHome": false,
 *   "isCommentAllowed": true,
 *   "isPromoted": false,
 *   "isSticky": true,
 *   "rating": 1,
 *   "visits": 1,
 *   "path": [
 *       1
 *   ],
 *   "publishedAt": "2015-12-13 12:10:59",
 *   "createdAt": "2015-12-13 12:10:59",
 *   "updatedAt": "2015-12-13 12:10:59",
 *   "route": {
 *       "id": 1,
 *       "createdAt": "2015-12-13 12:10:59",
 *       "updatedAt": "2015-12-13 12:10:59",
 *       "translations": [
 *           {
 *               "id": 1,
 *               "lang": "en",
 *               "url": "example-url",
 *               "isActive": 1,
 *               "createdAt": "2015-12-13 12:10:59",
 *               "updatedAt": "2015-12-13 12:10:59"
 *           },
 *           {
 *               "id": 2,
 *               "lang": "pl",
 *               "url": "example-url",
 *               "isActive": true,
 *               "createdAt": "2015-12-13 12:10:59",
 *               "updatedAt": "2015-12-13 12:10:59"
 *           }
 *       ]
 *   },
 *   "author": {
 *       "id": 1,
 *       "email": "admin@gzero.pl",
 *       "firstName": "John",
 *       "lastName": "Doe"
 *   },
 *   "translations": [
 *       {
 *           "id": 1,
 *           "lang": "en",
 *           "title": "Example title",
 *           "body": "Example body",
 *           "isActive": true,
 *           "createdAt": "2015-12-13 12:10:59",
 *           "updatedAt": "2015-12-13 12:10:59"
 *       },
 *       {
 *           "id": 2,
 *           "lang": "pl",
 *           "title": "title",
 *           "body": "Example body",
 *           "isActive": true,
 *           "createdAt": "2015-12-13 12:10:59",
 *           "updatedAt": "2015-12-13 12:10:59"
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
 * @apiSuccess {Number} data.parentId Content parent id
 * @apiSuccess {String} data.type Content type
 * @apiSuccess {String} data.theme Content theme
 * @apiSuccess {Number} data.weight Content weight
 * @apiSuccess {Number} data.rating Content rating
 * @apiSuccess {Number} data.visits Content visit counter
 * @apiSuccess {Boolean} data.isActive Is content active flag
 * @apiSuccess {Boolean} data.isOnHome Home page flag
 * @apiSuccess {Boolean} data.isCommentAllowed Is comment allowed flag
 * @apiSuccess {Boolean} data.isPromoted Is promoted flag
 * @apiSuccess {Boolean} data.isSticky Is sticky flag
 * @apiSuccess {Array} data.path Tree path for this node
 * @apiSuccess {Date} data.publishedAt Date of publication
 * @apiSuccess {Date} data.createdAt Creation date
 * @apiSuccess {Date} data.updatedAt Update date
 * @apiSuccess {Object} data.route Route for this Content
 * @apiSuccess {Object} data.author Author of this Content
 * @apiSuccess {Array} data.translations List of active translations (Array of Objects)
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
