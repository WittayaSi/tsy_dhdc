<?php
	use yii\helpers\Html;
	use miloschuman\highcharts\Highcharts;
	use kartik\grid\GridView;
    $this->title = 'รายงาน-ประชากร';
	$this->params['breadcrumbs'][] = 'รายงาน-ประชากร';
?>
<h3> รายงาน-ประชากร </h3></br>
<div class="well">
    
<p>-
    <?php
    echo \yii\helpers\Html::a(' ปิรามิดประชากร(จำนวนประชากรแยกกลุ่มอายุ)', ['population/pyramid']);
    
    ?>
</p>

<p>-
    <?php
    echo \yii\helpers\Html::a(' จำนวนประชากรแยกตามประเภทการอยู่อาศัย', ['population/type-area']);
    
    ?>
</p>

<p>-
    <?php
    echo \yii\helpers\Html::a(' ตรวจสอบ 13 หลัก', ['population/checkcid']);
    
    ?>
</p>

<p>-
    <?php
    echo \yii\helpers\Html::a(' ประเภทการอยู่อาศัยซ้ำซ้อนกัน', ['population/duplicate']);
    
    ?>
</p>

<div class="footerrow" style="padding-top: 30px">
    <div class="alert alert-success">
        หมายเหตุ : ระบบรายงานอยู่ระหว่างพัฒนาอย่างต่อเนื่อง
    </div>
</div>

</div>