#!/bin/bash
php generateData.php
gnuplot generateGraphs.gnu
mkdir -p ../output
mv /tmp/covid19graphgenerator-output.png ../output/graph.png
mv /tmp/covid19graphgenerator-output.svg ../output/graph.svg
