set title graphTitle."\n{/*0.4 Última dada (punt negre): ".lastUpdated."}"
plot 6*x w filledcurve y1=0 lt rgb "#ff9494", 100/x w filledcurve y1=0 lt rgb "#ffe494", 70/x w filledcurve y1=0 lt rgb "#dbff94", 30/x w filledcurve y1=0 lt rgb "#a0ff94", graphDataFile u 2:3 w lp pt 6 lt rgb "black", "< tail -n 1 ".graphDataFile u 2:3 w lp pt 7 lt rgb "black"
