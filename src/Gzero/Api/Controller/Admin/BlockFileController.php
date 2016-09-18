<?php namespace Gzero\Api\Controller\Admin;

use Gzero\Api\Controller\ApiController;
use Gzero\Api\Transformer\FileTransformer;
use Gzero\Api\UrlParamsProcessor;
use Gzero\Api\Validator\BlockFileValidator;
use Gzero\Entity\Block;
use Gzero\Repository\BlockRepository;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class BlockFileController
 *
 * @package    Gzero\Admin\Controllers\Resource
 */
class BlockFileController extends ApiController {

    /**
     * @var BlockRepository
     */
    protected $repository;

    /**
     * @var BlockFileValidator
     */
    protected $validator;

    /**
     * BlockFileController constructor
     *
     * @param UrlParamsProcessor   $processor Url processor
     * @param BlockRepository    $block   Block repository
     * @param BlockFileValidator $validator Block validator
     */
    public function __construct(
        UrlParamsProcessor $processor,
        BlockRepository $block,
        BlockFileValidator $validator
    ) {
        parent::__construct($processor);
        $this->validator  = $validator->setData(\Input::all());
        $this->repository = $block;
    }

    /**
     * Display a listing of the resource.
     *
     * @param int|null $id Id used for nested resources
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $this->authorize('readList', Block::class);
        $input   = $this->validator->validate('list');
        $params  = $this->processor->process($input)->getProcessedFields();
        $block = $this->repository->getById($id);
        if (!empty($block)) {
            $results = $this->repository->getFiles(
                $block,
                $params['filter'],
                $params['orderBy'],
                $params['page'],
                $params['perPage']
            );
            return $this->respondWithSuccess($results, new FileTransformer);
        } else {
            return $this->respondNotFound();
        }
    }

    /**
     * Attaches selected files to specified block entity in database.
     *
     * @param int $id Id of the block
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($id)
    {
        $block = $this->getBlock($id);
        if (!empty($block)) {
            $this->authorize('create', $block);
            $this->authorize('update', $block);
            $input = $this->validator->validate('create');
            $files = $this->repository->addFiles($block, $input['filesIds']);
            return $this->respondWithSuccess($files, new FileTransformer);
        }
        return $this->respondNotFound();
    }

    /**
     * Updates the specified resource in database.
     *
     * @param int $id     Id of the block
     * @param int $fileId Id of the block file
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, $fileId)
    {
        $block = $this->getBlock($id);
        if (!empty($block)) {
            $this->authorize('create', $block);
            $this->authorize('update', $block);
            $input = $this->validator->validate('update');
            $files = $this->repository->updateFile($block, $fileId, $input);
            return $this->respondWithSuccess($files, new FileTransformer);
        }
        return $this->respondNotFound();
    }

    /**
     * Detaches selected files to specified block entity in database.
     *
     * @param int $id Id of the block
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $block = $this->getBlock($id);
        if (!empty($block)) {
            $this->authorize('delete', $block);
            $input = $this->validator->validate('delete');
            $this->repository->removeFiles($block, $input['filesIds']);
            return $this->respondWithSimpleSuccess(['success' => true]);
        }
        return $this->respondNotFound();
    }

    /**
     * Gets Block entity by id
     *
     * @param int $id block id
     *
     * @return \Gzero\Entity\Block
     */
    protected function getBlock($id)
    {
        return $this->repository->getById($id);
    }
}

/*
|--------------------------------------------------------------------------
| START API DOCS
|--------------------------------------------------------------------------
*/
/**
 * @api                 {get} /admin/blocks/:id/files 1. GET collection of files
 * @apiVersion          0.1.0
 * @apiName             GetFileList
 * @apiGroup            Block Files
 * @apiPermission       admin
 * @apiParam {Number} id The Block ID
 * @apiDescription      Get collection of file for specified block entity
 * @apiUse              Meta
 * @apiUse              Params
 * @apiUse              BlockFileCollection
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/blocks/1/files
 */
/**
 * @api                 {get} /admin/blocks/:id/files/:id 2. GET single entity
 * @apiVersion          0.1.0
 * @apiName             GetBlockFile
 * @apiGroup            Block Files
 * @apiPermission       admin
 * @apiParam {Number} id The Block ID
 * @apiParam {Number} fileId The BlockFiles ID
 * @apiDescription      Get the specified block file from database
 * @apiUse              BlockFile
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/blocks/1/files/1
 */
