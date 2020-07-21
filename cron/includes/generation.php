<?php
if (php_sapi_name() != "cli")
  exit();

// Funció per obtenir el nombre de casos nous al dia originalDay+translation
// a partir de les dades de la regió (dataRegio).
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

// Funció per fer una consulta a la taula de dades
function query($soql, $resource = "xuwf-dxjd") {
  $url = "https://analisi.transparenciacatalunya.cat/resource/".$resource.".json?\$query=".urlencode($soql);
  $raw = file_get_contents($url);
  if ($raw === false) return null;
  return json_decode($raw, true);
}

// Funció per generar les dades de cada regió
function generateSummary(&$dataRegio, $habitants){
  $summary = [];

  // Veiem quin és el primer i l'últim dia de la sèrie
  $oldestDay = new DateTime("today");
  $newestDay = new DateTime();
  $newestDay->setTimestamp(0);

  foreach ($dataRegio as $row) {
    $date = new DateTime($row["data"]);
    if ($date < $oldestDay) $oldestDay = $date;
    if ($date > $newestDay) $newestDay = $date;
  }

  // Si l'últim dia és avui, posem que sigui ahir, perquè no volem informació
  // incompleta sobre avui.
  if ($oldestDay == (new DateTime("today")))
    $oldestDay = new DateTime("yesterday");

  // Ara calculem les rhos.
  $rhos = [];

  // Considerem cada dia a partir de 6 dies després del primer dia, i fins al
  // dia anterior a l'últim dia (extrems inclosos)
  for ($currentDate = (clone $oldestDay)->add(new DateInterval("P6D"));
  $currentDate < $newestDay;
  $currentDate->add(new DateInterval("P1D"))) {
    // Calculem la rho (velocitat reproductiva efectiva) per aquell dia.
    // Fórmula: https://biocomsc.upc.edu/en/shared/avaluacio_risc.pdf
    $num = getSumDay($currentDate, 1, $dataRegio) +
           getSumDay($currentDate, 0, $dataRegio) +
           getSumDay($currentDate, -1, $dataRegio);

    $den = getSumDay($currentDate, -4, $dataRegio) +
           getSumDay($currentDate, -5, $dataRegio) +
           getSumDay($currentDate, -6, $dataRegio);

    if ($num != 0 && $den == 0) continue;

    $rho = ($num == 0 ? 0 : $num/$den);

    $rhos[] = [
      "data" => $currentDate->format("c"),
      "rho" => $rho
    ];
  }

  // Considerem cada dia a partir de 13 dies després del primer dia, i fins el
  // dia anterior a l'últim dia (extrems inclosos)
  for ($currentDate = (clone $oldestDay)->add(new DateInterval("P13D"));
    $currentDate < $newestDay;
    $currentDate->add(new DateInterval("P1D"))) {
    // Calculem Rho_7 i IA_14
    // Rho_7(t) := \sum_{i=0}^{7} Rho(t - i)
    // IA_14(t) := \sum_{i=0}^{14} N(t - i),
    //   on N(j) és el nombre de casos nous confirmats per PCR el dia j.
    $sum = 0;

    $p13Date = (clone $currentDate)->sub(new DateInterval("P13D"));
    $p6Date = (clone $currentDate)->sub(new DateInterval("P6D"));

    foreach ($dataRegio as $row) {
      $date = new DateTime($row["data"]);
      if ($date >= $p13Date && $date <= $currentDate) {
        $sum += $row["sum_numcasos"];
      }
    }

    $rhoAverage = 0;
    $rhoCount = 0;

    foreach ($rhos as $row) {
      $date = new DateTime($row["data"]);
      if ($date >= $p6Date && $date <= $currentDate) {
        ++$rhoCount;
        $rhoAverage += $row["rho"];
      }
    }

    // Si no hem trobat rhos (rhoCount == 0) és perquè el numerador no era 0
    // però el denominador era sempre 0 al calcular les rhos. Aleshores, tot i
    // que no poguem calcular la rho_7 a causa de no poder calcular les rho_t
    // individuals, aquest fet ens indica que el creixement ha sigut altíssim,
    // i per tant posem una rho_7 de 1000000000, que se surt de la gràfica.
    $rhoAverage = ($rhoCount == 0 ? 1000000000 : $rhoAverage/$rhoCount);

    $summary[] = [
      "data" => $currentDate->format("d/m/y"),
      "ia14" => $sum*(1e5/$habitants),
      "rho7" => $rhoAverage
    ];
  }

  return $summary;
}
