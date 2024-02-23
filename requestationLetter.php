<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>requestationLetter</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      header {
        background-color: rgb(239, 239, 239);
        padding: 1vw;
        width: 100vw;
        height: 15vh;
        position: fixed;
        display: flex;
      }

      header img {
        height: 100%;
      }

      header input {
        /* align-self: center; */
        border: none;
        margin: auto 4% auto auto;
        padding: 1%;
        height: fit-content;
        background-color: rgb(252, 252, 252);
        font-size: 16px;
        border-radius: 12px;
      }

      header input:focus {
        /* background-color: red; */
        outline: none;
        /* border-bottom: 1px solid gray; */
        /* text-decoration: underline; */
        /* text-decoration-line: underline; */
      }

      aside {
        display: inline-block;
        background-color: #3e588f;
        color: #e3e8f8;
        width: 15vw;
        height: 85vh;
        margin-top: 15vh;
        position: fixed;
      }

      aside #profileInfo {
        /* background-color: red; */
        width: 100%;
        /* height: 32vh; */
        padding-top: 16%;
      }

      aside #profileInfo #profilePic {
        width: 48%;
        aspect-ratio: 1/1;
        margin: auto auto;
        background-image: url(Mayukh\ Baral.jpg);
        background-repeat: no-repeat;
        background-position: center top;
        background-size: 100%;
        border-radius: 50%;
      }

      aside #profileInfo #details {
        width: fit-content;
        /* background-color: gold; */
        color: #e3e8f8;
        margin: 8% auto 0;
        text-align: center;
      }

      aside #reportTemplatesContainer {
        background-color: #2f426b;
        margin-top: 8%;
      }
      aside #reportTemplatesContainer h3 {
        /* background-color: red; */
        padding: 4%;
        padding-left: 6%;
        border-bottom: 1px solid rgb(190, 177, 104);
      }

      aside #reportTemplatesContainer .reportTemplatesAside {
        /* background-color: red; */
        border-bottom: 1px solid #3e588f;
        padding: 2%;
        padding-left: 12%;
      }

      main {
        display: inline-block;
        background-color: #e3e8f8;
        margin-top: 15vh;
        margin-left: 15vw;
        width: 85vw;
        /* padding-top: 4vh; */
        /* padding: 2%; */
      }

      main section {
        background-color: whitesmoke;
        margin: 4% 6%;
        padding: 1%;
        border-radius: 8px;
        box-shadow: 4px 4px 8px 5px darkgrey;
      }

      main section .header {
        /* background-color: lightblue; */
        font-family: Cambria, Cochin, Georgia, Times, "Times New Roman", serif;
        padding: 1%;
        display: flex;
      }

      main section .header input {
        /* align-self: center; */
        border: none;
        margin: auto 4% auto auto;
        padding: 1%;
        height: fit-content;
        background-color: rgb(252, 252, 252);
        font-size: 16px;
        border-radius: 12px;
      }

      main section .header input:focus {
        /* background-color: red; */
        outline: none;
        /* border-bottom: 1px solid gray; */
        /* text-decoration: underline; */
        /* text-decoration-line: underline; */
      }

      main section .container {
        /* background-color: rgb(239, 239, 239); */
        background-color: #e3e8f8;
        padding: 1%;
        margin: 2% 1%;
        border-radius: 8px;
      }

      main section .container .month {
        /* background-color:cadetblue; */
        padding: 1%;
        font-family: Arial, Helvetica, sans-serif;
        border-bottom: 1px solid silver;
      }

      main section .boxContainer {
        /* background-color: lightgreen; */
        /* padding-top: 1%; */
        display: flex;
        /* flex-wrap:wrap; */
      }

      main section .boxContainer .box {
        background-color: #4e6eb2;
        color: #e3e8f8;
        padding: 2%;
        /* height: 100px; */
        margin: 1%;
        display: inline-block;
        transition: all 0.2s;
        cursor: pointer;
        border-radius: 8px;
        border: 1px solid silver;
        font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS",
          sans-serif;
      }
      main section .boxContainer .box:hover {
        background-color: whitesmoke;
        color: #2f426b;
        box-shadow: 2px 2px 8px 1px grey;
        /* transition: background-color, box-shadow 1s; */
      }

      main section .boxContainer table {
        background-color: #4e6eb2;
        font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS",
          sans-serif;
      }

      main section .container ul li {
        list-style: none;
        /* background-color:lightblue; */
        /* padding: 1%; */
        margin: 1%;
      }

      main section .container ul li label {
        /* background-color: aqua; */
        padding: 1%;
        font-family: Helvetica;
      }

      main section .container ul li input:hover {
        box-shadow: 1px 1px 1px 1px silver;
      }

      main section .container ul li label:hover {
        text-shadow: 1px 1px gray;
      }
    </style>
  </head>
  <body>
    <header>
      <img src="MediDocX Logo.JPG" alt="" />
      <input type="text" placeholder="Search Patient..." />
    </header>

    <aside>
      <div id="profileInfo">
        <div id="profilePic"></div>
        <div id="details">
          <b> Mayukh Baral </b><br />
          Doctor <br />
          ID: 54 <br />
          M.D. Cardiology <br />
          (TU, GMC, Nepal)
        </div>
      </div>
      <div id="reportTemplatesContainer">
        <h3>Patient Info</h3>
        <div class="reportTemplatesAside">Name: Bishal Koirala</div>
        <div class="reportTemplatesAside">Patient ID: 54</div>
        <div class="reportTemplatesAside">Age: 21</div>
      </div>
      <!-- <div id="reportTemplatesContainer">
        <h3>All Patients</h3>
        <div class="reportTemplatesAside">Mayukh Baral</div>
        <div class="reportTemplatesAside">Bishal Koirala</div>
        <div class="reportTemplatesAside">Sadikshya Banstola</div>
      </div> -->
    </aside>
    <main>
      <form action="">
        <section>
          <div class="header">
            <h2>BioChemistry</h2>
            <input type="text" placeholder="Search tests..." />
          </div>
          <div class="container">
            <ul>
              <li>
                <input type="checkbox" id="rbsFbsPpbs" /><label for="rbsFbsPpbs"
                  >RBS, FBS, PPBS</label
                >
              </li>
              <li>
                <input type="checkbox" id="lft" /><label for="lft">LFT</label>
              </li>
              <li>
                <input type="checkbox" id="rft" /><label for="rft">RFT</label>
              </li>
              <li>
                <input type="checkbox" id="lipidProfile" /><label
                  for="lipidProfile"
                  >Lipid Profile</label
                >
              </li>
              <li>
                <input type="checkbox" id="ca++" /><label for="ca++"
                  >Ca++</label
                >
              </li>
              <li>
                <input type="checkbox" id="mg++" /><label for="mg++"
                  >Mg++</label
                >
              </li>
              <li>
                <input type="checkbox" id="phosphorous" /><label
                  for="phosphorous"
                  >Phophorous</label
                >
              </li>
              <li>
                <input type="checkbox" id="uricAcid" /><label for="uricAcid"
                  >Uric Acid</label
                >
              </li>
              <li>
                <input type="checkbox" id="cpk-mb" /><label for="cpk-mb"
                  >CPK-MB</label
                >
              </li>
              <li>
                <input type="checkbox" id="cpk-nac" /><label for="cpk-nac"
                  >CPL-NAC</label
                >
              </li>
              <li>
                <input type="checkbox" id="ironProfile" /><label
                  for="ironProfile"
                  >Iron Profile</label
                >
              </li>
            </ul>
          </div>
        </section>

        <section>
          <div class="header">
            <h2>Haematology</h2>
            <input type="text" placeholder="Search tests..." />
          </div>
          <div class="container">
            <ul>
              <li>
                <input type="checkbox" id="cbc" /><label for="cbc">CBC</label>
              </li>
              <li>
                <input type="checkbox" id="esr" /><label for="esr">ESR</label>
              </li>
              <li>
                <input type="checkbox" id="bloodGrouping" /><label
                  for="bloodGrouping"
                  >Blood Grouping</label
                >
              </li>
              <li>
                <input type="checkbox" id="pbs" /><label for="pbs">PBS</label>
              </li>
              <li>
                <input type="checkbox" id="retics" /><label for="retics"
                  >Retics</label
                >
              </li>
              <li>
                <input type="checkbox" id="bt.ct" /><label for="bt.ct"
                  >BT. CT</label
                >
              </li>
              <li>
                <input type="checkbox" id="ptInr" /><label for="prInr"
                  >PT | INR</label
                >
              </li>
              <li>
                <input type="checkbox" id="aptt" /><label for="aptt"
                  >APTT</label
                >
              </li>
              <li>
                <input type="checkbox" id="aec" /><label for="aec">AEC</label>
              </li>
              <li>
                <input type="checkbox" id="abc" /><label for="abc">ABC</label>
              </li>
              <li>
                <input type="checkbox" id="anc" /><label for="anc">ANC</label>
              </li>
              <li>
                <input type="checkbox" id="d-dimer" /><label for="d-dimer"
                  >D - Dimer</label
                >
              </li>
            </ul>
          </div>
        </section>

        <section>
          <div class="header">
            <h2>Bacteriology</h2>
            <input type="text" placeholder="Search tests..." />
          </div>
          <div class="container">
            <ul>
              <li>
                <input type="checkbox" id="gramStain" /><label for="gramStain"
                  >Gram Stain</label
                >
              </li>
              <li>
                <input type="checkbox" id="afbStain" /><label for="afbStain"
                  >AFB Stain</label
                >
              </li>
              <li>
                <input type="checkbox" id="bloodCls" /><label for="bloodCls"
                  >Blood cls</label
                >
              </li>
              <li>
                <input type="checkbox" id="urineCls" /><label for="urineCls"
                  >Urine cls</label
                >
              </li>
              <li>
                <input type="checkbox" id="pusCls" /><label for="pusCls"
                  >Pus cls</label
                >
              </li>
            </ul>
          </div>
        </section>

        <section>
          <div class="header">
            <h2>Mycology</h2>
            <input type="text" placeholder="Search tests..." />
          </div>
          <div class="container">
            <ul>
              <li>
                <input type="checkbox" id="kohMount" /><label for="kohMount"
                  >KOH Mount</label
                >
              </li>
            </ul>
          </div>
        </section>

        <section>
          <div class="header">
            <h2>Virology</h2>
            <input type="text" placeholder="Search tests..." />
          </div>
          <div class="container">
            <ul>
              <li>
                <input type="checkbox" id="hivHcvHbsagVdrl" /><label
                  for="hivHcvHbsagVdrl"
                  >HIV, HCV, HbsAg, VDRL</label
                >
              </li>
              <li>
                <input type="checkbox" id="havHev" /><label for="havHev"
                  >HAV, HEV</label
                >
              </li>
            </ul>
          </div>
        </section>

        <section>
          <div class="header">
            <h2>Tumar Markers</h2>
            <input type="text" placeholder="Search tests..." />
          </div>
          <div class="container">
            <ul>
              <li>
                <input type="checkbox" id="afp" /><label for="afp">AFP</label>
              </li>
              <li>
                <input type="checkbox" id="ca-125" /><label for="ca-125"
                  >CA - 125</label
                >
              </li>
              <li>
                <input type="checkbox" id="cea" /><label for="cea">CEA</label>
              </li>
              <li>
                <input type="checkbox" id="ca19.4" /><label for="ca19.4"
                  >CA 19.4</label
                >
              </li>
              <li>
                <input type="checkbox" id="ca72.4" /><label for="ca72.4"
                  >CA 72.4</label
                >
              </li>
              <li>
                <input type="checkbox" id="psa" /><label for="psa">PSA</label>
              </li>
            </ul>
          </div>
        </section>

        <section>
          <div class="header">
            <h2>Parasitology</h2>
            <input type="text" placeholder="Search tests..." />
          </div>
          <div class="container">
            <ul>
              <li>
                <input type="checkbox" id="stoolRie" /><label for="stoolRie"
                  >Stool RIE</label
                >
              </li>
              <li>
                <input type="checkbox" id="urineRie" /><label for="urineRie"
                  >Urine RIE</label
                >
              </li>
              <li>
                <input type="checkbox" id="stoolObt" /><label for="stoolObt"
                  >Stool OBT</label
                >
              </li>
              <li>
                <input type="checkbox" id="bence-sonesProtein" /><label
                  for="bence-sonesProtein"
                  >Bence - sones protein</label
                >
              </li>
              <li>
                <input type="checkbox" id="bilePigmentInUrine" /><label
                  for="bilePigmentInUrine"
                  >Bile pigment in urine</label
                >
              </li>
            </ul>
          </div>
        </section>

        <section>
          <div class="header">
            <h2>Cytology</h2>
            <input type="text" placeholder="Search tests..." />
          </div>
          <div class="container">
            <ul>
              <li>
                <input type="checkbox" id="papSmear" /><label for="papSmear"
                  >PAP Smear</label
                >
              </li>
              <li>
                <input type="checkbox" id="fnac" /><label for="fnac"
                  >FNAC</label
                >
              </li>
              <li>
                <input type="checkbox" id="bodyFluid" /><label for="bodyFluid"
                  >Body Fluid</label
                >
              </li>
            </ul>
          </div>
        </section>

        <section>
          <div class="header">
            <h2>Hormone Assays</h2>
            <input type="text" placeholder="Search tests..." />
          </div>
          <div class="container">
            <ul>
              <li>
                <input type="checkbox" id="tft" /><label for="tft">TFT</label>
              </li>
              <li>
                <input type="checkbox" id="growthHormone" /><label
                  for="growthHormone"
                  >Growth Hormone</label
                >
              </li>
              <li>
                <input type="checkbox" id="fertilityProfile" /><label
                  for="fertilityProfile"
                  >Fertility Profile</label
                >
              </li>
              <li>
                <input type="checkbox" id="vit-d" /><label for="vit-d"
                  >Vit - D</label
                >
              </li>
              <li>
                <input type="checkbox" id="vitB12" /><label for="vitB12"
                  >Vit B12</label
                >
              </li>
              <li>
                <input type="checkbox" id="anti-tpo" /><label for="anti-tpo"
                  >Anti - TPO</label
                >
              </li>
              <li>
                <input type="checkbox" id="b-Hcg" /><label for="b-Hcg"
                  >B - HCG</label
                >
              </li>
              <li>
                <input type="checkbox" id="folicAcid" /><label for="folicAcid"
                  >Folic Acid</label
                >
              </li>
              <li>
                <input type="checkbox" id="cortisol" /><label for="cortisol"
                  >Cortisol</label
                >
              </li>
              <li>
                <input type="checkbox" id="quadrupleTest" /><label
                  for="quadrupleTest"
                  >Quadruple Test</label
                >
              </li>
            </ul>
          </div>
        </section>

        <section>
          <div class="header">
            <h2>Immunology</h2>
            <input type="text" placeholder="Search tests..." />
          </div>
          <div class="container">
            <ul>
              <li>
                <input type="checkbox" id="upt" /><label for="upt">UPT</label>
              </li>
              <li>
                <input type="checkbox" id="aso" /><label for="aso">ASO</label>
              </li>
              <li>
                <input type="checkbox" id="tpha" /><label for="tpha"
                  >TPHA</label
                >
              </li>
              <li>
                <input type="checkbox" id="ana" /><label for="ana">ANA</label>
              </li>
              <li>
                <input type="checkbox" id="anti-dsDNA" /><label for="anti-dsDNA"
                  >Anti -ds DNA</label
                >
              </li>
              <li>
                <input type="checkbox" id="rprvdrl" /><label for="rprvdrl"
                  >RPR | VDRL</label
                >
              </li>
              <li>
                <input type="checkbox" id="antiCcp" /><label for="antiCcp"
                  >Anti CCP</label
                >
              </li>
              <li>
                <input type="checkbox" id="hPylori" /><label for="hPylori"
                  >H. Pylori Ag, Ab</label
                >
              </li>
              <li>
                <input type="checkbox" id="torchProfile" /><label
                  for="torchProfile"
                  >Torch Profile</label
                >
              </li>
            </ul>
          </div>
        </section>
        <button type="submit">Save</button>
      </form>
    </main>

    <script></script>
  </body>
</html>
