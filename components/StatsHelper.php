<?php

namespace panix\mod\stats\components;

use Yii;
use panix\engine\Html;
use panix\engine\components\Browser;
use yii\helpers\StringHelper;

class StatsHelper
{

    public $sdata;

    public function __construct()
    {
        $this->sdata = Yii::$app->request->get('s_date');
        //  $this->sdata = Yii::$app->request->get('s_date');
    }

    public static function getRowUserAgent($user_agent, $refer)
    {

        $browser = new Browser();
        $browser->setUserAgent($user_agent);
        $content = '';
        if (!self::is_robot($user_agent, $refer)) {
            $brw = self::getBrowser($user_agent);
            if ($brw != "")
                $content .= Html::img(Yii::$app->getModule('stats')->assetsUrl . '/images/browsers/' . $brw, [
                    //'title' => $user_agent,
                    'alt' => $user_agent,
                    'title' => Yii::t('stats/default', 'BROWSER', [
                        'name' => $browser->getBrowser(), //.' '.$user_agent,
                        'v' => $browser->getVersion()
                    ]),
                    'class' => 'img-thumbnail',
                    'data-toggle' => "tooltip",
                    'data-placement' => "top",
                ]);
        }
        $content .= self::getPlatformByImage($user_agent);
        $content .= self::getMobileByImage($user_agent);

        //$content.= $user_agent;
        return $content;
    }

    public static function getMobileByImage($user_agent)
    {

        $browser = new Browser();
        $browser->setUserAgent($user_agent);
        // return $browser->getPlatform();
        if ($browser->isMobile()) {
            $img = 'mobile.png';
            $name = 'Мобильное устройство';
        } elseif ($browser->isTablet()) {
            $name = 'Планшет';
            $img = 'tablet.png';
        } else {
            $name = $browser->getPlatform();
            $img = self::getPlatformByImage($user_agent, false);
        }
        return Html::img(Yii::$app->getModule('stats')->assetsUrl . '/images/platform/' . $img, [
            'data-toggle' => "tooltip",
            'data-placement' => "top",
            'class' => 'img-thumbnail',
            'title' => $name,
            'alt' => $name
        ]);
    }

    public static function getPlatformByImage($user_agent, $render = true)
    {

        $browser = new Browser();
        $browser->setUserAgent($user_agent);
        // return $browser->getPlatform();
        if ($browser->isRobot()) {
            return Html::img(Yii::$app->getModule('stats')->assetsUrl . '/images/platform/robot.png', [
                'data-toggle' => "tooltip",
                'data-placement' => "top",
                'title' => 'Робот',
                'class' => 'img-thumbnail',
                'alt' => $browser->getPlatform(),
            ]);
        }


        switch ($browser->getPlatform()) {
            case Browser::PLATFORM_ANDROID:
                $img = "android.png";
                break;
            case Browser::PLATFORM_WINDOWS:
                $img = "windows.png";
                break;
            case Browser::PLATFORM_WINDOWS_7:
                $img = "windows.png";
                break;
            case Browser::PLATFORM_WINDOWS_8:
                $img = "windows_8.png";
                break;
            case Browser::PLATFORM_WINDOWS_10:
                $img = "windows_8.png";
                break;
            case Browser::PLATFORM_FREEBSD:
                $img = "freebsd.png";
                break;
            case Browser::PLATFORM_LINUX:
                $img = "linux.png";
                break;
            case Browser::PLATFORM_IPHONE:
                $img = "apple.png";
                break;
            case Browser::PLATFORM_APPLE:
                $img = "apple.png";
                break;
            case Browser::PLATFORM_IPAD:
                $img = "apple.png";
                break;
            default :
                return $browser->getPlatform();
                break;
        }
        if ($render) {

            return Html::img(Yii::$app->getModule('stats')->assetsUrl . '/images/platform/' . $img, [
                'data-toggle' => "tooltip",
                'data-placement' => "top",
                'class' => 'platform img-thumbnail',
                'alt' => $browser->getPlatform(),
                'title' => Yii::t('stats/default', 'PLATFORM', ['name' => $browser->getPlatform()])
            ]);
        } else {
            return $img;
        }
    }

    public static function linkDetail($link)
    {
        return Html::a(Yii::t('stats/default', 'DETAIL'), $link, ['target' => '_blank', 'class' => 'btn btn-sm btn-info']);
    }

    public static function getRowHost($ip, $proxy, $host, $lang)
    {
        $content = '';
        $p = ($lang) ? self::$LANG[mb_strtoupper($lang)] : '';
        if ($ip == "") {
            $content .= '<span class="text-muted">неизвестно</span>';
        } else {
            $content .= "<a target=_blank href=\"http://www.tcpiputils.com/browse/ip-address/" . (($ip != "") ? $ip : $host) . "\">" . $host . "</a>";
        }
        if ($host != "") {
            $content .= "<br>Язык: " . (!empty($p) ? $p : "<span style='color:grey'>неизвестно</span>");
            if (file_exists(Yii::getAlias('@webroot/uploads/language') . DIRECTORY_SEPARATOR . mb_strtolower($lang) . ".png")) {
                $content .= Html::img('/uploads/language/' . mb_strtolower($lang) . '.png', ['alt' => $p]);
            }
        }
        return $content;
    }

