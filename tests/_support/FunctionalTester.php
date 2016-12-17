<?php
namespace Api;

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

    protected $token;

    public function __construct(\Codeception\Scenario $scenario)
    {
        $this->faker       = Factory::create();
        $this->filesDir    = __DIR__ . '/../resources';
        $this->userRepo    = new UserRepository(new User(), new Dispatcher());
        $this->fileRepo    = new FileRepository(new File(), new FileType(), new Dispatcher());
        $this->blockRepo   = new BlockRepository(new Block(), new Dispatcher(), $this->fileRepo);
        $this->contentRepo = new ContentRepository(new Content(), new Dispatcher(), $this->fileRepo);
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
        $I->amLoggedAs(['email' => $email, 'password' => $password], 'web');
        $I->seeAuthentication();
    }

    /**
     * Login with token and set Authorization header
     *
     * @param $email
     */
    public function loginWithToken($email)
    {
        $I    = $this;
        $user = User::where('email', $email)->first();
        $I->assertInstanceOf(User::class, $user);
        $I->amBearerAuthenticated($user->createToken('Test')->accessToken);
    }

    /**
     * Login as admin in to page
     */
    public function loginAsAdmin()
    {
        $this->loginWithToken('admin@gzero.pl');
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
            'nick'       => $this->faker->userName,
            'first_name' => $this->faker->firstName,
            'last_name'  => $this->faker->lastName,
            'password'   => 'test',
            'email'      => $this->faker->email
        ];

        $fakeAttributes = array_merge(array_snake_case_keys($fakeAttributes), $attributes);

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
            'is_active'    => true,
            'is_cacheable' => true,
            'published_at' => date('Y-m-d H:i:s'),
            'translations' => [
                'lang_code' => 'en',
                'title'     => 'Example block title',
                'body'      => 'Example block body'
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
            'is_active'    => 1,
            'published_at' => date('Y-m-d H:i:s'),
            'translations' => [
                'lang_code'       => 'en',
                'title'           => $this->faker->realText(38, 1),
                'teaser'          => '<p>' . $this->faker->realText(300) . '</p>',
                'body'            => $this->faker->realText(1000),
                'seo_title'       => $this->faker->realText(60, 1),
                'seo_description' => $this->faker->realText(160, 1),
                'is_active'       => rand(0, 1)
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
            'is_active'    => 1,
            'created_by'   => $user->id,
            'translations' => [
                'lang_code'   => 'en',
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
        return new UploadedFile($this->filesDir . '/example.png', 'example.png', 'image/jpeg', 5148, null, true);
    }
}
