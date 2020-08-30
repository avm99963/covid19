<?php
if (php_sapi_name() != "cli")
  exit();

// Font dels nombres d'habitants: https://catsalut.gencat.cat/web/.content/minisite/catsalut/proveidors_professionals/registres_catalegs/documents/poblacio-referencia.pdf
$HABITANTS = [
  "Alt Pirineu i Aran" => 67277,
  "Lleida" => 362850,
  "Camp de Tarragona" => 607999,
  "Terres de l'Ebre" => 176817,
  "Girona" => 861753,
  "Catalunya Central" => 526959,
  "Barcelona" => 5050190,
  "Barcelona Ciutat" => 1693449,
  "Metropolità Sud" => 1370709,
  "Metropolità Nord" => 1986032,
];

$CODENAME = [
  "Alt Pirineu i Aran" => "AltPirineuAran",
  "Lleida" => "Lleida",
  "Camp de Tarragona" => "CampDeTarragona",
  "Terres de l'Ebre" => "TerresDeLEbre",
  "Girona" => "Girona",
  "Catalunya Central" => "CatalunyaCentral",
  "Barcelona" => "Barcelona",
  "Barcelona Ciutat" => "BarcelonaCiutat",
  "Metropolità Sud" => "MetropolitaSud",
  "Metropolità Nord" => "MetropolitaNord",
];

require_once(__DIR__."/includes/generation.php");

// Demanem una llista del nombre de casos cada dia a cada regió sanitària
$data = query("SELECT data, regiosanitariadescripcio AS regio, sum(numcasos) AS sum_numcasos
WHERE
  resultatcoviddescripcio = 'Positiu PCR' AND
  regiosanitariadescripcio <> 'No classificat'
GROUP BY regiosanitariadescripcio, data
ORDER BY data ASC, regiosanitariadescripcio
LIMIT 50000");

// Fem un array que tindrà com a elements un array per cada regió amb el
// contingut de totes les files d'aquella regió
$dataPerRegio = [];
foreach ($data as $row) {
  if (!isset($dataPerRegio[$row["regio"]])) $dataPerRegio[$row["regio"]] = [];
  $dataPerRegio[$row["regio"]][] = $row;
}

$summary = [];
foreach ($dataPerRegio as $regio => $dataRegio) { // Per a cada regió
  if (!in_array($regio, array_keys($CODENAME)))
    die("[fatal error] No tenim contemplada la regió '".$regio."'.\n");

  // Generem les dades
  $summary[$regio] = generateSummary($dataRegio, $HABITANTS[$regio]);
}

// Posem les dades a diversos fitxers per tal que les pugui llegir el gnuplot
foreach ($summary as $regio => $summaryRegio) {
  $file = fopen("/tmp/covid19graphgenerator-".$CODENAME[$regio].".dat", "w");

  $i = 0;
  foreach ($summaryRegio as $row) {
    fwrite($file, $row["data"]." ".$row["ia14"]." ".$row["rho7"]." ".$i."\n");
    ++$i;
  }

  fclose($file);
}
