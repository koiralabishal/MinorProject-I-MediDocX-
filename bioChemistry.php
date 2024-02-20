<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BioChemistry</title>
    <style>
      div {
        width: 100px;
        height: 100px;
        background-color: red;
      }
    </style>
  </head>
  <body>
    <h1>BIOCHEMISTRY</h1>
    <table id="table">
      <tr>
        <td>TEST</td>
        <td>RESULT</td>
        <td>REFERENCE RANGE</td>
        <td>METHOD</td>
      </tr>
      <tr>
        <td></td>
      </tr>
      <tr>
        <td>BLOOD GLUCOSE RANDOM</td>
        <td><input type="" /></td>
        <td><input type="" /></td>
        <td><input type="" /></td>
      </tr>
      <tr>
        <td>SERUM CREATININE</td>
        <td><input type="" /></td>
        <td><input type="" /></td>
        <td><input type="" /></td>
      </tr>
      <tr>
        <td>SODIUM (Na)</td>
        <td><input type="" /></td>
        <td><input type="" /></td>
        <td><input type="" /></td>
      </tr>
      <tr>
        <td>POTASSIUM (K)</td>
        <td><input type="" /></td>
        <td><input type="" /></td>
        <td><input type="" /></td>
      </tr>
    </table>
    <button type="submit" id="add" onclick="add()">Save</button>
  </body>
  <script>
    function add() {
      console.log("Start");

      if (document.getElementById("newId")) {
        console.log("Clicked on Button");
        document.getElementById("newId").remove();
      } else {
        const saved = document.createElement("div");
        saved.className = "newClass";
        saved.setAttribute("id", "newId");

        const msg = document.createTextNode("Saved");
        saved.appendChild(msg);
        document.body.insertBefore(saved, document.getElementById("add"));
        // document.getElementById("add").appendChild(saved);
      }

      if ((saved = document.getElementById("newId"))) {
        saved.addEventListener("click", function (event) {
          event.stopPropagation();
          document.getElementById("newId").remove();
          console.log('Clicked on div');
        });
      }

      // console.log(saved);
      console.log("End");
    }
  </script>
</html>
