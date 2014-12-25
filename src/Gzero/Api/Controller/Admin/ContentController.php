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
     * ContentController constructor
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
     * @api                 {get} /admin/contents Read collection of root contents
     * @apiVersion          0.1.0
     * @apiName             GetContentList
     * @apiGroup            AdminContent
     * @apiDescription      Read root contents
     * @apiSuccess {Integer} count Number of all contents
     * @apiSuccess {Array} data Collection of contents (Array of Objects)
     * @apiExample          Example usage:
     * curl -i http://api.example.com/v1/admin/contents
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
     * Display a specified resource.
     *
     * @param int $id Id of the resource
     *
     * @api                 {get} /admin/contents/{id} Get the specified content from database
     * @apiVersion          0.1.0
     * @apiName             GetContent
     * @apiGroup            AdminContent
     * @apiDescription      Get the specified content from database
     * @apiSuccess {Array} selected content(Array of Objects)
     * @apiExample          Example usage:
     * curl -i http://api.example.com/v1/admin/contents/123
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
     * @api                 {post} /contents Stores newly created content in database
     * @apiVersion          0.1.0
     * @apiName             PostContent
     * @apiGroup            AdminContent
     * @apiDescription      Stores newly created content in database
     * @apiSuccess {Array} data Success and input data
     * @apiExample          Example usage:
     * curl -i http://api.example.com/api/v1/admin/contents
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
     * Update the specified resource in database.
     *
     * @param int $id Content id
     *
     * @api                 {put} /contents Updates the specified content in database
     * @apiVersion          0.1.0
     * @apiName             PutContent
     * @apiGroup            AdminContent
     * @apiDescription      Updates the specified content in database
     * @apiSuccess {Array} data Success and input data
     * @apiExample          Example usage:
     * curl -i http://api.example.com/api/v1/admin/contents
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
     * @api                 {delete} /contents Removes the specified content from database
     * @apiVersion          0.1.0
     * @apiName             DeleteContent
     * @apiGroup            AdminContent
     * @apiDescription      Updates the specified content from database
     * @apiSuccess {Array} data Success and input data
     * @apiExample          Example usage:
     * curl -i http://api.example.com/api/v1/admin/contents
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

/**
 * @apiDefineSuccessStructure Content
 * @apiSuccess {Number} id Content id
 * @apiSuccess {Number} rating Content rating
 * @apiSuccess {Number} visits Content visit counter
 * @apiSuccess {Object[]} translations List of translations (Array of Objects)
 * @apiSuccess {Number} translations.lang_id Language id
 * @apiSuccess {String} translations.url Translation url
 * @apiSuccess {String} translations.title Title
 * @apiSuccess {String} translations.body Body
 * @apiSuccess {String} translations.seo_title SEO title
 * @apiSuccess {String} translations.seo_description SEO description
 * @apiSuccess {Boolean} translations.is_active Is translation active
 * @apiSuccess {Date} translations.created_at Creation date of translation
 * @apiSuccess {Date} translations.updated_at Update date of translation
 * @apiSuccess {Boolean} is_on_home Home page flag
 * @apiSuccess {Boolean} is_comment_allowed Is comment allowed flag
 * @apiSuccess {Boolean} is_promoted Is promoted flag
 * @apiSuccess {Boolean} is_sticky Is sticky flag
 * @apiSuccess {Boolean} is_active Is content active flag
 * @apiSuccess {Date} published_at Date of publication
 * @apiSuccess {Date} created_at Creation date
 * @apiSuccess {Date} updated_at Update date
 */
