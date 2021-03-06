<?php

namespace App\Modules\Sales\Http\Requests\Team;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StoreRequest
 * @package App\Modules\Sales\Http\Requests\SalesTeam
 */
class CreateRequest extends FormRequest {

	/**
	 * Determine if the user is authorized to make this request
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'first_name'       => [
				'required',
				'min:2',
				'max:50',
				'alpha_space',
				Rule::unique(TABLE_BACKOFFICE_SALES_TEAM)->where(function ( $query ) {
					$request = request();

					$whereArray = [
						['last_name', '=', $request->get('last_name')],
						['city_name', '=', $request->get('city_name')],
						['parent_member_id', '=', $request->get('parent_member_id')]
					];

					/* @var Builder $query */
					$query->where($whereArray);
				})
			],
			'last_name'        => 'required|min:2|max:50|alpha_space',
			'city_name'        => 'required|min:3|max:50|alpha_space',
			'is_left'          => 'sometimes|bool',
			'parent_member_id' => 'sometimes|numeric'
		];
	}

	/**
	 * Pass custom error message
	 *
	 * @return array
	 */
	public function messages() {
		return ['first_name.unique' => trans("sales::team.common.error.unique")];
	}
}
