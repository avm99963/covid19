set xlabel "Casos actius per 10^5 habitants"
set ylabel "Mitjana taxa de creixement darrers 7 dies"
set title font "Helvetica,20"

set xrange[0:7000]
set yrange[0:5]
set samples 400

set multiplot layout 3,3
set key off
set tics out scale 0.5,0.2

min(a, b) = (a < b ? a : b)

n = 9
array fileNames[n] = ["TerresDeLEbre.dat", "CampDeTarragona.dat", "AltPirineuAran.dat", "Lleida.dat", "Girona.dat", "CatalunyaCentral.dat", "BarcelonaCiutat.dat", "MetropolitaSud.dat", "MetropolitaNord.dat"]
array prettyNames[n] = ["Terres de l'Ebre", "Camp de Tarragona", "Alt Pirineu, Aran", "Lleida", "Girona", "Catalunya central", "Barcelona ciutat", "Metropolità sud", "Metropolità nord"]

# The different colored areas correspond to the classification of the EPG values defined on page 8 at https://biocomsc.upc.edu/en/shared/20200506_report_web_51.pdf

do for [i = 1:n] {
  lastUpdated = system("tail -n 1 ".filesPrefix.fileNames[i]." | awk '{print $1;}'")
  graphTitle = prettyNames[i]
  graphDataFile = filesPrefix.fileNames[i]
  load "includes/plotSingleGraph.gnu"
}

unset multiplot
