set xlabel "Casos actius per 10^5 habitants"
set ylabel "Mitjana taxa de creixement darrers 7 dies"
set title font "Helvetica,20"

set xrange[0:600]
set yrange[0:5]
set samples 1000
#unset colorbox

set multiplot layout 3,3
set key off
set tics out scale 0.5,0.2

min(a, b) = (a < b ? a : b)

# The different colored areas correspond to the classification of the EPG values defined on page 8 at https://biocomsc.upc.edu/en/shared/20200506_report_web_51.pdf

set title "Terres de l'ebre"
plot 6*x w filledcurve y1=0 lt rgb "#ff9494", 100/x w filledcurve y1=0 lt rgb "#ffe494", 70/x w filledcurve y1=0 lt rgb "#dbff94", 30/x w filledcurve y1=0 lt rgb "#a0ff94", filesPrefix.'TerresDeLEbre.dat' u 2:3 w lp pt 6 lt rgb "black", "< tail -n 1 ".filesPrefix."TerresDeLEbre.dat" u 2:3 w lp pt 7 lt rgb "black"

set title "Camp de Tarragona"
plot 6*x w filledcurve y1=0 lt rgb "#ff9494", 100/x w filledcurve y1=0 lt rgb "#ffe494", 70/x w filledcurve y1=0 lt rgb "#dbff94", 30/x w filledcurve y1=0 lt rgb "#a0ff94", filesPrefix.'CampDeTarragona.dat' u 2:3 w lp pt 6 lt rgb "black", "< tail -n 1 ".filesPrefix."CampDeTarragona.dat" u 2:3 w lp pt 7 lt rgb "black"

set title "Alt Pirineu, Aran"
plot 6*x w filledcurve y1=0 lt rgb "#ff9494", 100/x w filledcurve y1=0 lt rgb "#ffe494", 70/x w filledcurve y1=0 lt rgb "#dbff94", 30/x w filledcurve y1=0 lt rgb "#a0ff94", filesPrefix.'AltPirineuAran.dat' u 2:3 w lp pt 6 lt rgb "black", "< tail -n 1 ".filesPrefix."AltPirineuAran.dat" u 2:3 w lp pt 7 lt rgb "black"

set title "Lleida"
plot 6*x w filledcurve y1=0 lt rgb "#ff9494", 100/x w filledcurve y1=0 lt rgb "#ffe494", 70/x w filledcurve y1=0 lt rgb "#dbff94", 30/x w filledcurve y1=0 lt rgb "#a0ff94", filesPrefix.'Lleida.dat' u 2:3 w lp pt 6 lt rgb "black", "< tail -n 1 ".filesPrefix."Lleida.dat" u 2:3 w lp pt 7 lt rgb "black"

set title "Girona"
plot 6*x w filledcurve y1=0 lt rgb "#ff9494", 100/x w filledcurve y1=0 lt rgb "#ffe494", 70/x w filledcurve y1=0 lt rgb "#dbff94", 30/x w filledcurve y1=0 lt rgb "#a0ff94", filesPrefix.'Girona.dat' u 2:3 w lp pt 6 lt rgb "black", "< tail -n 1 ".filesPrefix."Girona.dat" u 2:3 w lp pt 7 lt rgb "black"

set title "Catalunya central"
plot 6*x w filledcurve y1=0 lt rgb "#ff9494", 100/x w filledcurve y1=0 lt rgb "#ffe494", 70/x w filledcurve y1=0 lt rgb "#dbff94", 30/x w filledcurve y1=0 lt rgb "#a0ff94", filesPrefix.'CatalunyaCentral.dat' u 2:3 w lp pt 6 lt rgb "black", "< tail -n 1 ".filesPrefix."CatalunyaCentral.dat" u 2:3 w lp pt 7 lt rgb "black"

set title "Barcelona"
plot 6*x w filledcurve y1=0 lt rgb "#ff9494", 100/x w filledcurve y1=0 lt rgb "#ffe494", 70/x w filledcurve y1=0 lt rgb "#dbff94", 30/x w filledcurve y1=0 lt rgb "#a0ff94", filesPrefix.'Barcelona.dat' u 2:3 w lp pt 6 lt rgb "black", "< tail -n 1 ".filesPrefix."Barcelona.dat" u 2:3 w lp pt 7 lt rgb "black"

unset multiplot
