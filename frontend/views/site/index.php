<?php

/* @var $this yii\web\View */
/** @var null|array $popup */

$this->title = 'My Yii Application';
?>

<div class="g-content container">
    <h1>H1 header medium 26px</h1>
    <h2>H2 header medium 22px</h2>
    <h3>H3 header medium 18px</h3>
    <h4>H4 header medium 16px</h4>
    <h5>H5 header 12px</h5>

    <p>1</p>
    <p>1</p>
    <p>1</p>
    <p>1</p>
    <p>1</p>
    <p>1</p>
    <p>1</p>

</div>

<?php
if ($popup) {
    echo $this->render('popup', $popup);
}
?>
