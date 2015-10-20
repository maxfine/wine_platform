<?php namespace App\Repositories;

use App\Models\UserGroup;

/**
 * 用户组仓库UserGroupRepository
 *
 * @author maxfine<max_fine@qq.com>
 */
class UserGroupRepository extends BaseRepository
{
    public function __construct(UserGroup $userGroup)
    {
        $this->model = $userGroup;
    }
}
