<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
foreach($rows as $r)
{
    $ck = "";
    if($r[0]==1)
    {
        $ck = "checked";
    }
    ?>
    <label for="idtipo_pasajero<?php echo $r[0] ?>" style="margin-left: 10px;"><?php echo $r[1]; ?></label>
    <input type="radio" name="idtipo_pasajero" id="idtipo_pasajero<?php echo $r[0]; ?>" value="<?php echo $r[0]; ?>"  <?php echo $ck; ?>/>
    <?php
}
?>

