<?php
if (php_sapi_name() != "cli")
  exit();

require_once(__DIR__."/../config/config.php");
require_once(__DIR__."/includes/generation.php");

// Funció que retorna el nombre d'habitants a les ABS donades via una
// API de la Generalitat de Catalunya
function habitants($abs) {
  $data = query("SELECT sum(poblacio_oficial) AS habitants
  WHERE
    abs_codi in(".implode(",", array_map(function($abs) { return "'".$abs."'"; }, $abs)).") AND
    any = 2020", "ftq4-h9vk");

  return ($data[0]["habitants"] ?? null);
}

if (isset($conf["customAreas"])) {
  // A cada ciutat
  foreach ($conf["customAreas"] as $area) {
    // Si no hi ha cap ABS configurada no fem res
    if (count($area["abs"]) == 0) {
      echo "[Warning] There aren't any ABS configured for ".$area["name"].".\n";
      continue;
    }

    // Demanem una llista del nombre de casos cada dia
    $data = query("SELECT data, sum(numcasos) AS sum_numcasos
    WHERE
      resultatcoviddescripcio = 'Positiu PCR' AND
      abscodi in(".implode(",", array_map(function($abs) { return "'".$abs."'"; }, $area["abs"])).")
    GROUP BY data
    ORDER BY data ASC
    LIMIT 50000");

    // Obtenim el nombre d'habitants a les ABS
    $habitants = habitants($area["abs"]);
    if ($habitants === null) {
      echo "[Fatal error] Failed getting population for ".$area["name"].".\n";
      continue;
    }

    // Generem les dades
    $summary = generateSummary($data, $habitants);

    // Les escribim en un fitxer
    $file = tmpfile();
    $fileName = stream_get_meta_data($file)['uri'];

    $i = 0;
    foreach ($summary as $row) {
      fwrite($file, $row["data"]." ".$row["ia14"]." ".$row["rho7"]." ".$i."\n");
      ++$i;
    }

    // Cridem al gnuplot perquè generi la gràfica
    shell_exec("gnuplot -c generateCustomGraph.gnu \"".escapeshellcmd($area["name"])."\" \"".escapeshellcmd($area["codename"])."\" \"".escapeshellcmd($fileName)."\"");
    rename("/tmp/covid19graphgenerator-area-".$area["codename"]."-graph.png", __DIR__."/../output/area-".$area["codename"]."-graph.png");
    rename("/tmp/covid19graphgenerator-area-".$area["codename"]."-graph.svg", __DIR__."/../output/area-".$area["codename"]."-graph.svg");

    fclose($file);
  }
} else {
  echo "[Warning] The config/customAreas.php file doesn't define the customAreas field.";
}
