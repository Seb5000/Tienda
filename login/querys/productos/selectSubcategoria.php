<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/compartidos/baseDatos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/tio/modelos/Subcategoria.php';

$bd = new DataBase();
$conn = $bd->conectar();
$subcategoria = new Subcategoria($conn);
$json = file_get_contents('php://input');
$data = json_decode($json, true);
$arrSub = $subcategoria->listaSubcategorias2();

if(isset($data["valor"])){
    //echo "se introdujo un valor".$data["valor"];
    $valor = $data["valor"];
}else{
    /*
    echo "No se introdujo el valor";
    http_response_code(404);
    header("Location: /tio/login/error.php",TRUE,301);
    return;
    */
    //$arrSub = $subcategoria->listaSubcategorias2();
?>
<option value="none" selected disabled hidden>&#128586; Selecione una opcion</option>
<option value="todas">&#128049; Mostrar todos</option>
<option value="sinSubcategoria">&#9932; Sin Subcategoria</option>
<?php
foreach($arrSub as $sub):
?>
<optgroup label="<?php echo $sub["nombre"] ?>">
<?php
    foreach($sub["subcategorias"] as $itemSub):
?>
    <option value="<?php echo $itemSub["id"] ?>"> &#9657; <?php echo $itemSub["nombre"] ?></option>
<?php
    endforeach;
?>
<?php
endforeach;
return;
}

if($valor == "todas" or $valor == "none"){
?>
<option value="none" selected disabled hidden>&#128586; Selecione una opcion</option>
<option value="todas">&#128049; Mostrar todos</option>
<option value="sinSubcategoria">&#9932; Sin Subcategoria</option>
<?php
foreach($arrSub as $sub):
?>
<optgroup label="<?php echo $sub["nombre"] ?>">
<?php
    foreach($sub["subcategorias"] as $itemSub):
?>
    <option value="<?php echo $itemSub["id"] ?>"> &#9657; <?php echo $itemSub["nombre"] ?></option>
<?php
    endforeach;
?>
<?php
endforeach;
return;
}

if($valor == "sinCategoria"){
    $arrSub = $subcategoria->listaSubcategorias2();
    $arrLista = $arrSub["sinCategoria"]["subcategorias"];
?>
<option value="none" selected disabled hidden>&#128586; Selecione una opcion</option>
<?php
foreach($arrLista as $sub):
?>
    <option value="<?php echo $sub["id"] ?>"> &#9657; <?php echo $sub["nombre"] ?></option>
<?php
endforeach;
return;
}

$existe = $subcategoria->existeIdCategoria($valor);
if($existe){
    $arrLista = $arrSub[$valor]["subcategorias"];
?>
<option value="none" selected disabled hidden>&#128586; Selecione una opcion</option>
<?php
foreach($arrLista as $sub):
?>
    <option value="<?php echo $sub["id"] ?>"> &#9657; <?php echo $sub["nombre"] ?></option>
<?php
endforeach;
return;
}

//Si todo lo anterior falla
//devolver un codigo de error 404 bad request
http_response_code(404);
echo "Algo sucedio mal";
return;
?>