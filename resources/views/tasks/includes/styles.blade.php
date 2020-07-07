<style>
<?php
foreach(\App\Priority::get() as $priority)
{
    echo PHP_EOL .'.' . $priority->name .
            '{'. 
            'background-color: '. $priority->background_color .';'.
            'color: '. $priority->text_color .';'.
            '}' ;
}
?>
</style>
