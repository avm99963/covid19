<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>COVID-19 sandbox</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
    body {
      font-family: 'Helvetica', 'Arial', sans-serif;
      padding-bottom: 200px;
    }

    .note {
      width: calc(100% - 32px);
      padding: 16px;
      margin-bottom: 16px;
      border-radius: 4px;
      background: #FFEB3B;
      box-shadow: 0 1px 3px 0px rgba(0, 0, 0, .6);

      font-size: 13px;
      line-height: 1.4;
    }

    .note p:first-child {
      margin-top: 0;
    }

    .note p:last-child {
      margin-bottom: 0;
    }

    .graphs {
      max-width: 100%;
    }

    .key-container {
      display: inline-block;
      position: fixed;
      bottom: 8px;
      right: 8px;
      padding: 8px;

      background: white;
      border-radius: 4px;
      box-shadow: 0 1px 3px 0px rgba(0, 0, 0, .3);
    }

    .key-container h3 {
      margin: 8px 0 12px 0;
    }

    .key {
      border-collapse: collapse;
    }

    .key td {
      border: solid 1px black;
      padding: 2px;
    }

    .risk {
      width: 40px;
    }

    .low-risk {
      background-color: #a0ff94;
    }

    .intermediate-risk {
      background-color: #dbff94;
    }

    .intermediate-high-risk {
      background-color: #ffe494;
    }

    .high-risk {
      background-color: #ff9494;
    }
    </style>
  </head>
  <body>
    <div class="note">
      <p><b>Nota</b>: La implementació que s'ha realitzat per calcular les dades podria ser incorrecta ja que no ha estat revisada per cap tercer, així que les gràfiques d'aquesta pàgina podrien ser incorrectes.
      <p>Les dades s'obtenen diretament de l'API de la Generalitat de Catalunya, però <a href="https://biocomsc.upc.edu/en/shared/delays_spain_30062020.pdf">segons el grup BIOCOMSC de la UPC</a>, les dades corresponents a l'última setmana no són fiables. Tot i així, es continuen graficant en aquesta pàgina totes les dades disponibles per tal de donar una fita inferior dels valors finals en les dades de l'última setmana.</p>
      <p>Es pot trobar el codi font complet del càlcul i generació de les gràfiques <a href="https://gerrit.avm99963.com/plugins/gitiles/covid19/+/refs/heads/master">aquí</a>.</p>
    </div>

    <img class="graphs" src="output/graph.svg">

    <div class="key-container">
      <h3>Llegenda</h3>
      <table class="key">
        <tr>
          <td class="risk low-risk"></td>
          <td>Risc baix</td>
        </tr>
        <tr>
          <td class="risk intermediate-risk"></td>
          <td>Risc mig</td>
        </tr>
        <tr>
          <td class="risk intermediate-high-risk"></td>
          <td>Risc mig-alt</td>
        </tr>
        <tr>
          <td class="risk high-risk"></td>
          <td>Risc alt</td>
        </tr>
      </table>
    </div>
  </body>
</html>
