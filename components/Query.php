<?php

namespace panix\mod\stats\components;

use yii\db\Query as BaseQuery;

class Query extends BaseQuery
{


    public function browser($brw)
    {
        switch ($brw) {
            case "maxthon.png":
                $this->andWhere(['like', 'LOWER(user)', 'maxthon']);
                $this->orWhere(['like', 'LOWER(user)', 'myie']);
                return $this;
                break;
            case "opera.png":
                $this->andWhere(['like', 'LOWER(user)', 'opera']);
                $this->orWhere(['like', 'LOWER(user)', 'opr/']);
                return $this;
                break;
            case "ie.png":
                $this->andWhere(['not like', 'LOWER(user)', ['maxthon', 'myie', 'opera', 'opera']]);
                $this->andWhere(['like', 'LOWER(user)', 'msie']);
                $this->orWhere(['like', 'LOWER(user)', 'trident']);
                return $this;
                break;
            case "firefox.png":
                $this->andWhere(['not like', 'LOWER(user)', ['maxthon', 'myie', 'msie', 'opera']]);
                $this->andWhere(['like', 'LOWER(user)', 'firefox']);
                return $this;
                break;
            case "chrome.png":
                $this->andWhere(['not like', 'LOWER(user)', ['maxthon', 'myie', 'msie', 'opera', 'opr/', 'firefox']]);
                $this->andWhere(['like', 'LOWER(user)', 'chrome']);
                $this->orWhere(['like', 'LOWER(user)', 'android']);
                return $this;

                // return "AND LOWER(user) NOT LIKE '%maxthon%' AND LOWER(user) NOT LIKE '%myie%' AND LOWER(user) NOT LIKE '%msie%' AND LOWER(user) NOT LIKE '%opera%' AND LOWER(user) NOT LIKE '%opr/%' AND LOWER(user) NOT LIKE '%firefox%' AND (LOWER(user) LIKE '%chrome%' OR LOWER(user) LIKE '%android%')";
                break;
            case "safari.png":
                $this->andWhere(['not like', 'LOWER(user)', ['maxthon', 'myie', 'msie', 'opera', 'firefox', 'chrome','android']]);
                $this->orWhere(['like', 'LOWER(user)', 'safari']);
                return $this;
                break;
            case "mac.png":
                $this->andWhere(['not like', 'LOWER(user)', ['maxthon', 'myie', 'msie', 'opera', 'firefox', 'chrome','safari']]);
                $this->andWhere(['like', 'LOWER(user)', 'mac']);
                return $this;
                break;
            case "mozilla.png":
                return "AND LOWER(user) NOT LIKE '%maxthon%' AND LOWER(user) NOT LIKE '%myie%' AND LOWER(user) NOT LIKE '%msie%' AND LOWER(user) NOT LIKE '%opera%' AND LOWER(user) NOT LIKE '%firefox%' AND LOWER(user) NOT LIKE '%chrome%' AND LOWER(user) NOT LIKE '%safari%' AND LOWER(user) NOT LIKE '%trident%' AND LOWER(user) NOT LIKE '%mac%' AND LOWER(user) LIKE '%mozilla%'";
                break;
            default:
                return "AND LOWER(user) NOT LIKE '%maxthon%' AND LOWER(user) NOT LIKE '%myie%' AND LOWER(user) NOT LIKE '%msie%' AND LOWER(user) NOT LIKE '%trident%' AND LOWER(user) NOT LIKE '%opera%' AND LOWER(user) NOT LIKE '%opr/%' AND LOWER(user) NOT LIKE '%android%' AND LOWER(user) NOT LIKE '%firefox%' AND LOWER(user) NOT LIKE '%chrome%' AND LOWER(user) NOT LIKE '%safari%' AND LOWER(user) NOT LIKE '%mac%' AND LOWER(user) NOT LIKE '%mozilla%'";
                break;
        }
    }

}