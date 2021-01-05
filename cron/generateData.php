<?php
if (php_sapi_name() != "cli")
  exit();

// Font dels nombres d'habitants: https://catsalut.gencat.cat/web/.content/minisite/catsalut/proveidors_professionals/registres_catalegs/documents/poblacio-referencia.pdf
$HABITANTS = [
  "AltPirineuAran" => 67277,
  "Lleida" => 362850,
  "CampDeTarragona" => 607999,
  "TerresDeLEbre" => 176817,
  "Girona" => 861753,
  "CatalunyaCentral" => 526959,
  "Barcelona" => 5050190,
  "BarcelonaCiutat" => 1693449,
  "MetropolitaSud" => 1370709,
  "MetropolitaNord" => 1986032,
];

$CODENAME = [
  "7100" => "AltPirineuAran",
  "6100" => "Lleida",
  "6200" => "CampDeTarragona",
  "6300" => "TerresDeLEbre",
  "6400" => "Girona",
  "6700" => "CatalunyaCentral",
  "7803" => "BarcelonaCiutat",
  "7801" => "MetropolitaSud",
  "7802" => "MetropolitaNord",
];

require_once(__DIR__."/includes/generation.php");

// Demanem una llista del nombre de casos cada dia a cada regió sanitària
$data = query("SELECT data, regiosanitariacodi AS regio, sum(numcasos) AS sum_numcasos
WHERE
  (
    resultatcoviddescripcio = 'Positiu PCR' OR
    resultatcoviddescripcio = 'Positiu TAR'
  ) AND
  regiosanitariacodi <> '0000'
GROUP BY regiosanitariacodi, data
ORDER BY data ASC, regiosanitariacodi
LIMIT 50000");

// Fem un array que tindrà com a elements un array per cada regió amb el
// contingut de totes les files d'aquella regió
$dataPerRegio = [];
foreach ($data as $row) {
  if (!isset($dataPerRegio[$row["regio"]])) $dataPerRegio[$row["regio"]] = [];
  $dataPerRegio[$row["regio"]][] = $row;
}

$summary = [];
foreach ($dataPerRegio as $regioRaw => $dataRegio) { // Per a cada regió
  $regio = mb_strtolower($regioRaw);

  if (!in_array($regio, array_keys($CODENAME)))
    die("[fatal error] No tenim contemplada la regió '".$regio."'.\n");

  // Generem les dades
  $summary[$regio] = generateSummary($dataRegio, $HABITANTS[$CODENAME[$regio]]);
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
