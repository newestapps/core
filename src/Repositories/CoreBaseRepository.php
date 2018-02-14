<?php
/**
 * Created by rodrigobrun
 *   with PhpStorm
 */

namespace Newestapps\Core\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

abstract class CoreBaseRepository extends BaseRepository
{

    abstract function getRules();

    public function validator()
    {
        $this->rules = $this->getRules();

        return parent::validator();
    }


}