<?php
require_once "keyboard.class.php";
$kb = new keyboard();
$kb->makeKeyboard();
$kb->drawKeyboard();
$kb->makeGraph();
$sentence = "Hello world!";
$commands = $kb->makeCommands($sentence);
?>
<div>
    <?php echo $sentence; ?>
</div>
<div>
    <?php echo $commands; ?>
</div>
<?
$sentence = "7&";
$commands = $kb->makeCommands($sentence);
?>
<div>
    <?php echo $sentence; ?>
</div>
<div>
    <?php echo $commands; ?>
</div>
<?
$sentence = "ABCD";
$commands = $kb->makeCommands($sentence);
?>
<div>
    <?php echo $sentence; ?>
</div>
<div>
    <?php echo $commands; ?>
</div>
