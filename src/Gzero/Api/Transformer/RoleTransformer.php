<?php namespace Gzero\Api\Transformer;

use Gzero\Entity\Role;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class RoleTransformer
 *
 * @package    Gzero\Api\Transformer
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class RoleTransformer extends AbstractTransformer {

    /**
     * Transforms role entity
     *
     * @param Role|array $role Role entity
     *
     * @return array
     */
    public function transform($role)
    {
        $role = $this->entityToArray(Role::class, $role);
        return [
            'id'        => (int) $role['id'],
            'name'      => $role['name'],
            'createdAt' => $role['createdAt'],
            'updatedAt' => $role['updatedAt']
        ];
    }
}
