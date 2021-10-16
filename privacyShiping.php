<?php

include_once ("Data/Connection/EntidadBase.php");
$db=new \Tiendita\EntidadBase();
$menu = $db->getAll("menus");

$db->close();
?>
<script>
    function go(url){
        window.location.href=url;
    }
</script>
<div class='container-fluid mb-2'
     style='margin-bottom:1px; font-size: 0.7rem;padding-left: 50%; padding-bottom: 1.5rem;' >
    <label style='width: 14vw;display: inline-block;position: absolute;left: 50vw;font-size: 0.7rem;' onclick='go("privacy.php")'>PRIVACY POLICY'</label>
    <label style='width: 15vw;display: inline-block;position: absolute;left: 62vw;font-size: 0.7rem;'><span onclick='go("shipping.php")'>SHIPPING RETURNS</span></label>
</div>