    public function browserName($brw)
    {
        switch ($brw) {
            case "ie.png":
                $name = "MS Internet Explorer";
                break;
            case "opera.png":
                $name = "Opera";
                break;
            case "firefox.png":
                $name = "Firefox";
                break;
            case "chrome.png":
                $name = "Google Chrome";
                break;
            case "mozilla.png":
                $name = "Mozilla";
                break;
            case "safari.png":
                $name = "Apple Safari";
                break;
            case "mac.png":
                $name = "Macintosh";
                break;
            case "maxthon.png":
                $name = "Maxthon (MyIE)";
                break;
            default:
                $name = "другие";
                break;
        }
        if (!empty($brw)) {
            //$img = Html::img(Yii::getAlias('@stats/assets') . '/images/browsers/' . $brw);//, $name
            $img = Html::img(Yii::$app->getModule('stats')->assetsUrl . '/images/browsers/' . $brw, ['alt' => $name]);
        } else {
            $img = '';
        }

        $content = Html::a($img . ' ' . $name, "/admin/stats/browsers/detail?s_date=&f_date=&qs=" . $brw . "&sort=" . (empty($this->sort) ? "ho" : $this->sort), array('target' => '_blank'));


        // $content = Html::a($img . ' ' . $name, "/admin/stats/browsers/detail?s_date=" . $this->sdate . "&f_date=" . $this->fdate . "&qs=" . $brw . "&sort=" . (empty($this->sort) ? "ho" : $this->sort), array('target' => '_blank'));
        return $content;
    }

    public static function getRowIp($refer, $ip)
    {

        if ($refer != "unknown") {
            //return CMS::ip($refer,1);
        }
        if ($ip != "")
            return "<br><a target=_blank href=\"?item=ip&qs=" . $ip . "\">через proxy</a>";

        $content = '';
        if ($refer != "unknown")
            $content .= Html::a($refer,['dd'])."<a target=_blank href=\"?item=ip&qs=" . $refer . "\">" . $refer . "</a>";
        else
            $content .= '<span class="text-muted">неизвестно</span>';
        if ($ip != "")
            $content .= Html::a($refer,['dd1'])."<br><a target=_blank href=\"?item=ip&qs=" . $ip . "\">через proxy</a>";

        return $content;
    }

    public static function checkSearchEngine($refer, $engine, $query)
    {
        $content = '';
        if ($engine == "G" and !empty($query) and stristr($refer, "/url?"))
            $refer = str_replace("/url?", "/search?", $refer);
        $content .= Yii::$app->controller->echo_se($engine);
        if (empty($query))
            $query = '<span class="text-muted">неизвестно</span>';
        $content .= ": <a target=_blank href=\"" . $refer . "\">" . $query . "</a>";
        return $content;
    }

    public static function renderReferrer($ref)
    {
        $text = '';
        $refer = self::Ref($ref);
        if (is_array($refer)) {
            list($engine, $query) = $refer;
            if ($engine == "G" and !empty($query) and stristr($ref, "/url?"))
                $ref = str_replace("/url?", "/search?", $ref);
            $text .= Yii::$app->controller->echo_se($engine);
            if (empty($query))
                $query = '<span class="text-muted">неизвестно</span>';
            $text .= ': <a target="_blank" href="' . $ref . '">' . $query . '</a>';
        } else if ($refer == "")
            $text .= '<span class="text-muted">неизвестно</span>';
        else {
            $text .= '<a target="_blank" href="' . $ref . '">';
            if (stristr(urldecode($ref), "xn--")) {
                $IDN = new \idna_convert(['idn_version' => 2008]);
                $text .= $IDN->decode(urldecode($ref));
            } else
                $text .= urldecode($ref);
            $text .= "</a>";
        }
        return $text;
    }

    public static function timeLink($array, $key)
    {
        $tu = "";
        foreach ($array[$key] as $rw) {
            $tu .= $rw[0] . " <a target=_blank href=" . $rw[1] . ">" . StringHelper::truncate($rw[1], 20) . "</a><br>";
        }
        return $tu;
    }

    public static function checkIdna($ref)
    {

        $content = '';
        if ($ref == "")
            $content .= "<span style='color:grey'>неизвестно</span>";
        else {
            $content .= "<a target=_blank href=\"" . $ref . "\">";
            if (stristr(urldecode($ref), "xn--")) {
                $IDN = new \idna_convert(['idn_version' => 2008]);
                $content .= $IDN->decode(urldecode($ref));
            } else
                $content .= urldecode($ref);
            $content .= "</a>";
        }

        return $content;
    }

