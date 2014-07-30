<?

defined("WERUA") or die('<div style="margin:0 0 auto;width:200px">Ошибка запуска. Contact </div>');

class wra_time {

    public static $beginyear = 1950;
    public static $endyear = 2015;

    static function getmonthnp($i) {
        $ar = wra_time::getmonthesnp("");
        return $ar[$i];
    }

    static function getmonthesnp($lang) {

        $result = array("1" => "январь",
            "2" => "февраль",
            "3" => "март",
            "4" => "апрель",
            "5" => "май",
            "6" => "июнь",
            "7" => "июль",
            "8" => "август",
            "9" => "сентябрь",
            "10" => "октябрь",
            "11" => "ноябрь",
            "12" => "декабрь"
        );


        return $result;
    }

    static function getmonthesrp($lang) {

        $result = array("1" => "января",
            "2" => "февраля",
            "3" => "марта",
            "4" => "апреля",
            "5" => "мая",
            "6" => "июня",
            "7" => "июля",
            "8" => "августа",
            "9" => "сентября",
            "10" => "октября",
            "11" => "ноября",
            "12" => "декабря"
        );


        return $result;
    }

}

?>