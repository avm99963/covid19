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