    public static $MONTH = [
        "12" => "Декабрь",
        "11" => "Ноябрь",
        "10" => "Октябрь",
        "09" => "Сентябрь",
        "08" => "Август",
        "07" => "Июль",
        "06" => "Июнь",
        "05" => "Май",
        "04" => "Апрель",
        "03" => "Март",
        "02" => "Февраль",
        "01" => "Январь"
    ];
    public static $DAY = [
        "Mon" => "ПН: ",
        "Tue" => "ВТ: ",
        "Wed" => "СР: ",
        "Thu" => "ЧТ: ",
        "Fri" => "ПТ: ",
        "Sat" => "<span style='color:#de3163'>СБ:</span> ",
        "Sun" => "<span style='color:#de3163'>ВС:</span> "
    ];
    public static $LANG = [// ISO 639
        "AA" => "Afar",
        "AB" => "Abkhazian",
        "AE" => "Avestan",
        "AF" => "Afrikaans",
        "AK" => "Akan",
        "AM" => "Amharic",
        "AN" => "Aragonese",
        "AR" => "Arabic",
        "AS" => "Assamese",
        "AV" => "Avaric",
        "AY" => "Aymara",
        "AZ" => "Azerbaijani",
        "BA" => "Bashkir",
        "BE" => "Byelorussian",
        "BG" => "Bulgarian",
        "BH" => "Bihari",
        "BI" => "Bislama",
        "BM" => "Bambara",
        "BN" => "Bengali",
        "BO" => "Tibetan",
        "BR" => "Breton",
        "BS" => "Bosnian",
        "CA" => "Catalan",
        "CE" => "Chechen",
        "CH" => "Chamorro",
        "CO" => "Corsican",
        "CR" => "Cree",
        "CS" => "Czech",
        "CU" => "Old Church Slavonic",
        "CV" => "Chuvash",
        "CY" => "Welsh",
        "DA" => "Danish",
        "DE" => "German",
        "DV" => "Divehi",
        "DZ" => "Bhutani",
        "EE" => "Ewe",
        "EL" => "Greek",
        "EN" => "English",
        "EO" => "Esperanto",
        "ES" => "Spanish",
        "ET" => "Estonian",
        "EU" => "Basque",
        "FA" => "Persian",
        "FF" => "Fula",
        "FI" => "Finnish",
        "FJ" => "Fiji",
        "FO" => "Faeroese",
        "FR" => "French",
        "FY" => "Frisian",
        "GA" => "Irish",
        "GD" => "Gaelic",
        "GL" => "Galician",
        "GN" => "Guarani",
        "GU" => "Gujarati",
        "GV" => "Manx",
        "HA" => "Hausa",
        "HE" => "Hebrew",
        "HI" => "Hindi",
        "HO" => "Hiri Motu",
        "HR" => "Croatian",
        "HT" => "Haitian",
        "HU" => "Hungarian",
        "HY" => "Armenian",
        "HZ" => "Herero",
        "IA" => "Interlingua",
        "ID" => "Indonesian",
        "IE" => "Interlingue",
        "IG" => "Igbo",
        "II" => "Nuosu",
        "IK" => "Inupiak",
        "IN" => "Indonesian",
        "IO" => "Ido",
        "IS" => "Icelandic",
        "IT" => "Italian",
        "IU" => "Inuktitut",
        "IW" => "Hebrew",
        "JA" => "Japanese",
        "JV" => "Javanese",
        "JI" => "Yiddish",
        "JW" => "Javanese",
        "KA" => "Georgian",
        "KG" => "Kongo",
        "KI" => "Kikuyu",
        "KJ" => "Kwanyama",
        "KK" => "Kazakh",
        "KZ" => "Kazakh",
        "KL" => "Greenlandic",
        "KM" => "Cambodian",
        "KN" => "Kannada",
        "KO" => "Korean",
        "KR" => "Kanuri",
        "KS" => "Kashmiri",
        "KU" => "Kurdish",
        "KV" => "Komi",
        "KW" => "Cornish",
        "KY" => "Kirghiz",
        "LA" => "Latin",
        "LB" => "Luxembourgish",
        "LG" => "Ganda",
        "LI" => "Limburgish",
        "LN" => "Lingala",
        "LO" => "Laothian",
        "LT" => "Lithuanian",
        "LU" => "Luba-Katanga",
        "LV" => "Latvian",
        "MG" => "Malagasy",
        "MH" => "Marshallese",
        "MI" => "Maori",
        "MK" => "Macedonian",
        "ML" => "Malayalam",
        "MN" => "Mongolian",
        "MO" => "Moldavian",
        "MR" => "Marathi",
        "MS" => "Malay",
        "MT" => "Maltese",
        "MY" => "Burmese",
        "NA" => "Nauru",
        "NB" => "Norwegian Bokmal",
        "ND" => "North Ndebele",
        "NE" => "Nepali",
        "NG" => "Ndonga",
        "NL" => "Dutch",
        "NN" => "Norwegian Nynorsk",
        "NO" => "Norwegian",
        "NR" => "South Ndebele",
        "NV" => "Navajo",
        "NY" => "Chichewa",
        "OC" => "Occitan",
        "OJ" => "Ojibwe",
        "OM" => "Oromo",
        "OR" => "Oriya",
        "OS" => "Ossetian",
        "PA" => "Punjabi",
        "PI" => "Pali",
        "PL" => "Polish",
        "PS" => "Pashto",
        "PT" => "Portuguese",
        "QU" => "Quechua",
        "RM" => "Rhaeto-Romance",
        "RN" => "Kirundi",
        "RO" => "Romanian",
        "RU" => "Russian",
        "RW" => "Kinyarwanda",
        "SA" => "Sanskrit",
        "SC" => "Sardinian",
        "SD" => "Sindhi",
        "SE" => "Northern Sami",
        "SG" => "Sangro",
        "SH" => "Serbo-Croatian",
        "SI" => "Singhalese",
        "SK" => "Slovak",
        "SL" => "Slovenian",
        "SM" => "Samoan",
        "SN" => "Shona",
        "SO" => "Somali",
        "SQ" => "Albanian",
        "SR" => "Serbian",
        "SS" => "Siswati",
        "ST" => "Sesotho",
        "SU" => "Sudanese",
        "SV" => "Swedish",
        "SW" => "Swahili",
        "TA" => "Tamil",
        "TE" => "Tegulu",
        "TG" => "Tajik",
        "TH" => "Thai",
        "TI" => "Tigrinya",
        "TK" => "Turkmen",
        "TL" => "Tagalog",
        "TN" => "Setswana",
        "TO" => "Tonga",
        "TR" => "Turkish",
        "TS" => "Tsonga",
        "TT" => "Tatar",
        "TW" => "Twi",
        "TY" => "Tahitian",
        "UG" => "Uighur",
        "UK" => "Ukrainian",
        "UR" => "Urdu",
        "UZ" => "Uzbek",
        "VE" => "Venda",
        "VI" => "Vietnamese",
        "VO" => "Volapuk",
        "WA" => "Walloon",
        "WO" => "Wolof",
        "XH" => "Xhosa",
        "YI" => "Yiddish",
        "YO" => "Yoruba",
        "ZA" => "Zhuang",
        "ZH" => "Chinese",
        "ZU" => "Zulu"
    ];

