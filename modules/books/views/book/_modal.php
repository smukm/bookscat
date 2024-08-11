<?php

use yii\bootstrap5\Modal;

Modal::begin([
    'id' => 'modal',
    'size' => 'modal-lg',
    'title' => Yii::t('books', 'Subscribe to author books'),
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => TRUE]
]);?>
<div id="modalContent"></div>
<?php Modal::end();?>

<?php

$this->registerJs( <<< EOT_JS_CODE
  $(function(){
  $('.modalButton').click(function (e){
    e.preventDefault();
    
    /*$.ajax({
        url: $(this).attr('href'),
        success: function (data) {
            $('#modal').modal('show').find('#modalContent').html(data);
            $('#author-name').html('bbb');
        }
    });*/
    
    $.get($(this).attr('href'), function(data) {
        $('#modal').modal('show').find('#modalContent').html(data);
        //$('#author-name').html('bbb');
    });

   return false;
  });
});
EOT_JS_CODE
);
?>
