<?php namespace Gzero\Api\Controller\Admin;

use Gzero\Api\Controller\ApiController;
use Gzero\Api\Transformer\FileTransformer;
use Gzero\Api\UrlParamsProcessor;
use Gzero\Api\Validator\ContentFileValidator;
use Gzero\Entity\Content;
use Gzero\Repository\ContentRepository;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class ContentFileController
 *
 * @package    Gzero\Admin\Controllers\Resource
 */
class ContentFileController extends ApiController {

    /**
     * @var ContentRepository
     */
    protected $repository;

    /**
     * @var ContentFileValidator
     */
    protected $validator;

    /**
     * ContentFileController constructor
     *
     * @param UrlParamsProcessor   $processor Url processor
     * @param ContentRepository    $content   Content repository
     * @param ContentFileValidator $validator Content validator
     */
    public function __construct(
        UrlParamsProcessor $processor,
        ContentRepository $content,
        ContentFileValidator $validator
    ) {
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
    public function index($id)
    {
        $this->authorize('readList', Content::class);
        $input   = $this->validator->validate('list');
        $params  = $this->processor->process($input)->getProcessedFields();
        $content = $this->repository->getById($id);
        if (!empty($content)) {
            $results = $this->repository->getFiles(
                $content,
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
     * Attaches selected files to specified content entity in database.
     *
     * @param int $id Id of the content
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($id)
    {
        $content = $this->getContent($id);
        if (!empty($content)) {
            $this->authorize('create', $content);
            $this->authorize('update', $content);
            $input = $this->validator->validate('create');
            $files = $this->repository->addFiles($content, $input['filesIds']);
            return $this->respondWithSuccess($files, new FileTransformer);
        }
        return $this->respondNotFound();
    }

    /**
     * Updates the specified resource in database.
     *
     * @param int $id     Id of the content
     * @param int $fileId Id of the content file
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, $fileId)
    {
        $content = $this->getContent($id);
        if (!empty($content)) {
            $this->authorize('create', $content);
            $this->authorize('update', $content);
            $input = $this->validator->validate('update');
            $files = $this->repository->updateFile($content, $fileId, $input);
            return $this->respondWithSuccess($files, new FileTransformer);
        }
        return $this->respondNotFound();
    }

    /**
     * Detaches selected files to specified content entity in database.
     *
     * @param int $id Id of the content
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $content = $this->getContent($id);
        if (!empty($content)) {
            $this->authorize('delete', $content);
            $input = $this->validator->validate('delete');
            $this->repository->removeFiles($content, $input['filesIds']);
            return $this->respondWithSimpleSuccess(['success' => true]);
        }
        return $this->respondNotFound();
    }

    /**
     * Gets Content entity by id
     *
     * @param int $id content id
     *
     * @return \Gzero\Entity\Content
     */
    protected function getContent($id)
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
 * @api                 {get} /admin/contents/:id/files 1. GET collection of files
 * @apiVersion          0.1.0
 * @apiName             GetFileList
 * @apiGroup            Content Files
 * @apiPermission       admin
 * @apiParam {Number} id The Content ID
 * @apiDescription      Get collection of file for specified content entity
 * @apiUse              Meta
 * @apiUse              Params
 * @apiUse              ContentFileCollection
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/contents/1/files
 */
/**
 * @api                 {get} /admin/contents/:id/files/:id 2. GET single entity
 * @apiVersion          0.1.0
 * @apiName             GetContentFile
 * @apiGroup            Content Files
 * @apiPermission       admin
 * @apiParam {Number} id The Content ID
 * @apiParam {Number} fileId The ContentFiles ID
 * @apiDescription      Get the specified content file from database
 * @apiUse              ContentFile
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/contents/1/files/1
 */
/**
 * @api                 {post} /admin/contents/:id/files 3. POST Attaches selected files to specified content entity
 * @apiVersion          0.1.0
 * @apiName             PostContentFile
 * @apiGroup            Content Files
 * @apiPermission       admin
 * @apiParam {Number} id The Content ID
 * @apiDescription      Attaches selected files to specified content entity in database
 * @apiUse              ContentFile
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/api/v1/admin/contents/1/files
 */
/**
 * @api                 {put} /admin/contents/:id/files/:fileId 4. PUT the specified entity
 * @apiVersion          0.1.0
 * @apiName             PutContentFile
 * @apiGroup            Content Files
 * @apiPermission       admin
 * @apiParam {Number} id The Content ID
 * @apiParam {Number} fileId The ContentFiles ID
 * @apiDescription      Updates the specified resource in database.
 * @apiUse              ContentFile
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/api/v1/admin/contents/1/files/1
 */
/**
 * @api                 {delete} /admin/contents/:id/files/:fileId  5. DELETE Detaches selected files from specified content entity
 * @apiVersion          0.1.0
 * @apiName             DeleteContentFile
 * @apiGroup            Content Files
 * @apiPermission       admin
 * @apiParam {Number} id The Content ID
 * @apiDescription      Detaches selected files from specified content entity in database
 * @apiSuccess {Boolean} success Success flag
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/v1/admin/contents/1/files/1
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 * {"success":true}
 */

/**
 * @apiDefine           ContentFileCollection
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
 *        "link": "http://api.gzero.dev:8000/v1/admin/contents/1/files"
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
 * @apiDefine           ContentFile
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