    public static function getBrowser($UA)
    {
        if (stristr($UA, "Maxthon") or stristr($UA, "Myie"))
            return "maxthon.png";
        if (stristr($UA, "Opera") or stristr($UA, "OPR/"))
            return "opera.png";
        if (stristr($UA, "MSIE") or stristr($UA, "Trident"))
            return "ie.png";
        if (stristr($UA, "Firefox"))
            return "firefox.png";
        if (stristr($UA, "Chrome") or stristr($UA, "Android"))
            //if (stristr($UA, "Chrome"))
            return "chrome.png";
        if (stristr($UA, "Safari"))
            return "safari.png";
        if (stristr($UA, "Mac"))
            return "mac.png";
        if (stristr($UA, "Mozilla"))
            return "mozilla.png";
        else
            return "";
    }

    public static function get_encoding($str)
    {
        $cp_list = ['utf-8', 'cp1251'];
        foreach ($cp_list as $k => $codepage) {
            if (md5($str) === md5(iconv($codepage, $codepage, $str))) {
                return $codepage;
            }
        }
        return null;
    }

    public static function se_google($ref)
    {
        $sw = "q=";
        $sw2 = "as_q=";
        $engine = "G";
        $url = urldecode($ref);
        $url = str_replace("aq=", "bb=", $url);
        if (stristr($url, "e=KOI8-R"))
            $url = convert_cyr_string($url, "k", "w");
        $url = stripslashes($url);
        $url = strip_tags($url);
        if (self::get_encoding($url) == "cp1251")
            $url = iconv("CP1251", "UTF-8", $url);
        preg_match("/[?&]+" . $sw . "([^&]*)/i", $url . "&", $match1);
        if (stristr($match1[1], "%"))
            $match1[1] = urldecode($match1[1]);
        $match1[1] = trim($match1[1]);
        preg_match("/[?&]+" . $sw2 . "([^&]*)/i", $url . "&", $match2);
        $match2[1] = trim($match2[1]);
        if ($match2[1] == $match1[1])
            return [$engine, $match1[1]];
        if (!empty($match2[1]))
            return [$engine, ($match2[1] . " + " . $match1[1])];
        else
            return [$engine, $match1[1]];
    }

