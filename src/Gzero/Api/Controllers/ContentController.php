<?php namespace Gzero\Api\Controllers;

use Gzero\Api\UrlParamsProcessor;
use Gzero\Repositories\Content\ContentRepository;

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

    protected
        $processor,
        $contentRepo;

    public function __construct(ContentRepository $content, UrlParamsProcessor $processor)
    {
        $this->contentRepo = $content;
        $this->processor   = $processor;
    }

    /**
     * @api            {get} /contents/:id/children Get content list of children
     * @apiVersion     0.1.0
     * @apiName        GetContentChildrenList
     * @apiGroup       Content
     * @apiDescription Because the contents are stored using a tree structure. We have to pull out a list for the specific node
     * @apiExample     Example usage:
     * curl -i http://localhost/api/v1/contents/1/children
     * @apiParam {Number} id Content unique ID.
     * @apiSuccess {Array} data List of contents (Array of Objects)
     * @apiSuccess {Number} total Total count of all elements
     */

    /**
     * Display a listing of the resource.
     *
     * @api        {get} /contents Get content list
     * @apiVersion 0.1.0
     * @apiName    GetContentList
     * @apiGroup   Content
     * @apiExample Example usage:
     * curl -i http://localhost/api/v1/contents
     * @apiSuccess {Array} data List of contents (Array of Objects)
     *
     * @param null $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id = NULL)
    {
        $orderBy = $this->processor->getOrderByParams();
        if ($id) { // content/n/children
            $content = $this->contentRepo->getById($id);
            $page    = $this->processor->getPage();
            if (!empty($content)) {
                return
                    $this->respondWithSuccess(
                        [
                            'data'  => $this->contentRepo->getChildren($content, $page, $orderBy)->toArray(),
                            'total' => $this->contentRepo->getLastTotal()
                        ]
                    );
            } else {
                return $this->respondNotFound();
            }
        }
        return $this->respondWithSuccess(
            [
                'data' => $this->contentRepo->getCategoriesTree($orderBy)->toArray(),
            ]
        );
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
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     * Display a listing of the resource.
     *
     * @api                 {get} /contents/:id Get single content
     * @apiVersion          0.1.0
     * @apiName             GetContent
     * @apiGroup            Content
     * @apiDescription      Using this function, you can get a single content
     * @apiExample          Example usage:
     * curl -i http://localhost/api/v1/contents/123
     * @apiParam {Number} id Content unique ID.
     * @apiSuccessStructure Content
     *
     */
    public function show($id)
    {
        $content = $this->contentRepo->getById($id);
        if ($content) {
            $this->contentRepo->loadThumb($content);
            return $this->respondWithSuccess($content->toArray());
        }
        return $this->respondNotFound();
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
