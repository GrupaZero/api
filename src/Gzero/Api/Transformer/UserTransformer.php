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
     * Transforms user entity
     *
     * @param User|Array $user User entity
     *
     * @throws \Exception Test
     * @return array
     */
    public function transform($user)
    {
        $user = $this->entityToArray('\Gzero\Entity\User', $user);
        return [
            'id'        => (int) $user['id'],
            'email'     => $user['email'],
            'firstName' => $user['firstName'],
            'lastName'  => $user['lastName']
        ];
    }
}