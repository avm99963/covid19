name = ARG1
codeName = ARG2
fileName = ARG3

filesPrefix = '/tmp/covid19graphgenerator-'

set terminal svg size 500, 500
set output '/tmp/covid19graphgenerator-area-'.codeName.'-graph.svg'

set pointsize 0.75
load "includes/plotCustomGraph.gnu"

set terminal png size 500, 500
set output '/tmp/covid19graphgenerator-area-'.codeName.'-graph.png'

set pointsize 1
load "includes/plotCustomGraph.gnu"
