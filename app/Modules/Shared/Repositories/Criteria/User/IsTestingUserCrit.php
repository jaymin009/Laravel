<?php

namespace App\Modules\Shared\Repositories\Criteria\User;

use Flinnt\Repository\Criteria\AbstractCriteria;
use Flinnt\Repository\Contracts\RepositoryInterface;
use Flinnt\Repository\Eloquent\BaseRepository;

/**
 * Class UserIsTestingUserCrit
 * @package namespace App\Modules\Shared\Repositories\Criteria;
 */
class IsTestingUserCrit extends AbstractCriteria {

	/**
	 * Apply criteria in query repository
	 *
	 * @param BaseRepository      $model
	 * @param RepositoryInterface $repository
	 *
	 * @return mixed
	 */
	public function apply( $model, RepositoryInterface $repository ) {
		$model = $model->whereNotIn($this->getAttributeName(TABLE_USERS, "user_id"), [TESTING_USERS]);

		return $model;
	}
}
