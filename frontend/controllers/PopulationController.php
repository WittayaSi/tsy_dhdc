<?php

namespace frontend\controllers;

class PopulationController extends \yii\web\Controller
{
	public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPyramid()
    {
    	$hospname = '';
    	$sql = "select substr(t.age_range,3, 10) as age, sum(t.male) as male, sum(t.female) as female 
    			from sys_ages_level_3 t 
    			group by t.age_range";

    	if (!empty($_POST['hospcode'])) {
            $h = $_POST['hospcode'];
            $m= \frontend\models\ChospitalAmp::findOne(['hoscode'=>$h]);
            $hospname = $m->hosname;
            $sql = "select substr(t.age_range, 3, 10) as age, t.male as male, t.female as female
            		from sys_ages_level_3 t
            		where t.hospcode = $h
            		group by t.age_range";
        }

        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',
            'allModels' => $rawData,
            'pagination' => FALSE,
        ]);

        return $this->render('pyramid',[
        		'dataProvider' => $dataProvider,
        		'rawData' => $rawData,
        		'hospname' => $hospname,
        		'hospcode'=>isset($_POST['hospcode'])?$_POST['hospcode']:'',
        	]);
    }

    public function actionCheckcid()
    {
        //$hospname = '';
        $sql = "SELECT * FROM cid_error";
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',
            'allModels' => $rawData,
            'pagination' => FALSE,
        ]);

        return $this->render('checkcid',[
                'dataProvider' => $dataProvider,
                'rawData' => $rawData,
                //'hospname' => $hospname,
                //'hospcode'=>isset($_POST['hospcode'])?$_POST['hospcode']:'',
            ]);
    }

    public function actionCheckcidDetails($hospcode = null)
    {
        $sql = "SELECT * FROM cid_error_data where hospcode = '$hospcode'";
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',
            'allModels' => $rawData,
            'pagination' => FALSE,
        ]);

        return $this->render('checkcidDetails',[
                'dataProvider' => $dataProvider,
                'rawData' => $rawData,
                'hospcode' => $hospcode
                //'hospname' => $hospname,
                //'hospcode'=>isset($_POST['hospcode'])?$_POST['hospcode']:'',
            ]);
    }

    public function actionTypeArea(){
        $sql = "SELECT * FROM population_typearea";
        try{
            $rawData = \yii::$app->db->createCommand($sql)->queryAll();
        } catch(\yii\db\Exception $e){
            throw new E\yii\web\ConflictHttpException('sql error');
        }

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => false,
        ]);

        return $this->render('typearea',[
            'dataProvider' => $dataProvider,
            'rawData' => $rawData,
        ]);
    }

    public function actionDuplicate(){
        $sql = "SELECT
p.CID as 'เลขประชาชน',GROUP_CONCAT(p.NAME) as 'ชื่อ', GROUP_CONCAT(p.LNAME) as 'สกุล', GROUP_CONCAT(p.TYPEAREA) as 'ประเภทพักอาศัย',GROUP_CONCAT(p.pid) as 'เลขประจำตัวฐานHISของท่าน',
GROUP_CONCAT(p.birth) as 'วันเกิด',
GROUP_CONCAT(p.HOSPCODE) as 'รหัสหน่วยบริการที่ซ้ำซ้อนเป้าหมายคนไทย'
FROM person p
WHERE LENGTH(p.CID) = 13 and p.typearea in ('1','3')
AND p.NATION = '099' and p.discharge='9' and p.cid not like '0%' 
GROUP BY p.CID
HAVING COUNT(p.CID)>1
order by p.hospcode;";
        try{
            $rawData = \yii::$app->db->createCommand($sql)->queryAll();
        } catch(\yii\db\Exception $e){
            throw new E\yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => false
        ]);

        return $this->render('duplicate',[
            'dataProvider' => $dataProvider,
            'rawData' => $rawData
        ]);
    }

}
