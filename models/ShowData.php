<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ShowData is the model behind the Data Presentation on the Homepage.
 *
 * 
 *
 */
class ShowData extends Model
{
      public function getData()
    {
		$json = file_get_contents('https://data.cese.nsw.gov.au/data/dataset/1a8ee944-e56c-3480-aaf9-683047aa63a0/resource/64f0e82f-f678-4cec-9283-0b343aff1c61/download/headcount.json');
		$obj =  json_decode($json, true);
        return($obj);
    }

    
}
