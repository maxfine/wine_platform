<?php namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Theme;

/**
 * 主题仓库
 * Created by maxfine<max_fine@qq.com>.
 * Date: 2015/9/12
 * Time: 22:41
 */

class ThemeRepository extends BaseRepository
{
    public function __construct(Theme $theme)
    {
        $this->model = $theme;
    }

}