    public static function GetBrw($brw)
    {
        switch ($brw) {
            case "maxthon.png":
                return "AND (LOWER(user) LIKE '%maxthon%' OR LOWER(user) LIKE '%myie%')";
                break;
            case "opera.png":
                return "AND (LOWER(user) LIKE '%opera%' OR LOWER(user) LIKE '%opr/%')";
                break;
            case "ie.png":
                return "AND LOWER(user) NOT LIKE '%maxthon%' AND LOWER(user) NOT LIKE '%myie%' AND LOWER(user) NOT LIKE '%opera%' AND (LOWER(user) LIKE '%msie%' OR LOWER(user) LIKE '%trident%')";
                break;
            case "firefox.png":
                return "AND LOWER(user) NOT LIKE '%maxthon%' AND LOWER(user) NOT LIKE '%myie%' AND LOWER(user) NOT LIKE '%msie%' AND LOWER(user) NOT LIKE '%opera%' AND LOWER(user) LIKE '%firefox%'";
                break;
            case "chrome.png":
                return "AND LOWER(user) NOT LIKE '%maxthon%' AND LOWER(user) NOT LIKE '%myie%' AND LOWER(user) NOT LIKE '%msie%' AND LOWER(user) NOT LIKE '%opera%' AND LOWER(user) NOT LIKE '%opr/%' AND LOWER(user) NOT LIKE '%firefox%' AND (LOWER(user) LIKE '%chrome%' OR LOWER(user) LIKE '%android%')";
                break;
            case "safari.png":
                return "AND LOWER(user) NOT LIKE '%maxthon%' AND LOWER(user) NOT LIKE '%myie%' AND LOWER(user) NOT LIKE '%msie%' AND LOWER(user) NOT LIKE '%opera%' AND LOWER(user) NOT LIKE '%firefox%' AND LOWER(user) NOT LIKE '%chrome%' AND LOWER(user) NOT LIKE '%android%' AND LOWER(user) LIKE '%safari%'";
                break;
            case "mac.png":
                return "AND LOWER(user) NOT LIKE '%maxthon%' AND LOWER(user) NOT LIKE '%myie%' AND LOWER(user) NOT LIKE '%msie%' AND LOWER(user) NOT LIKE '%opera%' AND LOWER(user) NOT LIKE '%firefox%' AND LOWER(user) NOT LIKE '%chrome%' AND LOWER(user) NOT LIKE '%safari%' AND LOWER(user) LIKE '%mac%'";
                break;
            case "mozilla.png":
                return "AND LOWER(user) NOT LIKE '%maxthon%' AND LOWER(user) NOT LIKE '%myie%' AND LOWER(user) NOT LIKE '%msie%' AND LOWER(user) NOT LIKE '%opera%' AND LOWER(user) NOT LIKE '%firefox%' AND LOWER(user) NOT LIKE '%chrome%' AND LOWER(user) NOT LIKE '%safari%' AND LOWER(user) NOT LIKE '%trident%' AND LOWER(user) NOT LIKE '%mac%' AND LOWER(user) LIKE '%mozilla%'";
                break;
            default:
                return "AND LOWER(user) NOT LIKE '%maxthon%' AND LOWER(user) NOT LIKE '%myie%' AND LOWER(user) NOT LIKE '%msie%' AND LOWER(user) NOT LIKE '%trident%' AND LOWER(user) NOT LIKE '%opera%' AND LOWER(user) NOT LIKE '%opr/%' AND LOWER(user) NOT LIKE '%android%' AND LOWER(user) NOT LIKE '%firefox%' AND LOWER(user) NOT LIKE '%chrome%' AND LOWER(user) NOT LIKE '%safari%' AND LOWER(user) NOT LIKE '%mac%' AND LOWER(user) NOT LIKE '%mozilla%'";
                break;
        }
    }

