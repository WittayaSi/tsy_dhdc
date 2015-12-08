<?php

namespace backend\controllers;

class ImportDataController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    
    public function actionIndex()
    {
        $hospname = '';
        $rawData1 = '';
        $sql = "select mapp_table,mapp_query from data_hinfo.mas_mapp_main";
        
        if (!empty($_POST['hospcode'])) {
            $h = $_POST['hospcode'];
            $m= \frontend\models\ChospitalAmp::findOne(['hoscode'=>$h]);
            $hospname = $m->hosname;   
        }
        try {
            $rawData = \Yii::$app->db2->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $count = count($rawData);
        if (!empty($_POST['hospcode'])) {
            $dbname = 'db'.$_POST['hospcode'];
            //$db2 = 'db';
            for($i=0;$i<1;$i++){
                $sql_command = $rawData[$i]['mapp_query'];
                $table = $rawData[$i]['mapp_table'];
                $table = 'tmp_'.$table;
                $sql = "truncate $table";
                try {
                    $count_exe = \Yii::$app->db->createCommand($sql)->execute();
                } catch (\yii\db\Exception $e) {
                    throw new \yii\web\ConflictHttpException('sql error');
                }
                $sql = $sql_command;
                try {
                    $rawData1 = \Yii::$app->$dbname->createCommand($sql)->queryAll();
                } catch (\yii\db\Exception $e) {
                    throw new \yii\web\ConflictHttpException('sql error');
                }
                $sql = "replace into $table select * from person";
                try {
                    $exe = \Yii::$app->db->createCommand($sql)->execute();
                } catch (\yii\db\Exception $e) {
                    throw new \yii\web\ConflictHttpException('sql error');
                }
                
            }
        }
        return $this->render('index',[
            'hospname' => $hospname,
            'hospcode'=>isset($_POST['hospcode'])?$_POST['hospcode']:'',
            'count' => $count,
            'rawData' => $rawData,
            'rawData1' => $rawData1
        ]);
    }

    protected function call($store_name, $arg = NULL) {
        $sql = "";
        if ($arg != NULL) {
            $sql = "call " . $store_name . "(" . $arg . ");";
        } else {
            $sql = "call " . $store_name . "();";
        }
        $this->exec_sql($sql);
    }

    protected function call2($store_name, $arg1 = NULL, $arg2 = NULL) {
        $sql = "";
        $arg1 = "'".$arg1."'";
        if ($arg1 != NULL and $arg2 != NULL) {
            $sql = 'call '.$store_name.'('.$arg1.')';
        }
        $this->exec_sql_db($sql,$arg2);
    }

    protected function exec_sql($sql,$db) {
        if($db == 1){
            $affect_row = \Yii::$app->db->createCommand($sql)->execute();
        }else{
            $affect_row = \Yii::$app->db2->createCommand($sql)->execute();
        }
        return $affect_row;
    }

    protected function exec_sql_db($sql,$db){
         $affect_row = \Yii::$app->$db->createCommand($sql)->execute();
         return $affect_row;
    }

    protected function query_all($sql) {
        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        return $rawData;
    }

    protected function query_all_db2($sql) {
        $rawData = \Yii::$app->db2->createCommand($sql)->queryAll();
        return $rawData;
    }

    public function actionGeneratorperson()
    {
        $sql = "select hoscode from chospital_amp";
        $rawData = $this->query_all_db2($sql);
        $sql = "truncate person";
        $this->exec_sql($sql,2);
        $count_hos = count($rawData);
        //person
        for($i=0;$i<$count_hos;$i++){
            $db_name = 'jhcisdb_'.$rawData[$i]['hoscode'];
            $db = 'db'.$rawData[$i]['hoscode'];

            if($rawData[$i]['hoscode'] == '11241'){
                $sql = "call replace_into_table_all()";
                $this->exec_sql($sql,2);
            }else{
                $table = 'person';
                $sql ="call cal_table_tmp('$table')";
                $this->exec_sql_db($sql,$db);
                $sql = "call replace_into_table_person('$db_name')";
                $this->exec_sql($sql,2);
            }
        }
        
    }

    public function actionGeneratorall()
    {
        $sql = "select hoscode from chospital_amp where hoscode <> '11241'";
        $rawData = $this->query_all($sql);
        $count_hos = count($rawData);


        $sql = "select mapp_table,mapp_query from mas_mapp_main where mapp_table <> 'person'";
        $mapData = $this->query_all_db2($sql);
        $count = count($mapData);

        for($i=0;$i<$count;$i++)
        {
            $table = $mapData[$i]['mapp_table'];
            $sql = "update processing set table_name = '$table' where id=1";
            $this->exec_sql($sql,2);

            for($k=0;$k<$count_hos;$k++)
            {
                $db_name = 'jhcisdb_'.$rawData[$k]['hoscode'];
                $db = 'db'.$rawData[$k]['hoscode'];

                $sql ="call cal_table_tmp('$table')";
                $this->exec_sql_db($sql,$db);
                $sql = "call replace_into_table('$table','$db_name')";
                $this->exec_sql($sql,2);
            }
            
        }
    }

}
