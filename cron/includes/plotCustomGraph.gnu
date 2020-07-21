set xlabel "Casos actius per 10^5 habitants"
set ylabel "Mitjana taxa de creixement darrers 7 dies"
set title font "Helvetica,20"

set yrange[0:5]
set xrange[0:800]
set samples 400

set key off
set tics out scale 0.5,0.2

min(a, b) = (a < b ? a : b)

# The different colored areas correspond to the classification of the EPG values defined on page 8 at https://biocomsc.upc.edu/en/shared/20200506_report_web_51.pdf

lastUpdated = system("tail -n 1 ".fileName." | awk '{print $1;}'")
graphTitle = name
graphDataFile = fileName
load "includes/plotSingleGraph.gnu"
