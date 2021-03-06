<?php namespace Gzero\Api\Controller\Admin;

use Gzero\Api\Controller\ApiController;
use Gzero\Api\Transformer\BlockTransformer;
use Gzero\Api\Transformer\FileTransformer;
use Gzero\Api\UrlParamsProcessor;
use Gzero\Api\Validator\BlockValidator;
use Gzero\Core\BlockFinder;
use Gzero\Entity\Block;
use Gzero\Entity\File;
use Gzero\Repository\BlockRepository;
use Gzero\Repository\ContentRepository;
use Gzero\Repository\FileRepository;
use Gzero\Repository\RepositoryValidationException;
use Illuminate\Http\Request;

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
     * @var ContentRepository
     */
    protected $contentRepository;

    /**
     * @var FileRepository
     */
    protected $fileRepository;

    /**
     * @var BlockValidator
     */
    protected $validator;

    /**
     * @var BlockFinder
     */
    protected $finder;

    /**
     * BlockController constructor.
     *
     * @param UrlParamsProcessor $processor Url processor
     * @param BlockRepository    $block     Block repository
     * @param ContentRepository  $content   Content repository
     * @param FileRepository     $file      File Repository
     * @param BlockValidator     $validator Block validator
     * @param BlockFinder        $finder    Block Finder
     * @param Request            $request   Request object
     */
    public function __construct(
        UrlParamsProcessor $processor,
        BlockRepository $block,
        ContentRepository $content,
        FileRepository $file,
        BlockValidator $validator,
        BlockFinder $finder,
        Request $request
    ) {
        parent::__construct($processor);
        $this->validator         = $validator->setData($request->all());
        $this->repository        = $block;
        $this->contentRepository = $content;
        $this->fileRepository    = $file;
        $this->finder            = $finder;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $this->authorize('readList', Block::class);
        $input   = $this->validator->validate('list');
        $params  = $this->processor->process($input)->getProcessedFields();
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
        $this->authorize('readList', Block::class);
        $input   = $this->validator->validate('list');
        $params  = $this->processor->process($input)->getProcessedFields();
        $results = $this->repository->getDeletedBlocks(
            $params['filter'],
            $params['orderBy'],
            $params['page'],
            $params['perPage']
        );
        return $this->respondWithSuccess($results, new BlockTransformer);
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $contentId Id of the resource
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Gzero\Validator\ValidationException
     */
    public function indexForSpecificContent($contentId)
    {
        $this->authorize('readList', Block::class);
        $onlyPublic = false;
        $content    = $this->contentRepository->getById($contentId);
        if ($content) {
            $input    = $this->validator->validate('listContent');
            $params   = $this->processor->process($input)->getProcessedFields();
            $blockIds = $this->finder->getBlocksIds($content->path, $params, $onlyPublic);
            $results  = $this->repository->getVisibleBlocks($blockIds, $onlyPublic);
            return $this->respondWithSuccess($results, new BlockTransformer);
        }
        return $this->respondNotFound();
    }

    /**
     * Display a listing of the resource.
     *
     * @param int|null $blockId Block id for which we are displaying files
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexOfFiles($blockId)
    {
        $this->authorize('readList', File::class);
        $input  = $this->validator->validate('files');
        $params = $this->processor->process($input)->getProcessedFields();
        $block  = $this->repository->getById($blockId);
        if (empty($block)) {
            return $this->respondNotFound();
        }
        $results = $this->fileRepository->getEntityFiles(
            $block,
            $params['filter'],
            $params['orderBy'],
            $params['page'],
            $params['perPage']
        );
        return $this->respondWithSuccess($results, new FileTransformer);
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
            $this->authorize('read', $block);
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
        $this->authorize('create', Block::class);
        $input = $this->validator->validate('create');
        try {
            $block = $this->repository->create($input, auth()->user());
            return $this->respondWithSuccess($block, new BlockTransformer);
        } catch (RepositoryValidationException $e) {
            return $this->respondWithError($e->getMessage());
        }
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
            $this->authorize('update', $block);
            $input = $this->validator->validate('update');
            $block = $this->repository->update($block, $input, auth()->user());
            return $this->respondWithSuccess($block, new BlockTransformer);
        }
        return $this->respondNotFound();
    }

    /**
     * Removes the specified resource from database.
     *
     * @param Request $request Request object
     * @param int     $id      Block id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $forceDelete = $request->get('force', false);

        $block = $this->repository->getByIdWithTrashed($id);

        if (!empty($block)) {
            $this->authorize('delete', $block);
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
            $this->authorize('update', $block);
            $block->restore();
            return $this->respondWithSimpleSuccess(['success' => true]);
        }
        return $this->respondNotFound();
    }

    /**
     * Sync files with specific content
     *
     * @param int $contentId Content id
     *
     * @return mixed
     */
    public function syncFiles($contentId)
    {
        $block = $this->repository->getById($contentId);
        if (empty($block)) {
            return $this->respondNotFound();
        }
        $this->authorize('update', $block);
        $input = $this->validator->validate('syncFiles');
        $block = $this->fileRepository->syncWith($block, $this->buildSyncData($input));
        return $this->respondWithSuccess($block);
    }

    /**
     * It builds syncData
     *
     * @param array $input Validated input
     *
     * @return mixed
     */
    protected function buildSyncData(array $input)
    {
        $syncData = [];
        foreach ($input['data'] as $item) {
            $syncData[$item['id']] = ['weight' => isset($item['weight']) ? $item['weight'] : 0];
        }
        return $syncData;
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
 * @api                 {get} /admin/blocks/content/:contentId 2. GET blocks for specific content
 * @apiVersion          0.1.0
 * @apiName             GetBlocksForSpecificContent
 * @apiGroup            Block
 * @apiPermission       admin
 * @apiDescription      Get blocks for specific content
 * @apiUse              Meta
 * @apiUse              Params
 * @apiUse              BlockCollection
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/blocks/content/1
 */
/**
 * @api                 {get} /admin/blocks/:id 3. GET single entity
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
 * @api                 {post} /admin/blocks 4. POST newly created entity
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
 * @api                 {put} /admin/blocks 5. PUT the specified entity
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
 * @api                 {delete} /admin/blocks/:id?force=:forceDelete 6. DELETE the specified entity
 * @apiVersion          0.1.0
 * @apiName             DeleteBlock
 * @apiGroup            Block
 * @apiParam            (Content) {Number} id ID of the block.
 * @apiParam            (Content) {Boolean} forceDelete Idicates block should be permanently deleted or not.
 * @apiPermission       admin
 * @apiDescription      Delete the specified block from database
 * @apiSuccess {Boolean} success Success flag
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/api/v1/admin/blocks/21?force=true
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 * {"success":true}
 */
/**
 * @api                 {get} /admin/blocks/deleted 7. GET soft deleted blocks
 * @apiVersion          0.1.0
 * @apiName             GetDeletedBlocksList
 * @apiGroup            Block
 * @apiPermission       admin
 * @apiDescription      Get soft deleted blocks
 * @apiUse              Meta
 * @apiUse              Params
 * @apiUse              BlockCollection
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/blocks/content/1
 */
/**
 * @api                 {get} /admin/blocks/:id/files 8. GET block files
 * @apiVersion          0.1.0
 * @apiName             GetBlockFilesList
 * @apiGroup            Block
 * @apiPermission       admin
 * @apiDescription      Get list of files for specific block
 * @apiUse              Meta
 * @apiUse              Params
 * @apiUse              FileCollection
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/blocks/1/files
 */
/**
 * @api                 {get} /admin/contents/:id/files/sync 9. PUT associate files with block
 * @apiVersion          0.1.0
 * @apiName             SyncBlockFiles
 * @apiGroup            Block
 * @apiPermission       admin
 * @apiDescription      Sync files for specific block
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/blocks/1/files/sync
 */

/**
 * @apiDefine           Block
 * @apiSuccess {Number} id Block id
 * @apiSuccess {String} type Block type
 * @apiSuccess {String} region Block region
 * @apiSuccess {Array} filter Block visibility configuration in form of Tree node path for each content
 * @apiSuccess {Array} options Block unique parameters (Defined as array of key / value parameters)
 * @apiSuccess {String} theme Block theme
 * @apiSuccess {Number} weight Block weight
 * @apiSuccess {Boolean} isActive Is block active flag
 * @apiSuccess {Boolean} isCacheable Can block be cached flag
 * @apiSuccess {Date} createdAt Creation date
 * @apiSuccess {Date} updatedAt Update date
 * @apiSuccess {Object} author Author of this Block
 * @apiSuccess {Array} Translations List of active translations (Array of Objects)
 *
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 *{
 *   "id": 1,
 *   "type": "basic",
 *   "region": "header",
 *   "filter": {
 *       "+": [
 *          "1/2/*"
 *       ],
 *       "-": [
 *          "2"
 *       ]
 *   },
 *   "options": {
 *       "optionName": "optionValue",
 *       "anotherOptionName": "anotherOptionValue",
 *       "lastOptionName": "lastOptionValue"
 *   },
 *   "theme": null,
 *   "weight": 3,
 *   "isActive": false,
 *   "isCacheable": false,
 *   "createdAt": "2015-12-13 12:11:04",
 *   "updatedAt": "2015-12-13 12:11:04",
 *   "author": {
 *       "id": 1,
 *       "email": "admin@gzero.pl",
 *       "firstName": "John",
 *       "lastName": "Doe"
 *   },
 *   "translations": [
 *        {
 *            "id": 1,
 *            "langCode": "en",
 *            "title": "Example block title",
 *            "body": "Example block body",
 *            "isActive": true,
 *            "customFields": {
 *                "fieldName": "fieldValue",
 *                "anotherFieldName": "anotherFieldValue",
 *                "lastFieldName": "lastFieldValue"
 *            },
 *            "createdAt": "2015-12-13 12:11:04",
 *            "updatedAt": "2015-12-13 12:11:04"
 *       },
 *       {
 *           "id": 1,
 *           "langCode": "pl",
 *           "title": "Example block title",
 *           "body": "Example block body",
 *           "isActive": true,
 *              "customFields": {
 *                  "fieldName": "fieldValue",
 *                  "anotherFieldName": "anotherFieldValue",
 *                  "lastFieldName": "lastFieldValue"
 *           },
 *           "createdAt": "2015-12-13 12:11:04",
 *           "updatedAt": "2015-12-13 12:11:04"
 *       },
 *  ]
 *}
 */

/**
 * @apiDefine           BlockCollection
 * @apiSuccess {Array[]} data Array of Blocks
 * @apiSuccess {Number} data.id Block id
 * @apiSuccess {String} data.type Block type
 * @apiSuccess {String} data.region Block region
 * @apiSuccess {Array} data.filter Block visibility configuration in form of Tree node path for each content
 * @apiSuccess {Array} data.options Block unique parameters (Defined as array of key / value parameters)
 * @apiSuccess {String} data.theme Block theme
 * @apiSuccess {Number} data.weight Block weight
 * @apiSuccess {Boolean} data.isActive Is block active flag
 * @apiSuccess {Boolean} data.isCacheable Can block be cached flag
 * @apiSuccess {Date} data.createdAt Creation date
 * @apiSuccess {Date} data.updatedAt Update date
 * @apiSuccess {Object} data.author Author of this Block
 * @apiSuccess {Array} data.Translations List of active translations (Array of Objects)
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