    /**
     * @param $brw
     * @param \yii\db\Query $query
     * @return array|string
     */
    public static function __GetBrwNew($brw, \yii\db\Query $query)
    {
        $queries = [];
        switch ($brw) {
            case "maxthon.png":
                $query->andWhere(['like', 'LOWER(user)', 'maxthon']);
                $query->orWhere(['like', 'LOWER(user)', 'myie']);
                return $query;
                // return "AND (LOWER(user) LIKE '%maxthon%' OR LOWER(user) LIKE '%myie%')";
                break;
            case "opera.png":
                $queries[] = ['like', 'LOWER(user)', 'opera'];
                $queries[] = ['like', 'LOWER(user)', 'myie'];
                return "AND (LOWER(user) LIKE '%opera%' OR LOWER(user) LIKE '%opr/%')";
                break;
            case "ie.png":
                return "AND LOWER(user) NOT LIKE '%maxthon%' AND LOWER(user) NOT LIKE '%myie%' AND LOWER(user) NOT LIKE '%opera%' AND (LOWER(user) LIKE '%msie%' OR LOWER(user) LIKE '%trident%')";
                break;
            case "firefox.png":
                $query->andWhere(['not like', 'LOWER(user)', ['maxthon', 'myie', 'msie', 'opera']]);
                $query->andWhere(['like', 'LOWER(user)', 'firefox']);

                // $queries[] = ['not like', 'LOWER(user)', ['maxthon', 'myie', 'msie', 'opera']];
                //  $queries[] = ['like', 'LOWER(user)', 'firefox'];
                return $query;


                //   return "AND LOWER(user) NOT LIKE '%maxthon%' AND LOWER(user) NOT LIKE '%myie%' AND LOWER(user) NOT LIKE '%msie%' AND LOWER(user) NOT LIKE '%opera%' AND LOWER(user) LIKE '%firefox%'";
                break;
            case "chrome.png":
                $query->andWhere(['not like', 'LOWER(user)', ['maxthon', 'myie', 'msie', 'opera', 'opr/', 'firefox']]);
                $query->orWhere(['like', 'LOWER(user)', 'chrome']);
                $query->orWhere(['like', 'LOWER(user)', 'android']);
                return $query;

                //$queries[] = ['not like', 'LOWER(user)', ['maxthon', 'myie', 'msie', 'opera', 'opr/', 'firefox']];
                //$queries[] = ['like', 'LOWER(user)', ['chrome', 'android']];
                //return $queries;
                // return "AND LOWER(user) NOT LIKE '%maxthon%' AND LOWER(user) NOT LIKE '%myie%' AND LOWER(user) NOT LIKE '%msie%' AND LOWER(user) NOT LIKE '%opera%' AND LOWER(user) NOT LIKE '%opr/%' AND LOWER(user) NOT LIKE '%firefox%' AND (LOWER(user) LIKE '%chrome%' OR LOWER(user) LIKE '%android%')";
                break;
            case "safari.png":
                return "AND LOWER(user) NOT LIKE '%maxthon%' AND LOWER(user) NOT LIKE '%myie%' AND LOWER(user) NOT LIKE '%msie%' AND LOWER(user) NOT LIKE '%opera%' AND LOWER(user) NOT LIKE '%firefox%' AND LOWER(user) NOT LIKE '%chrome%' AND LOWER(user) NOT LIKE '%android%' AND LOWER(user) LIKE '%safari%'";
                break;
            case "mac.png":
                return "AND LOWER(user) NOT LIKE '%maxthon%' AND LOWER(user) NOT LIKE '%myie%' AND LOWER(user) NOT LIKE '%msie%' AND LOWER(user) NOT LIKE '%opera%' AND LOWER(user) NOT LIKE '%firefox%' AND LOWER(user) NOT LIKE '%chrome%' AND LOWER(user) NOT LIKE '%safari%' AND LOWER(user) LIKE '%mac%'";
                break;
            case "mozilla.png":
                return "AND LOWER(user) NOT LIKE '%maxthon%' AND LOWER(user) NOT LIKE '%myie%' AND LOWER(user) NOT LIKE '%msie%' AND LOWER(user) NOT LIKE '%opera%' AND LOWER(user) NOT LIKE '%firefox%' AND LOWER(user) NOT LIKE '%chrome%' AND LOWER(user) NOT LIKE '%safari%' AND LOWER(user) NOT LIKE '%trident%' AND LOWER(user) NOT LIKE '%mac%' AND LOWER(user) LIKE '%mozilla%'";
                break;
            default:
                return "AND LOWER(user) NOT LIKE '%maxthon%' AND LOWER(user) NOT LIKE '%myie%' AND LOWER(user) NOT LIKE '%msie%' AND LOWER(user) NOT LIKE '%trident%' AND LOWER(user) NOT LIKE '%opera%' AND LOWER(user) NOT LIKE '%opr/%' AND LOWER(user) NOT LIKE '%android%' AND LOWER(user) NOT LIKE '%firefox%' AND LOWER(user) NOT LIKE '%chrome%' AND LOWER(user) NOT LIKE '%safari%' AND LOWER(user) NOT LIKE '%mac%' AND LOWER(user) NOT LIKE '%mozilla%'";
                break;
        }
    }

    public static function echo_se($engine)
    {
        switch ($engine) {
            case "Y":
                return "<b><span style='color:#FF0000;'>Я</span>ndex</b>";
                break;
            case "R":
                return "<b><span style='color:#0000FF'>R</span>ambler</b>";
                break;
            case "G":
                return "<b><span style='color:#2159D6'>G</span><span style='color:#C61800'>o</span><span style='color:#D6AE00'>o</span><span style='color:#2159D6'>g</span><span style='color:#18A221'>l</span><span style='color:#C61800'>e</span></b>";
                break;
            case "M":
                return "<b><span style='color:#F8AC32'>@</span><span style='color:#00468c'>mail</span><span style='color:#F8AC32'>.ru</span></b>";
                break;
            case "H":
                return "<b>Yahoo</b>";
                break;
            case "S":
                return "<b>MSN Bing</b>";
                break;
            case "?":
                return "<b>?</b>";
                break;
            default :
                foreach ($se_n as $key => $val)
                    if (stristr(strip_tags($key), strip_tags($engine))) {
                        return "<b>" . $key . "</b>";
                        break;
                    }
                break;
        }
    }

