<?defined('WERUA') or include('../bad.php');
class wra_u {
	static function islogin() {
		if (wra_fbu::isfbd()) {
			return 'fb';
		}
		if (wra_vku::isvkd()) {
			return 'vk';
		}
		return false;
	}

	static function logedUser() {
		// wra_vku::getbd()
		$soc_type = self::islogin();
	
		switch ($soc_type) {
			case 'vk':
				WRA::debug(wra_vku::getbd());
				$lepeople = new wra_vku();
				$lepeople->loadbyvk(wra_vku::getbd());
				return $lepeople;
				break;
			case 'fb':
				
				$lepeople = new wra_fbu();
				$lepeople->loadbyfb(wra_fbu::getbd());
				return $lepeople;
				break;			
			default:
				return false;
				break;
		}
	}

	static function get_user($id, $soc_type) {
		WRA::debug($soc_type);
		switch ($soc_type) {
			case 'vk':
				// WRA::debug(wra_vku::getbd());
				$lepeople = new wra_vku();
				$lepeople->loadbyvk($id);
				return $lepeople;
				break;
			case 'fb':
				// WRA::debug(wra_fbu::getbd());
				$lepeople = new wra_fbu();
				$lepeople->loadbyfb($id);
				return $lepeople;
				break;			
			default:
				return false;
				break;
		}
	}
}