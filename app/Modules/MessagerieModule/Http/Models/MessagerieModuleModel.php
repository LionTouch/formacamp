<?php

namespace App\Modules\MessagerieModule\Http\Models;

use Illuminate\Database\Eloquent\Model;

class MessagerieModuleModel extends Model
{
	/**
	 * Added just to demonstrate that models work
	 * @return String
	 */
	public function getAny()
	{
		return 'Dummy entry from MessagerieModuleModel';
	}
}