    public static function se_mail1($ref)
    {
        $sw = "words=";
        $engine = "M";
        $url = urldecode($ref);
        $url = stripslashes($url);
        $url = strip_tags($url);
        if (self::get_encoding($url) == "cp1251")
            $url = iconv("CP1251", "UTF-8", $url);
        preg_match("/[?&]+" . $sw . "([^&]*)/i", $url . "&", $match1);
        $match1[1] = trim($match1[1]);
        return [$engine, $match1[1]];
    }

    public static function se_mail2($ref)
    {
        $sw = "q=";
        $sw2 = "as_q=";
        $engine = "M";
        $url = urldecode($ref);
        $url = stripslashes($url);
        $url = strip_tags($url);
        if (self::get_encoding($url) == "cp1251")
            $url = iconv("CP1251", "UTF-8", $url);
        preg_match("/[?&]+" . $sw . "([^&]*)/i", $url . "&", $match1);
        $match1[1] = trim($match1[1]);
        preg_match("/[?&]+" . $sw2 . "([^&]*)/i", $url . "&", $match2);
        $match2[1] = trim($match2[1]);
        if ($match2[1] == $match1[1])
            return [$engine, $match1[1]];
        if (!empty($match2[1]))
            return [$engine, ($match2[1] . " + " . $match1[1])];
        else
            return [$engine, $match1[1]];
    }

    public static function se_rambler($ref)
    {
        $sw = "words=";
        $sw1 = "query=";
        $sw2 = "old_q=";
        $engine = "R";
        $url = urldecode($ref);
        if (stristr($url, "btnG=оБКФЙ!"))
            $url = convert_cyr_string($url, "k", "w");
        $url = stripslashes($url);
        $url = strip_tags($url);
        if (self::get_encoding($url) == "cp1251")
            $url = iconv("CP1251", "UTF-8", $url);
        preg_match("/[?&]+" . $sw . "([^&]*)/i", $url . "&", $match1);
        if (empty($match1))
            preg_match("/[?&]+" . $sw1 . "([^&]*)/iu", $url . "&", $match1);
        $match1[1] = trim($match1[1]);
        if (stristr($url, "infound=1")) {
            preg_match("/[?&]+" . $sw2 . "([^&]*)/i", $url . "&", $match2);
            return [$engine, ($match2[1] . " + " . $match1[1])];
        } else
            return [$engine, $match1[1]];
    }

    public static function se_yahoo($ref)
    {
        $sw = "p=";
        $engine = "H";
        $url = urldecode($ref);
        $url = stripslashes($url);
        $url = strip_tags($url);
        if (self::get_encoding($url) == "cp1251")
            $url = iconv("CP1251", "UTF-8", $url);
        preg_match("/[?&]+" . $sw . "([^&]*)/i", $url . "&", $match1);
        $match1[1] = trim($match1[1]);
        return [$engine, $match1[1]];
    }

    public static function se_msn($ref)
    {
        $sw = "q=";
        $engine = "S";
        $url = urldecode($ref);
        $url = stripslashes($url);
        $url = strip_tags($url);
        if (self::get_encoding($url) == "cp1251")
            $url = iconv("CP1251", "UTF-8", $url);
        preg_match("/[?&]+" . $sw . "([^&]*)/i", $url . "&", $match1);
        $match1[1] = trim($match1[1]);
        return [$engine, $match1[1]];
    }

    public static function is_robot($check, $check2)
    {
        $app = Yii::$app->stats;
        $rbd = $app->rbd;
        $hbd = $app->hbd;

        if (empty($check))
            return TRUE;
        if (isset($rbd))
            foreach ($rbd as $val)
                if (stristr($check, $val))
                    return TRUE;
        if (isset($hbd))
            foreach ($hbd as $val)
                if (stristr($check2, $val))
                    return TRUE;
        return FALSE;
    }

    public static function se_other($ref, $sw)
    {
        $engine = "?";
        $url = urldecode($ref);
        $url = stripslashes($url);
        $url = strip_tags($url);
        if (self::get_encoding($url) == "cp1251")
            $url = iconv("CP1251", "UTF-8", $url);
        preg_match("/[?&]+" . $sw . "([^&]*)/i", $url . "&", $match1);
        $match1[1] = trim($match1[1]);
        return [$engine, $match1[1]];
    }

    public static function se_sp($ref)
    {
        $app = Yii::$app->stats->se_n;
        $se_nn = [];
        foreach ($app['se_n'] as $key => $val) {
            if (isset($se_nn[$key])) {
                if (stristr($ref, $se_nn[$key])) {
                    $engine = $key;
                    $sw = $val;
                    $url = urldecode($ref);
                    $url = stripslashes($url);
                    $url = strip_tags($url);
                    if (self::get_encoding($url) == "cp1251")
                        $url = iconv("CP1251", "UTF-8", $url);
                    preg_match("/[?&]+" . $sw . "([^&]*)/i", $url . "&", $match1);
                    $match1[1] = trim($match1[1]);
                    return [$engine, $match1[1]];
                }
            }
        }
        return -1;
    }

