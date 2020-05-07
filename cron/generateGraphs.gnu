filesPrefix = '/tmp/covid19graphgenerator-'

set terminal svg size 1200, 1200
set output '/tmp/covid19graphgenerator-output.svg'

set pointsize 0.75
load "plot.gnu"

set terminal png size 1600, 1600
set output '/tmp/covid19graphgenerator-output.png'

set pointsize 1
load "plot.gnu"
