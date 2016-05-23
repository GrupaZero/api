<?php
namespace api;

use Faker\Factory;
use Gzero\Entity\Block;
use Gzero\Entity\Content;
use Gzero\Entity\File;
use Gzero\Entity\FileType;
use Gzero\Repository\BlockRepository;
use Gzero\Repository\ContentRepository;
use Gzero\Repository\FileRepository;
use Gzero\Repository\UserRepository;
use Gzero\Entity\User;
use Illuminate\Events\Dispatcher;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(PHPMD)
 */
class FunctionalTester extends \Codeception\Actor {

    use _generated\FunctionalTesterActions;

    protected $baseUrl = 'http://localhost/';

    /**
     * files directory
     */
    protected $filesDir;

    /**
     * @var UserRepository
     */
    private $userRepo;

    /**
     * @var ContentRepository
     */
    private $blockRepo;

    /**
     * @var ContentRepository
     */
    private $contentRepo;

    /**
     * @var fileRepository
     */
    private $fileRepo;

    /**
     * @var \Faker\Generator
     */
    private $faker;

    public function __construct(\Codeception\Scenario $scenario)
    {
        $this->faker       = Factory::create();
        $this->filesDir    = __DIR__ . '/../resources';
        $this->contentRepo = new ContentRepository(new Content(), new Dispatcher());
        $this->blockRepo   = new BlockRepository(new Block(), new Dispatcher());
        $this->userRepo    = new UserRepository(new User(), new Dispatcher());
        $this->fileRepo    = new FileRepository(new File(), new FileType(), new Dispatcher());
        parent::__construct($scenario);
    }

    /**
     * Login in to page
     *
     * @param $email
     * @param $password
     */
    public function login($email, $password)
    {
        $I = $this;
        $I->amOnPage($this->baseUrl . 'en/login');
        $I->fillField('email', $email);
        $I->fillField('password', $password);
        $I->click('button[type=submit]');
        $I->amOnPage('/en');
        $I->seeAuthentication();
    }

    /**
     * Login as admin in to page
     */
    public function loginAsAdmin()
    {
        $I = $this;
        $I->amOnPage($this->baseUrl . 'en/login');
        $I->fillField('email', 'admin@gzero.pl');
        $I->fillField('password', 'test');
        $I->click('button[type=submit]');
        $I->seeAuthentication();
    }

    /**
     * Logout from page
     */
    public function logout()
    {
        $I = $this;
        $I->amOnPage($this->baseUrl . 'en/logout');
        $I->canSeeCurrentUrlEquals('/en');
        $I->dontSeeAuthentication();
    }

    /**
     * Create user and return entity
     *
     * @param array $attributes
     *
     * @return User
     */
    public function haveUser($attributes = [])
    {
        $fakeAttributes = [
            'nickName'  => $this->faker->userName,
            'firstName' => $this->faker->firstName,
            'lastName'  => $this->faker->lastName,
            'email'     => $this->faker->email
        ];

        $fakeAttributes = array_merge($fakeAttributes, $attributes);

        return $this->userRepo->create($fakeAttributes);
    }

    /**
     * Create block and return entity
     *
     * @param bool|false $attributes
     * @param null       $user
     *
     * @return Block
     */
    public function haveBlock($attributes = false, $user = null)
    {
        $fakeAttributes = [
            'type'         => ['basic', 'menu', 'slider', 'content'][rand(0, 3)],
            'region'       => ['header', 'sidebarLeft', 'sidebarRight', 'footer'][rand(0, 3)],
            'weight'       => rand(0, 10),
            'filter'       => ['+' => ['1/2/3']],
            'options'      => ['test' => 'value'],
            'isActive'     => true,
            'isCacheable'  => true,
            'publishedAt'  => date('Y-m-d H:i:s'),
            'translations' => [
                'langCode' => 'en',
                'title'    => 'Example block title',
                'body'     => 'Example block body'
            ]
        ];

        if (!empty($attributes)) {
            $fakeAttributes = array_merge($fakeAttributes, $attributes);
        }

        return $this->blockRepo->create($fakeAttributes, $user);
    }

    /**
     * Create content and return entity
     *
     * @param bool|false $attributes
     * @param null       $user
     *
     * @return Content
     */
    public function haveContent($attributes = false, $user = null)
    {
        $fakeAttributes = [
            'type'         => ['category', 'content'][rand(0, 1)],
            'isActive'     => 1,
            'publishedAt'  => date('Y-m-d H:i:s'),
            'translations' => [
                'langCode'       => 'en',
                'title'          => $this->faker->realText(38, 1),
                'teaser'         => '<p>' . $this->faker->realText(300) . '</p>',
                'body'           => $this->faker->realText(1000),
                'seoTitle'       => $this->faker->realText(60, 1),
                'seoDescription' => $this->faker->realText(160, 1),
                'isActive'       => rand(0, 1)
            ]
        ];

        if (!empty($attributes)) {
            $fakeAttributes = array_merge($fakeAttributes, $attributes);
        }

        return $this->contentRepo->create($fakeAttributes, $user);
    }

    /**
     * Create file and return entity
     *
     * @param bool|false $attributes
     * @param null       $user
     *
     * @return File
     */
    public function haveFile($attributes = false, $user = null)
    {
        $uploadedFile   = $this->getExampleFile();
        $fakeAttributes = [
            'type'         => 'image',
            'info'         => array_combine($this->faker->words(), $this->faker->words()),
            'isActive'     => 1,
            'createdBy'    => $user->id,
            'translations' => [
                'langCode'    => 'en',
                'title'       => $this->faker->realText(38, 1),
                'description' => $this->faker->realText(100),
            ]
        ];

        if (!empty($attributes)) {
            $fakeAttributes = array_merge($fakeAttributes, $attributes);
        }

        return $this->fileRepo->create($fakeAttributes, $uploadedFile, $user);
    }

    public function getExampleFile()
    {
        return new UploadedFile($this->filesDir . '/example.png', 'example.png', 'image/jpeg', null, null, true);
    }
}
