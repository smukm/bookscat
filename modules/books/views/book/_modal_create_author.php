<?php

declare(strict_types=1);

use yii\bootstrap5\Modal;

Modal::begin([
    'id' => 'modal',
    'size' => 'modal-lg',
    'title' => Yii::t('books', 'Create a new author'),
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => TRUE]
]);?>
<div id="modalContent"></div>
<?php Modal::end();?>

<?php

$this->registerJs( <<< EOT_JS_CODE
  $(function(){
  $('.modalButton').click(function (e){
    e.preventDefault();
    
    $.get($(this).attr('href'), function(data) {
        $('#modal').modal('show').find('#modalContent').html(data);
    });

   return false;
  });
});
EOT_JS_CODE
);
?>
