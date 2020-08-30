num = system("cat ".graphDataFile." | wc -l")

startGray = 0;
endGray = 0.5;

set palette model RGB functions startGray + (endGray - startGray)*(1 - gray), startGray + (endGray - startGray)*(1 - gray), startGray + (endGray - startGray)*(1 - gray)
set cbrange [0:(num - 1)]
unset colorbox

set title graphTitle."\n{/*0.4 Última dada (punt blau): ".lastUpdated."}"
plot 6*x w filledcurve y1=0 lt rgb "#ff9494", 100/x w filledcurve y1=0 lt rgb "#ffe494", 70/x w filledcurve y1=0 lt rgb "#dbff94", 30/x w filledcurve y1=0 lt rgb "#a0ff94", graphDataFile u 2:3:4 w lp lc palette pt 2 ps 0.5, "< tail -n 1 ".graphDataFile u 2:3 w lp pt 7 ps 0.7 lt rgb "#002991"
