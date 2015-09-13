<?php namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Poster;

/**
 * 广告仓库
 * Created by maxfine<max_fine@qq.com>.
 * Date: 2015/9/12
 * Time: 22:41
 */

class PosterRepository extends BaseRepository
{
    public function __construct(Poster $poster){
        $this->model = $poster;
    }
}