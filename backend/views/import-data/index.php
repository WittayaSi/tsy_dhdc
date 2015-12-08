<?php
use yii\helpers\Html;
$this->title = 'นำเข้าข้อมูล';
?>

<div class="well">
    <form method="POST">
        <div class="row">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-3">
                <?php
                $list = yii\helpers\ArrayHelper::map(frontend\models\ChospitalAmp::find()->all(), 'hoscode', 'hosname');
                echo yii\helpers\Html::dropDownList('hospcode', $hospcode, $list, [
                    'prompt' => 'เลือกสถานบริการ',
                    'class' => 'form-control'
                ]);
                ?>
            </div>
            <div class="col-sm-3">
                <button class="btn btn-danger">ตกลง</button>
            </div>
        </div>
    </form>
</div>  
<div class="well">
    
    <div align="center">
        
        <h2><?php echo $hospcode." : ".$hospname ?></h2>
        
    </div>
    
</div>

<div class="well">
    
    <div align="center">
        
        <h2><?php echo $count ?></h2><br>
        <h2><?php print_r($rawData1) ?></h2>
        
    </div>
    
</div>