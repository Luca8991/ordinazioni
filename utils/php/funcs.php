<?php
//
//
//
//
//
 function printTables(){ //prendi tutti i tipi di prodotti e stampa una tabella per ogni tipo
   global $mysqli;
   $getTipi = $mysqli->query("SELECT * FROM `Tipo` WHERE 1");

   if ($getTipi->num_rows > 0){

       while ($row = $getTipi->fetch_assoc()){
         $tipo_id = $row['ID'];
         $tipo = $row['Tipo'];

         echo tableContent($tipo_id, $tipo);
       }
    }

 }

 function printIndex(){ //prendi tutti i tipi e stampa l'indice
   global $mysqli;
   $getTipi = $mysqli->query("SELECT * FROM `Tipo` WHERE 1");

   if ($getTipi->num_rows > 0){
       echo "<ul style='margin-top: 0px;'>";

       while ($row = $getTipi->fetch_assoc()){
         $tipo_id = $row['ID'];
         $tipo = $row['Tipo'];

         echo "<li><a href='#indice-$tipo_id'>$tipo</a></li>";
       }
       echo "<li style='margin-top: 10px;'>
              <button style='background-color: blue;'><a href='javascript:void(0);' id='btn-conto' style='color:white;' onclick='showConto();'>Vai al conto</a></button>
             </li>
             </ul>";
    }
 }

function tableHead($id, $displayname){
  echo "<table class='table' id='tb-$id'>";
  echo "<thead><tr style='background-color: #e9f1fb;'>
          <th style='width:75%' id='indice-$id'><a href='#indice-$id'>$displayname</a></th>
          <th style='width:20%; text-align:center'>Prezzo</th>
          <th style='width:5%; text-align:center'>Quantit&#224;</th>
        </tr></thead>";
}

function tableContent($tipo_id, $tipo){
  global $mysqli;
  //$stmt = $mysqli->query("SELECT Prodotti.ID, Prodotti.IDProd, Prodotti.Nome, Prodotti.Descr, Prodotti.Prezzo, Tipo.Tipo FROM Prodotti LEFT JOIN Tipo ON Prodotti.Tipo = Tipo.ID WHERE Prodotti.Tipo = '$tipo'");
  $stmt = $mysqli->query("SELECT * FROM `Prodotti` WHERE `Tipo` = '$tipo_id' AND `fuori-listino` IS FALSE ORDER BY `Nome` ASC");

  if ($stmt->num_rows > 0){
      echo tableHead($tipo_id, $tipo);

      while ($row = $stmt->fetch_assoc()){
          $id = $row['ID'];
          $idprod = $row['IDProd'];
          $nome = $row['Nome'];
          $descr = $row['Descr'];
          $prezzo = $row['Prezzo'];

          echo "<tr id='row-$idprod'>
                  <td $class>
                    <span id='nome-$idprod'>$nome</span>
                    <br>
                    <span class='descr'>$descr</span>
                  </td>
                  <td $class style='text-align: center;'>
                    &#8364; <span id='prezzo-$idprod'>$prezzo</span>
                    <br>
                    <span class='descr'>
                      Sbt: &#8364; <span class='tot-$idprod'>0.00</span>
                    </span>
                  </td>
                  <td $class style='text-align: center;'>
                    <input type='number' class='qta input-qta-$idprod' value='0' id='input-qta-$idprod' data-prezzo='$prezzo' data-idprod='$idprod'  data-tot='0.0' disabled/>
                    <br>
                    <button class='qta-button minus' data-op='-' data-idprod='$idprod' data-prezzo='$prezzo'>-</button>
                    <button class='qta-button plus' data-op='+' data-idprod='$idprod' data-prezzo='$prezzo'>+</button>
                  </td>
                </tr>";
      }
      echo tableClose();
  }
}

function tableClose(){
    echo "</table>
          <div class='under-table'>
            <span>
              <button style='background-color: red;'><a href='#indice' style='color:white;'>Indice</a></button>
            </span>
            <span style='float: right;'>
              <button style='background-color: blue;'><a href='javascript:void(0);' id='btn-conto' style='color:white;' onclick='showConto();'>Vai al conto</a></button>
            </span>
          </div>";
}
?>
