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

function getSumDay($originalDay, $translation, &$dataRegio) {
  if ($translation >= 0)
    $day = (clone $originalDay)->add(new DateInterval("P".abs($translation)."D"));
  else
    $day = (clone $originalDay)->sub(new DateInterval("P".abs($translation)."D"));

  foreach ($dataRegio as $row) {
    $rowDay = new DateTime($row["data"]);
    if ($day == $rowDay) return $row["sum_numcasos"];
  }

  return 0;
}

function query($soql) {
  $url = "https://analisi.transparenciacatalunya.cat/resource/xuwf-dxjd.json?\$query=".urlencode($soql);
  $raw = file_get_contents($url);
  return json_decode($raw, true);
}

$data = query("SELECT data, regiosanitariadescripcio AS regio, sum(numcasos) AS sum_numcasos
WHERE
  resultatcoviddescripcio = 'Positiu PCR' AND
  regiosanitariadescripcio <> 'No classificat'
GROUP BY regiosanitariadescripcio, data
ORDER BY data ASC, regiosanitariadescripcio");

$dataPerRegio = [];
foreach ($data as $row) {
  if (!isset($dataPerRegio[$row["regio"]])) $dataPerRegio[$row["regio"]] = [];
  $dataPerRegio[$row["regio"]][] = $row;
}

$summary = [];
foreach ($dataPerRegio as $regio => $dataRegio) {
  $summary[$regio] = [];

  $oldestDay = new DateTime("today");
  $newestDay = new DateTime();
  $newestDay->setTimestamp(0);

  foreach ($dataRegio as $row) {
    $date = new DateTime($row["data"]);
    if ($date < $oldestDay) $oldestDay = $date;
    if ($date > $newestDay) $newestDay = $date;
  }

  $rhos = [];

  for ($currentDate = (clone $oldestDay)->add(new DateInterval("P7D")); $currentDate < $newestDay; $currentDate->add(new DateInterval("P1D"))) {
    $den = getSumDay($currentDate, -4, $dataRegio) + getSumDay($currentDate, -5, $dataRegio) + getSumDay($currentDate, -6, $dataRegio);
    if ($den == 0) continue;

    $rho = (getSumDay($currentDate, 1, $dataRegio) + getSumDay($currentDate, 0, $dataRegio) + getSumDay($currentDate, -1, $dataRegio))/($den);

    $rhos[] = [
      "data" => $currentDate->format("c"),
      "rho" => $rho
    ];
  }

  for ($currentDate = (clone $oldestDay)->add(new DateInterval("P14D")); $currentDate < $newestDay; $currentDate->add(new DateInterval("P1D"))) {
    $sum = 0;

    $p14Date = (clone $currentDate)->sub(new DateInterval("P14D"));
    $p7Date = (clone $currentDate)->sub(new DateInterval("P7D"));

    foreach ($dataRegio as $row) {
      $date = new DateTime($row["data"]);
      if ($date >= $p14Date && $date < $currentDate) {
        $sum += $row["sum_numcasos"];
      }
    }

    $rhoAverage = 0;
    $rhoCount = 0;

    foreach ($rhos as $row) {
      $date = new DateTime($row["data"]);
      if ($date >= $p7Date && $date < $currentDate) {
        ++$rhoCount;
        $rhoAverage += $row["rho"];
      }
    }

    $rhoAverage /= $rhoCount;

    $summary[$regio][] = [
      "data" => $currentDate->format("d/m/y"),
      "ia14" => (isset($HABITANTS[$regio]) ? $sum*(1e5/$HABITANTS[$regio]) : null),
      "rho7" => $rhoAverage
    ];
  }
}

foreach ($summary as $regio => $summaryRegio) {
  $file = fopen("/tmp/covid19graphgenerator-".$CODENAME[$regio].".dat", "w");

  foreach ($summaryRegio as $row)
    fwrite($file, $row["data"]." ".$row["ia14"]." ".$row["rho7"]."\n");

  fclose($file);
}
