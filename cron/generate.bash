#!/bin/bash
# Create the output folder if it doesn't exist
rm -rf ../output
mkdir -p ../output

# Generate graphs for the Catalonia health areas
php generateData.php
gnuplot generateGraphs.gnu
mv /tmp/covid19graphgenerator-output.png ../output/graph.png
mv /tmp/covid19graphgenerator-output.svg ../output/graph.svg

# Generate graphs for each custom area defined in
# config/customAreas.php
php generateCustomData.php