/**
 * @api                 {post} /admin/blocks/:id/files 3. POST Attaches selected files to specified block entity
 * @apiVersion          0.1.0
 * @apiName             PostBlockFile
 * @apiGroup            Block Files
 * @apiPermission       admin
 * @apiParam {Number} id The Block ID
 * @apiDescription      Attaches selected files to specified block entity in database
 * @apiUse              BlockFile
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/api/v1/admin/blocks/1/files
 */
/**
 * @api                 {put} /admin/blocks/:id/files/:fileId 4. PUT the specified entity
 * @apiVersion          0.1.0
 * @apiName             PutBlockFile
 * @apiGroup            Block Files
 * @apiPermission       admin
 * @apiParam {Number} id The Block ID
 * @apiParam {Number} fileId The BlockFiles ID
 * @apiDescription      Updates the specified resource in database.
 * @apiUse              BlockFile
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/api/v1/admin/blocks/1/files/1
 */
/**
 * @api                 {delete} /admin/blocks/:id/files/:fileId  5. DELETE Detaches selected files from specified block entity
 * @apiVersion          0.1.0
 * @apiName             DeleteBlockFile
 * @apiGroup            Block Files
 * @apiPermission       admin
 * @apiParam {Number} id The Block ID
 * @apiDescription      Detaches selected files from specified block entity in database
 * @apiSuccess {Boolean} success Success flag
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/blocks/1/files/1
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 * {"success":true}
 */

/**
 * @apiDefine           BlockFileCollection
 * @apiSuccess {Array[]} data Array of Files
 * @apiSuccess {Number} data.id File id
 * @apiSuccess {String} data.type File type
 * @apiSuccess {String} data.extension File extension
 * @apiSuccess {String} data.size File size
 * @apiSuccess {String} data.mimeType File mimeType
 * @apiSuccess {Array} data.info File unique parameters (Defined as array of key / value parameters)
 * @apiSuccess {String} data.url File url
 * @apiSuccess {Boolean} data.isActive Is file active flag
 * @apiSuccess {number} data.weight file weight
 * @apiSuccess {number} data.createdBy  User id of this File author
 * @apiSuccess {Date} data.createdAt Creation date
 * @apiSuccess {Date} data.updatedAt Update date
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
 *        "link": "http://api.gzero.dev:8000/v1/admin/blocks/1/files"
 *    },
 *    "params": {
 *        "page": 1,
 *        "perPage": 20,
 *        "filter": [],
 *        "orderBy": []
 *    },
 *    "data": [
 *        {File},
 *        ...
 *    ]
 *}
 */

/**
 * @apiDefine           BlockFile
 * @apiSuccess {Number} id File id
 * @apiSuccess {String} type File type
 * @apiSuccess {String} extension File extension
 * @apiSuccess {number} size File size
 * @apiSuccess {String} mimeType File mimeType
 * @apiSuccess {Array} info File unique parameters (Defined as array of key / value parameters)
 * @apiSuccess {String} url File url
 * @apiSuccess {Boolean} isActive Is file active flag
 * @apiSuccess {number} weight file weight
 * @apiSuccess {number} createdBy  User id of this File author
 * @apiSuccess {Date} createdAt Creation date
 * @apiSuccess {Date} updatedAt Update date
 * @apiSuccess {Array} Translations List of active translations (Array of Objects)
 *
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 *       {
 *           "id": 61,
 *           "type": "image",
 *           "name": "test",
 *           "extension": "jpg",
 *           "size": 1239876,
 *           "mimeType": "image/jpeg",
 *           "info": null,
 *           "url": "http://api.dev.gzero.pl:8000/uploads/images/test.jpg",
 *           "weight": null,
 *           "isActive": true,
 *           "createdBy": 1,
 *           "createdAt": "2016-05-27 17:37:01",
 *           "updatedAt": "2016-05-27 17:37:01",
 *           "translations": [
 *               {
 *                   "id": 64,
 *                   "langCode": "en",
 *                   "title": "test image",
 *                   "description": "",
 *                   "createdAt": "2016-05-27 17:37:01",
 *                   "updatedAt": "2016-05-27 17:37:01"
 *               }
 *           ]
 *       }
 *   ]
 *}
 */

/*
|--------------------------------------------------------------------------
| END API DOCS
|--------------------------------------------------------------------------
*/
