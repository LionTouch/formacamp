<?php

namespace App\Modules\Evaluations\Http\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationsModel extends Model
{
	/**
	 * Added just to demonstrate that models work
	 * @return String
	 */
	public function getAny()
	{
		return 'Dummy entry from EvaluationsModel';
	}
}