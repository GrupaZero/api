<?php
namespace api;

use Faker\Factory;
use Gzero\Entity\Block;
use Gzero\Repository\BlockRepository;
use Gzero\Repository\ContentRepository;
use Gzero\Repository\UserRepository;
use Gzero\Entity\User;
use Illuminate\Events\Dispatcher;

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
     * @var UserRepository
     */
    private $userRepo;

    /**
     * @var ContentRepository
     */
    private $blockRepo;

    /**
     * @var \Faker\Generator
     */
    private $faker;

    public function __construct(\Codeception\Scenario $scenario)
    {
        $this->faker        = Factory::create();
        $this->blockRepo = new BlockRepository(new Block(), new Dispatcher());
        $this->userRepo     = new UserRepository(new User(), new Dispatcher());
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

        if(!empty($attributes)){

            $fakeAttributes = array_merge($fakeAttributes, $attributes);
        }

        return $this->blockRepo->create($fakeAttributes, $user);
    }
}
