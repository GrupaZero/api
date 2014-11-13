<?php namespace Gzero\Api\Controller;

use Gzero\Entity\Content;
use Gzero\Entity\ContentTranslation;
use Gzero\Entity\ContentType;
use Gzero\Entity\Lang;
use Gzero\Repository\ContentRepository;
use Gzero\Api\UrlParamsProcessor;
use Gzero\Core\EntitySerializer;

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

    protected $processor;

    protected $contentRepo;

    protected $entitySerializer;

    /**
     * ContentController constructor
     *
     * @param ContentRepository  $content          Content repo
     * @param UrlParamsProcessor $processor        Url processor
     * @param EntitySerializer   $entitySerializer Entity serializer
     */
    public function __construct(ContentRepository $content, UrlParamsProcessor $processor, EntitySerializer $entitySerializer)
    {
        $this->contentRepo      = $content;
        $this->processor        = $processor;
        $this->entitySerializer = $entitySerializer;
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
     * @param int|null $id Content id
     *
     * @api        {get} /contents Get content list
     * @apiVersion 0.1.0
     * @apiName    GetContentList
     * @apiGroup   Content
     * @apiExample Example usage:
     * curl -i http://localhost/api/v1/contents
     * @apiSuccess {Array} data List of contents (Array of Objects)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id = null)
    {
        // $page    = $this->processor->getPage();
        $orderBy = $this->processor->getOrderByParams();
        if ($id) { // content/n/children
            $content = $this->contentRepo->getById($id);
            if (!empty($content)) {
                return
                    $this->respondWithSuccess(
                        [
                            'data' => $this->contentRepo->getChildren($content, [], $orderBy),
                            // 'total' => $this->contentRepo->getLastTotal()
                        ]
                    );
            } else {
                return $this->respondNotFound();
            }
        }

        return $this->respondWithSuccess(
            [
                'data' => $this->contentRepo->getRootContents($orderBy),
                // 'total' => $this->contentRepo->getLastTotal()
            ]
        );
    }

    /**
     * Stores newly created content in database
     *
     * @api        {post} /contents Stores newly created content i DB
     * @apiVersion 0.1.0
     * @apiName    PostContentList
     * @apiGroup   Content
     * @apiExample Example usage:
     * curl -i http://localhost/api/v1/contents
     * @apiSuccess {Array} data Success and input data
     *
     *  @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        /* @TODO
         * First ugly version of creation, need to be moved to ContentRepository
         */
        $input   = \Input::all();
        $type    = \Doctrine::find('Gzero\Entity\ContentType', 'category');
        if(empty($type))
            return $this->respondWithInternalError('Content type does not exist');

        $content = new Content($type);
        $content->setActive(true);

        $lang        = \Doctrine::find('Gzero\Entity\Lang', $input['lang']['code']);
        if(empty($lang))
            return $this->respondWithInternalError('Language does not exist');

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
            ]
        );
    }


    /**
     * Display the specified resource.
     *
     * @param int $id Content id
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
     * @return Response
     */
    public function show($id)
    {
        $content = $this->contentRepo->getById($id);
        if (empty($content)) {
            return $this->respondNotFound();
        }

        return $this->respondWithSuccess(
            [
                'data' => $this->entitySerializer->toArray($content)
            ]
        );
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
