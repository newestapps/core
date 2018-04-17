<?php
/**
 * Created by rodrigobrun
 *   with PhpStorm
 */

namespace Newestapps\Core\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

abstract class CoreBaseRepository extends BaseRepository
{

    /**
     * Validation rules for this repository
     *
     * @return array
     */
    abstract function getRules();

    public function validator()
    {
        $this->rules = $this->getRules();

        return parent::validator();
    }


}