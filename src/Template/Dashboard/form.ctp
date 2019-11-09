<div style="margin: 15px auto; max-width: 60%;">
<?php
echo $this->Form->create($model);

echo $this->Form->control('country_name', ['type' => 'text']);


echo $this->Form->button('Submit',['type'=>'submit']);

echo $this->Form->end();
?>

</div>

