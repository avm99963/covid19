# covid-19
This is the code for https://covid-19.sandbox.avm99963.com, which contains graphs which determine the level of risk of each Catalan health area due to the COVID-19, based on the work of the [BIOCOMSC](https://biocomsc.upc.edu/en/covid-19/daily-report) group at the Polytechnic University of Catalonia (UPC).

It can also be used to generate risk graphs for custom areas by defining these areas in the `config/customAreas.php` file.

**DISCLAIMER**: The data shown in the website might be wrong due to a wrong implementation.

## Requirements
These programs should be installed in order to generate the graphs:

* PHP (at least version 7)
* gnuplot (at least version 5.2)

Optionally, if you want to serve the graphs publicly, you also need Apache2 or another web server.

## Installation
This software is meant to be used with Apache2 in order to serve a static website including the latest Covid-19 data.

To install it, follow these steps:

1. Clone this repo in a web directory by running `git clone "https://gerrit.avm99963.com/covid19"`.
2. Set up a cron script which sets the working directory to `covid19/cron` and runs the `bash generate.bash` command every day early in the morning.
   *** promo
   **Note:** For this, you can run `crontab -e` and place the following line at the end of the document: `0 2 * * * (cd /path/to/covid19/cron/ && bash generate.bash)`
   ***
3. *(Only if you're publishing the graphs with a web server)* If Apache2 doesn't have the `AllowOverride All` directive set, or you're using another web server, make sure the `cron` folder and its contents are not accessible from the Internet by denying access to it.

Each day, the `generate.bash` script will generate the graphs at the `covid19/output` folder.

*** promo
You can manually call the `bash generate.bash` command anytime from the `covid19/cron` directory in order to manually generate the graphs.
***

## Description of the different files
This is what each file does:

* `index.html`: a web accessible document which includes a disclaimer text, a key for the graphs, and the generated graphs themselves.
* `cron` folder: a non-web accessible folder which contains programs which ultimately generate the graphs.
* `cron/generate.bash`: a Bash script which orchestrates all the other programs in the folder in order to generate the graphs.
* `cron/generateData.php`: a PHP script which extracts the Covid-19 data from the *Generalitat de Catalunya*'s API and analyzes that data to generate the ρ<sub>7</sub> and IA<sub>14</sub> values needed by `cron/generateGraphs.gnu` to generate the graphs for each health area.
* `cron/generateGraphs.gnu`: a gnuplot script which generates the graphs with the data which has been provided by the `cron/generateData.php`. It uses the helper script `cron/plot.gnu`.
* `cron/generateCustomData.php`: a PHP script analogous to `cron/generateData.php` which generates the data for custom areas defined in `config/customAreas.php`.
* `cron/generateCustomGraph.gnu`: a PHP script analogous to `cron/generateGraphs.gnu` which generates the graph of a custom area using the data provided by the previous script.
* `config/config.php`: a file where general settings can be set.
* `config/customAreas.php`: a file where the custom areas can be defined.
* `output` folder: a folder created by the `generate.bash` script where the generated graphs are saved.
