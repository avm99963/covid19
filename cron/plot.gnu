set xlabel "Casos actius per 10^5 habitants"
set ylabel "Mitjana taxa de creixement darrers 7 dies"
set title font "Helvetica,20"

set xrange[0:410]
set yrange[0:5]
set samples 400
#unset colorbox

set multiplot layout 3,3
set key off
set tics out scale 0.5,0.2

min(a, b) = (a < b ? a : b)

# The different colored areas correspond to the classification of the EPG values defined on page 8 at https://biocomsc.upc.edu/en/shared/20200506_report_web_51.pdf

lastUpdated = system("tail -n 1 ".filesPrefix."TerresDeLEbre.dat | awk '{print $1;}'")
set title "Terres de l'Ebre\n{/*0.4 Última dada (punt negre): ".lastUpdated."}"
plot 6*x w filledcurve y1=0 lt rgb "#ff9494", 100/x w filledcurve y1=0 lt rgb "#ffe494", 70/x w filledcurve y1=0 lt rgb "#dbff94", 30/x w filledcurve y1=0 lt rgb "#a0ff94", filesPrefix.'TerresDeLEbre.dat' u 2:3 w lp pt 6 lt rgb "black", "< tail -n 1 ".filesPrefix."TerresDeLEbre.dat" u 2:3 w lp pt 7 lt rgb "black"

lastUpdated = system("tail -n 1 ".filesPrefix."CampDeTarragona.dat | awk '{print $1;}'")
set title "Camp de Tarragona\n{/*0.4 Última dada (punt negre): ".lastUpdated."}"
plot 6*x w filledcurve y1=0 lt rgb "#ff9494", 100/x w filledcurve y1=0 lt rgb "#ffe494", 70/x w filledcurve y1=0 lt rgb "#dbff94", 30/x w filledcurve y1=0 lt rgb "#a0ff94", filesPrefix.'CampDeTarragona.dat' u 2:3 w lp pt 6 lt rgb "black", "< tail -n 1 ".filesPrefix."CampDeTarragona.dat" u 2:3 w lp pt 7 lt rgb "black"

lastUpdated = system("tail -n 1 ".filesPrefix."AltPirineuAran.dat | awk '{print $1;}'")
set title "Alt Pirineu, Aran\n{/*0.4 Última dada (punt negre): ".lastUpdated."}"
plot 6*x w filledcurve y1=0 lt rgb "#ff9494", 100/x w filledcurve y1=0 lt rgb "#ffe494", 70/x w filledcurve y1=0 lt rgb "#dbff94", 30/x w filledcurve y1=0 lt rgb "#a0ff94", filesPrefix.'AltPirineuAran.dat' u 2:3 w lp pt 6 lt rgb "black", "< tail -n 1 ".filesPrefix."AltPirineuAran.dat" u 2:3 w lp pt 7 lt rgb "black"

lastUpdated = system("tail -n 1 ".filesPrefix."Lleida.dat | awk '{print $1;}'")
set title "Lleida\n{/*0.4 Última dada (punt negre): ".lastUpdated."}"
plot 6*x w filledcurve y1=0 lt rgb "#ff9494", 100/x w filledcurve y1=0 lt rgb "#ffe494", 70/x w filledcurve y1=0 lt rgb "#dbff94", 30/x w filledcurve y1=0 lt rgb "#a0ff94", filesPrefix.'Lleida.dat' u 2:3 w lp pt 6 lt rgb "black", "< tail -n 1 ".filesPrefix."Lleida.dat" u 2:3 w lp pt 7 lt rgb "black"

lastUpdated = system("tail -n 1 ".filesPrefix."Girona.dat | awk '{print $1;}'")
set title "Girona\n{/*0.4 Última dada (punt negre): ".lastUpdated."}"
plot 6*x w filledcurve y1=0 lt rgb "#ff9494", 100/x w filledcurve y1=0 lt rgb "#ffe494", 70/x w filledcurve y1=0 lt rgb "#dbff94", 30/x w filledcurve y1=0 lt rgb "#a0ff94", filesPrefix.'Girona.dat' u 2:3 w lp pt 6 lt rgb "black", "< tail -n 1 ".filesPrefix."Girona.dat" u 2:3 w lp pt 7 lt rgb "black"

lastUpdated = system("tail -n 1 ".filesPrefix."CatalunyaCentral.dat | awk '{print $1;}'")
set title "Catalunya central\n{/*0.4 Última dada (punt negre): ".lastUpdated."}"
plot 6*x w filledcurve y1=0 lt rgb "#ff9494", 100/x w filledcurve y1=0 lt rgb "#ffe494", 70/x w filledcurve y1=0 lt rgb "#dbff94", 30/x w filledcurve y1=0 lt rgb "#a0ff94", filesPrefix.'CatalunyaCentral.dat' u 2:3 w lp pt 6 lt rgb "black", "< tail -n 1 ".filesPrefix."CatalunyaCentral.dat" u 2:3 w lp pt 7 lt rgb "black"

lastUpdated = system("tail -n 1 ".filesPrefix."BarcelonaCiutat.dat | awk '{print $1;}'")
set title "Barcelona Ciutat\n{/*0.4 Última dada (punt negre): ".lastUpdated."}"
plot 6*x w filledcurve y1=0 lt rgb "#ff9494", 100/x w filledcurve y1=0 lt rgb "#ffe494", 70/x w filledcurve y1=0 lt rgb "#dbff94", 30/x w filledcurve y1=0 lt rgb "#a0ff94", filesPrefix.'BarcelonaCiutat.dat' u 2:3 w lp pt 6 lt rgb "black", "< tail -n 1 ".filesPrefix."BarcelonaCiutat.dat" u 2:3 w lp pt 7 lt rgb "black"

lastUpdated = system("tail -n 1 ".filesPrefix."MetropolitaSud.dat | awk '{print $1;}'")
set title "Metropolità Sud\n{/*0.4 Última dada (punt negre): ".lastUpdated."}"
plot 6*x w filledcurve y1=0 lt rgb "#ff9494", 100/x w filledcurve y1=0 lt rgb "#ffe494", 70/x w filledcurve y1=0 lt rgb "#dbff94", 30/x w filledcurve y1=0 lt rgb "#a0ff94", filesPrefix.'MetropolitaSud.dat' u 2:3 w lp pt 6 lt rgb "black", "< tail -n 1 ".filesPrefix."MetropolitaSud.dat" u 2:3 w lp pt 7 lt rgb "black"

lastUpdated = system("tail -n 1 ".filesPrefix."MetropolitaNord.dat | awk '{print $1;}'")
set title "Metropolità Nord\n{/*0.4 Última dada (punt negre): ".lastUpdated."}"
plot 6*x w filledcurve y1=0 lt rgb "#ff9494", 100/x w filledcurve y1=0 lt rgb "#ffe494", 70/x w filledcurve y1=0 lt rgb "#dbff94", 30/x w filledcurve y1=0 lt rgb "#a0ff94", filesPrefix.'MetropolitaNord.dat' u 2:3 w lp pt 6 lt rgb "black", "< tail -n 1 ".filesPrefix."MetropolitaNord.dat" u 2:3 w lp pt 7 lt rgb "black"

unset multiplot
