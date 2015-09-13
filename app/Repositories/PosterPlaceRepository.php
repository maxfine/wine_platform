<?php namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\PosterPlace;

/**
 * 广告位仓库
 * Created by maxfine<max_fine@qq.com>.
 * Date: 2015/9/12
 * Time: 22:41
 */

class PosterPlaceRepository extends BaseRepository
{
    public function __construct(PosterPlace $posterPlace)
    {
        $this->model = $posterPlace;
    }
}