    public static function utf8RawUrlDecode($source)
    {
        $decodedStr = '';
        $pos = 0;
        $len = strlen($source);
        while ($pos < $len) {
            $charAt = substr($source, $pos, 1);
            if ($charAt == '%') {
                $pos++;
                $charAt = substr($source, $pos, 1);
                if ($charAt == 'u') {
                    $pos++;
                    $unicodeHexVal = substr($source, $pos, 4);
                    $unicode = hexdec($unicodeHexVal);
                    $entity = "&#" . $unicode . ';';
                    $decodedStr .= utf8_encode($entity);
                    $pos += 4;
                } else {
                    $hexVal = substr($source, $pos, 2);
                    $decodedStr .= chr(hexdec($hexVal));
                    $pos += 2;
                }
            } else {
                $decodedStr .= $charAt;
                $pos++;
            }
        }
        return $decodedStr;
    }

    public static function se_yandex($ref)
    {
        $sw = "text=";
        $sw2 = "holdreq=";
        $engine = "Y";
        $rw = 0;
        if (stristr($ref, "yandpage")) {
            if (stristr($ref, "text%3D%25u")) {
                $rw = 1;
                if (stristr($ref, "holdreq%3D%25u"))
                    $rw = 2;
            }
        }
        $url = urldecode($ref);
        if (stristr($url, "Є") or stristr($url, "є") or stristr($url, "Ў") or stristr($url, "ў")) {
            $url = iconv("UTF-8", "CP866", $url);
            $url = iconv("CP1251", "UTF-8", $url);
        } else {
            if (substr_count(iconv("CP1251", "UTF-8", $url), "Р") > 2)
                ;
            else
                $url = iconv("CP1251", "UTF-8", $url);
            $url = stripslashes($url);
            $url = strip_tags($url);
            if (substr_count($url, "Г") > 2) {
                $url = iconv("UTF-8", "CP1251", $url);
                $url = iconv("UTF-8", "CP1252", $url);
                $url = iconv("CP1251", "UTF-8", $url);
            }
            if (substr_count($url, "Р") > 2)
                $url = iconv("UTF-8", "CP1251", $url);
            if (stristr($url, "°") or stristr($url, "Ѓ") or stristr($url, "„") or stristr($url, "‡") or stristr($url, "Ќ"))
                $url = iconv("UTF-8", "CP1251", $url);
        }
        preg_match("/[?&]+" . $sw . "([^&]*)/i", $url . "&", $match1);
        preg_match("/[?&]+" . $sw2 . "([^&]*)/i", $url . "&", $match2);
        if (isset($match2[1]) == isset($match1[1]))
            return [$engine, $match1[1]];
        if (!empty($match2[1]))
            return [$engine, ($match2[1] . " + " . $match1[1])];
        else
            return [$engine, $match1[1]];
    }

    public static function Ref($ref)
    {
        $site = Yii::$app->stats->getSite();
        if (($ref != "") and !(stristr($ref, "://" . $site) and stripos($ref, "://" . $site, 6) == 0) and !(stristr($ref, "://www." . $site) and stripos($ref, "://www." . $site, 6) == 0)) {

            $reff = str_replace("www.", "", $ref);
            if (!stristr($ref, "://")) {
                $reff = "://" . $reff;
                $ref = "://" . $ref;
            }
            if (stristr($reff, "://yandex") or stristr($reff, "://search.yaca.yandex") or stristr($reff, "://images.yandex"))
                return self::se_yandex($ref);
            else if (stristr($reff, "://google"))
                return self::se_google($ref);
            else if (stristr($reff, "://rambler") or stristr($reff, "://nova.rambler") or stristr($reff, "://search.rambler") or stristr($reff, "://ie4.rambler") or stristr($reff, "://ie5.rambler"))
                return self::se_rambler($ref);
            else if (stristr($reff, "://go.mail.ru") and stristr($reff, "words="))
                return self::se_mail1($ref);
            else if (stristr($reff, "://go.mail.ru") or stristr($reff, "://wap.go.mail.ru"))
                return self::se_mail2($ref);
            else if (stristr($reff, "://search.msn") or stristr($reff, "://search.live.com") or stristr($reff, "://ie.search.msn") or stristr($reff, "://bing"))
                return self::se_msn($ref);
            else if (stristr($reff, "://search.yahoo"))
                return self::se_yahoo($ref);
            else if (self::se_sp($ref) <> -1)
                return self::se_sp($ref);
            else if (stristr($ref, "?q=") or stristr($ref, "&q="))
                return self::se_other($ref, "q=");
            else if (stristr($ref, "query="))
                return self::se_other($ref, "query=");
            else
                return $ref;
        } else
            return $ref;
    }

}
