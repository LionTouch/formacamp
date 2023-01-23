<?php

namespace App\Modules\DashboardModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class DashboardModuleModel extends Model
{
	/**
	 * Added just to demonstrate that models work
	 * @return String
	 */
	public function getAny()
	{
		return 'Dummy entry from DashboardModuleModel';
	}
}