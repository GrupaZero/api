<?php namespace Gzero\Api\Transformer;

use Gzero\Entity\User;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class UserTransformer
 *
 * @package    Gzero\Api\Transformer
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class UserTransformer extends AbstractTransformer {

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'roles'
    ];

    /**
     * Transforms user entity
     *
     * @param User|array $user User entity
     *
     * @return array
     */
    public function transform($user)
    {
        $user = $this->entityToArray(User::class, $user);
        return [
            'id'        => (int) $user['id'],
            'email'     => $user['email'],
            'nick'      => $user['nick'],
            'firstName' => $user['first_name'],
            'lastName'  => $user['last_name'],
            'roles'     => !empty($user['roles']) ? $user['roles'] : []
        ];
    }

    /**
     * Include Roles
     *
     * @param User $user Translation
     *
     * @return \League\Fractal\ItemResource
     */
    public function includeRoles(User $user)
    {
        $roles = $user->roles;
        return $this->collection($roles, new RoleTransformer());
    }
}
