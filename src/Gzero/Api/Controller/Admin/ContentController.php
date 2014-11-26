<?php namespace Gzero\Api\Controller\Admin;

use Gzero\Api\Controller\ApiController;
use Gzero\Api\Transformer\ContentTransformer;
use Gzero\Api\UrlParamsProcessor;
use Gzero\Entity\Content;
use Gzero\Entity\ContentTranslation;
use Gzero\Repository\ContentRepository;

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

    protected $contentRepository;

    /**
     * ContentController constructor
     *
     * @param UrlParamsProcessor $processor Url processor
     * @param ContentRepository  $content   Content repository
     */
    public function __construct(UrlParamsProcessor $processor, ContentRepository $content)
    {
        parent::__construct($processor);
        $this->contentRepository = $content;
    }


    /**
     * Display a listing of the resource.
     *
     * @param int|null $id Id used for nested resources
     *
     * @api                 {get} /admin/contents Read collection of root contents
     * @apiVersion          0.1.0
     * @apiName             GetContentList
     * @apiGroup            Content
     * @apiDescription      Read root contents
     * @apiSuccess {Integer} count Number of all langs
     * @apiSuccess {Array} data Collection of contents (Array of Objects)
     * @apiExample          Example usage:
     * curl -i http://api.example.com/v1/admin/contents
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id = null)
    {
        $orderBy = $this->processor->getOrderByParams();
        $filters = $this->processor->getFilterParams();
        $page    = $this->processor->getPage();
        $perPage = $this->processor->getPerPage();
        if ($id) { // content/id/children
            $content = $this->contentRepository->getById($id);
            if (!empty($content)) {
                $results = $this->contentRepository->getChildren($content, $filters, $orderBy, $page, $perPage);
                return $this->respondWithSuccess($results, new ContentTransformer);
            } else {
                return $this->respondNotFound();
            }
        }
        $results = $this->contentRepository->getRootContents($filters, $orderBy, $page, $perPage);
        return $this->respondWithSuccess($results, new ContentTransformer);
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
     * Stores newly created content in database
     *
     * @api        {post} /contents Stores newly created content i DB
     * @apiVersion 0.1.0
     * @apiName    PostContentList
     * @apiGroup   AdminContent
     * @apiExample Example usage:
     * curl -i http://localhost/api/v1/admin/contents
     * @apiSuccess {Array} data Success and input data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $input = \Input::all();
        $type  = \Doctrine::find('Gzero\Entity\ContentType', 'category');
        if (empty($type)) {
            return $this->respondWithError('Content type does not exist');
        }

        $content = new Content($type);
        $content->setActive(true);

        $lang = \Doctrine::find('Gzero\Entity\Lang', $input['lang']['code']);
        if (empty($lang)) {
            return $this->respondWithError('Language does not exist');
        }

        $translation = new ContentTranslation($content, $lang);
        $translation->setUrl($input['title']);
        $translation->setTitle($input['title']);
        $translation->setActive(true);
        $content->addTranslation($translation);
        \Doctrine::persist($content);
        \Doctrine::flush();

        return $this->respondWithSuccess(
            [
                'success' => true,
                'input'   => $input
            ],
            new ContentTransformer
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id Content id
     *
     * @return Response
     * @SuppressWarnings("unused")
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id Content id
     *
     * @return Response
     * @SuppressWarnings("unused")
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id Content id
     *
     * @return Response
     * @SuppressWarnings("unused")
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
