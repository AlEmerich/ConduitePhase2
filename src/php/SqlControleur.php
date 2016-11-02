<?php
class SqlControleur
{

    function executeQueryFile($conn,$filesql) {
        $query = file_get_contents($filesql);
        $array = explode(";\n", $query);
        $b = true;
        for ($i=0; $i < count($array) ; $i++) {
            $str = $array[$i];
            if ($str != '') {
                $str .= ';';
                $b &= $conn->query($str);  
            }  
        }
        
        return $b;
    }
}
?>
