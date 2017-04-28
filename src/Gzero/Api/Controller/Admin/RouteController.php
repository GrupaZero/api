<?php namespace Gzero\Api\Controller\Admin;

use Gzero\Api\Controller\ApiController;
use Gzero\Api\Transformer\RouteTransformer;
use Gzero\Api\UrlParamsProcessor;
use Gzero\Api\Validator\RouteTranslationValidator;
use Gzero\Repository\ContentRepository;
use Gzero\Repository\RepositoryValidationException;
use Illuminate\Http\Request;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class RouteController
 *
 * @package    Gzero\Api\Controller\Admin
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2015, Adrian Skierniewski
 */
class RouteController extends ApiController {

    /**
     * @var ContentRepository
     */
    protected $repository;

    /**
     * @var ContentValidator
     */
    protected $validator;

    /**
     * RouteController constructor.
     *
     * @param UrlParamsProcessor        $processor Url processor
     * @param ContentRepository         $content   Content repository
     * @param RouteTranslationValidator $validator Route translation validator
     * @param Request                   $request   Request object
     */
    public function __construct(
        UrlParamsProcessor $processor,
        ContentRepository $content,
        RouteTranslationValidator $validator,
        Request $request
    ) {
        parent::__construct($processor);
        $this->validator  = $validator->setData($request->all());
        $this->repository = $content;
    }

    /**
     * Stores newly created route for specified content entity in database.
     *
     * @param int $contentId Id of the content
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws RepositoryValidationException
     */
    public function store($contentId)
    {
        $content = $this->repository->getById($contentId);
        if (!empty($content)) {
            $this->authorize('create', $content);
            $this->authorize('update', $content);
            if ($content->type != 'category') {
                $input = $this->validator->validate('create');
                $route = $this->repository->createRoute($content, $input['lang_code'], $input['url']);
                return $this->respondWithSuccess($route, new RouteTransformer);
            } else {
                // TODO categories children route update
                throw new RepositoryValidationException("You can't change category url", 500);
            }
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
 * @api                 {post} /admin/contents/:id/route 1. POST newly created route
 * @apiVersion          0.1.0
 * @apiName             PostRoute
 * @apiGroup            Content Route
 * @apiPermission       admin
 * @apiParam {Number} id The Content ID
 * @apiDescription      Stores newly created route for specified content entity in database.
 * @apiUse              ContentRoute
 *
 * @apiExample          Example usage:
 * curl -i http://api.example.com/api/v1/admin/contents/1/route
 */


/**
 * @apiDefine           ContentRoute
 * @apiSuccess {Number} id Route id
 * @apiSuccess {Date} createdAt Creation date of route
 * @apiSuccess {Date} updatedAt Update date of route
 * @apiSuccess {Array} translations List of active translations (Array of Objects)
 *
 * @apiSuccessExample   Success-Response:
 * HTTP/1.1 200 OK
 *{
 *   "id": 1,
 *   "createdAt": "2015-12-13 12:11:04",
 *   "updatedAt": "2015-12-13 12:11:04",
 *   "translations": [
 *      {
 *          "id": 45,
 *          "lang": "en",
 *          "url": "about-us",
 *          "isActive": 1,
 *          "createdAt": "2015-12-13 12:11:04",
 *          "updatedAt": "2015-12-13 12:11:04"
 *      },
 *      {
 *          "id": 46,
 *          "lang": "pl",
 *          "url": "o-nas",
 *          "isActive": 1,
 *          "createdAt": "2015-12-13 12:11:04",
 *          "updatedAt": "2015-12-13 12:11:04"
 *      }
 *   ]
 *}
 *
 */
/*
|--------------------------------------------------------------------------
| END API DOCS
|--------------------------------------------------------------------------
*/
