<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['doctorEmail'])) {
  header('Location:index.php');
}


if (!isset($_SESSION['patientID'], $_SESSION['age'], $_SESSION['gender'])) {
  header('Location:labTechnician.php');
}



$email = $_SESSION['doctorEmail'];
$patientName = $_SESSION['patientName'];
$patientID = $_SESSION['patientID'];
$patientage = $_SESSION['age'];
$patientgender = $_SESSION['gender'];
// $visitID = $_SESSION['visitID'];
// $patientName = $_GET['patientName'];
// $patientID = $_GET['patientID'];
// $patientage = $_GET['age'];
// $patientgender = $_GET['gender'];
$date = $_SESSION['date'];
$sqlVisitID = "SELECT visitID FROM patientVisitDetails WHERE date = '$date'";
$resultVisitID = mysqli_query($conn, $sqlVisitID);

if ($resultVisitID) {
    $rowVisitID = mysqli_fetch_assoc($resultVisitID);
}



$sql = "SELECT * FROM hospital WHERE email = '{$email}' AND userType ='Doctor'";
// $sql2 = "SELECT a.* FROM appointed_patient a JOIN hospital h on a.DoctorID = h.doctorID WHERE h.email = '{$email}' ORDER BY a.ID DESC ";

$result = mysqli_query($conn, $sql);
// $result2 = mysqli_query($conn, $sql2);

if ($result) {
  $row = mysqli_fetch_assoc($result);
}

// if ($result2) {
//   $row2 = mysqli_fetch_assoc($result2);
// }
// session_start();
?>

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
        <b>
          <?php echo $row['name']; ?>
        </b><br />
        <?php echo $row['userType']; ?> <br />
        ID:
        <?php echo $row['doctorID']; ?> <br />
        <?php echo $row['doctorQualification']; ?> <br />
        (
        <?php echo $row['universityCollageCountry']; ?>)
      </div>
    </div>
    <div id="reportTemplatesContainer">
      <h3>Patient Info</h3>
      <div class="reportTemplatesAside">Name:
        <?php echo $patientName; ?>
      </div>
      <div class="reportTemplatesAside">Patient ID:
        <?php echo $patientID; ?>
      </div>
      <div class="reportTemplatesAside">Age:
        <?php echo $patientage; ?>
      </div>
      <div class="reportTemplatesAside">Gender:
        <?php echo $patientgender; ?>
      </div>
    </div>
    <!-- <div id="reportTemplatesContainer">
        <h3>All Patients</h3>
        <div class="reportTemplatesAside">Mayukh Baral</div>
        <div class="reportTemplatesAside">Bishal Koirala</div>
        <div class="reportTemplatesAside">Sadikshya Banstola</div>
      </div> -->
  </aside>
  <main>
    <form action="requestationLetter.php" method="POST">
      <section>
        <div class="header">
          <h2>BioChemistry</h2>
          <input type="text" placeholder="Search tests..." />
        </div>
        <div class="container">
          <ul>
            <li>
              <input type="checkbox" id="rbs" name="BioChemistry[]" value="RBS" /><label
                for="rbs">RBS</label>
            </li>
            <li>
              <input type="checkbox" id="Fbs" name="BioChemistry[]" value="FBS" /><label
                for="fbs">FBS</label>
            </li>
            <li>
              <input type="checkbox" id="ppbs" name="BioChemistry[]" value="PPBS" /><label
                for="ppbs">
                PPBS</label>
            </li>
            <li>
              <input type="checkbox" id="totalBilirubin" name="BioChemistry[]" value="Total Bilirubin" /><label for="totalBilirubin">Total Bilirubin</label>
            </li>
            <li>
              <input type="checkbox" id="alt" name="BioChemistry[]" value="ALT" /><label for="alt">ALT</label>
            </li>
            <li>
              <input type="checkbox" id="ast" name="BioChemistry[]" value="AST" /><label for="ast">AST</label>
            </li>
            <li>
              <input type="checkbox" id="urea" name="BioChemistry[]" value="Urea" /><label for="urea">Urea</label>
            </li>
            <li>
              <input type="checkbox" id="serumCreatinine" name="BioChemistry[]" value="Serum Creatinine" /><label for="serumCreatinine">Serum Creatinine</label>
            </li>
            <li>
              <input type="checkbox" id="eGFR" name="BioChemistry[]" value="eGFR" /><label for="eGFR">eGFR</label>
            </li>
            <li>
              <input type="checkbox" id="totalCholesterol" name="BioChemistry[]" value="Total Cholesterol" /><label
                for="totalCholesterol">Total Cholesterol</label>
            </li>
            <li>
            <li>
              <input type="checkbox" id="triglycerides" name="BioChemistry[]" value="Triglycerides" /><label
                for="triglycerides">Triglycerides</label>
            </li>
            <li>
              <input type="checkbox" id="hdlCholesterol" name="BioChemistry[]" value="HDL Cholesterol" /><label
                for="hdlCholesterol">HDL Cholesterol</label>
            </li>
            <li>
              <input type="checkbox" id="ldlCholesterol" name="BioChemistry[]" value="LDL Cholesterol" /><label
                for="ldlCholesterol">LDL Cholesterol</label>
            </li>
            <li>
              <input type="checkbox" id="ca++" name="BioChemistry[]" value="Ca++" /><label for="ca++">Ca++</label>
            </li>
            <li>
              <input type="checkbox" id="mg++" name="BioChemistry[]" value="Mg++" /><label for="mg++">Mg++</label>
            </li>
            <li>
              <input type="checkbox" id="phosphorous" name="BioChemistry[]" value="Phosphorus" /><label
                for="phosphorous">Phophorous</label>
            </li>
            <li>
              <input type="checkbox" id="uricAcid" name="BioChemistry[]" value="Uric Acid" /><label for="uricAcid">Uric
                Acid</label>
            </li>
            <li>
              <input type="checkbox" id="cpk-mb" name="BioChemistry[]" value="CPK - MB" /><label
                for="cpk-mb">CPK-MB</label>
            </li>
            <li>
              <input type="checkbox" id="cpk-nac" name="BioChemistry[]" value="CPL - NAC" /><label
                for="cpk-nac">CPL-NAC</label>
            </li>
            <li>
              <input type="checkbox" id="serumIron" name="BioChemistry[]" value="Serum Iron" /><label
                for="serumIron">Serum Iron</label>
            </li>
            <li>
              <input type="checkbox" id="tibc" name="BioChemistry[]" value="TIBC" /><label
                for="tibc">TIBC</label>
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
              <input type="checkbox" id="hb" name="Haematology[]" value="Hb" /><label for="hb">Hb</label>
            </li>
            <li>
              <input type="checkbox" id="tlc" name="Haematology[]" value="TLC" /><label for="tlc">TLC</label>
            </li>
            <li>
              <input type="checkbox" id="plateletCount" name="Haematology[]" value="Platelet Count" /><label for="plateletCount">Platelet Count</label>
            </li>
            <li>
              <input type="checkbox" id="esr" name="Haematology[]" value="ESR" /><label for="esr">ESR</label>
            </li>
            <li>
              <input type="checkbox" id="bloodGrouping" name="Haematology[]" value="Blood Grouping" /><label
                for="bloodGrouping">Blood
                Grouping</label>
            </li>
            <li>
              <input type="checkbox" id="pbs" name="Haematology[]" value="PBS" /><label for="pbs">PBS</label>
            </li>
            <li>
              <input type="checkbox" id="retics" name="Haematology[]" value="Retics" /><label
                for="retics">Retics</label>
            </li>
            <li>
              <input type="checkbox" id="bt" name="Haematology[]" value="BT" /><label for="bt">BT</label>
            </li>
            <li>
              <input type="checkbox" id="ct" name="Haematology[]" value="CT" /><label for="ct">CT</label>
            </li>
            <li>
              <input type="checkbox" id="pt" name="Haematology[]" value="PT" /><label for="pt">PT</label>
            </li>
            <li>
              <input type="checkbox" id="inr" name="Haematology[]" value="INR" /><label for="Inr">INR</label>
            </li>
            <li>
              <input type="checkbox" id="aptt" name="Haematology[]" value="APTT" /><label for="aptt">APTT</label>
            </li>
            <li>
              <input type="checkbox" id="aec" name="Haematology[]" value="AEC" /><label for="aec">AEC</label>
            </li>
            <li>
              <input type="checkbox" id="abc" name="Haematology[]" value="ABC" /><label for="abc">ABC</label>
            </li>
            <li>
              <input type="checkbox" id="anc" name="Haematology[]" value="ANC" /><label for="anc">ANC</label>
            </li>
            <li>
              <input type="checkbox" id="d-dimer" name="Haematology[]" value="D-Dimer" /><label for="d-dimer">D-Dimer</label>
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
              <input type="checkbox" id="gramStain" name="Bacteriology[]" value="Gram Stain" /><label
                for="gramStain">Gram Stain</label>
            </li>
            <li>
              <input type="checkbox" id="afbStain" name="Bacteriology[]" value="AFB Stain" /><label for="afbStain">AFB
                Stain</label>
            </li>
            <li>
              <input type="checkbox" id="bloodCls" name="Bacteriology[]" value="Blood cls" /><label for="bloodCls">Blood
                cls</label>
            </li>
            <li>
              <input type="checkbox" id="urineCls" name="Bacteriology[]" value="Urine cls" /><label for="urineCls">Urine
                cls</label>
            </li>
            <li>
              <input type="checkbox" id="pusCls" name="Bacteriology[]" value="Pus cls" /><label for="pusCls">Pus
                cls</label>
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
              <input type="checkbox" id="kohMount" name="Mycology[]" value="KOH Mount" /><label for="kohMount">KOH
                Mount</label>
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
              <input type="checkbox" id="hivHcvHbsagVdrl" name="Virology[]" value="HIV, HCV, HbsAg, VDRL" /><label
                for="hivHcvHbsagVdrl">HIV,
                HCV, HbsAg, VDRL</label>
            </li>
            <li>
              <input type="checkbox" id="havHev" name="Virology[]" value="HAV, HEV" /><label for="havHev">HAV,
                HEV</label>
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
              <input type="checkbox" id="afp" name="TumarMarkers[]" value="AFP" /><label for="afp">AFP</label>
            </li>
            <li>
              <input type="checkbox" id="ca-125" name="TumarMarkers[]" value="CA - 125" /><label for="ca-125">CA -
                125</label>
            </li>
            <li>
              <input type="checkbox" id="cea" name="TumarMarkers[]" value="CEA" /><label for="cea">CEA</label>
            </li>
            <li>
              <input type="checkbox" id="ca19.4" name="TumarMarkers[]" value="CA 19.4" /><label for="ca19.4">CA
                19.4</label>
            </li>
            <li>
              <input type="checkbox" id="ca72.4" name="TumarMarkers[]" value="CA 72.4" /><label for="ca72.4">CA
                72.4</label>
            </li>
            <li>
              <input type="checkbox" id="psa" name="TumarMarkers[]" value="PSA" /><label for="psa">PSA</label>
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
              <input type="checkbox" id="stoolRie" name="Parasitology[]" value="Stool RIE" /><label for="stoolRie">Stool
                RIE</label>
            </li>
            <li>
              <input type="checkbox" id="urineRie" name="Parasitology[]" value="Urine RIE" /><label for="urineRie">Urine
                RIE</label>
            </li>
            <li>
              <input type="checkbox" id="stoolObt" name="Parasitology[]" value="Stool OBT" /><label for="stoolObt">Stool
                OBT</label>
            </li>
            <li>
              <input type="checkbox" id="bence-sonesProtein" name="Parasitology[]"
                value="Bence - sones protein" /><label for="bence-sonesProtein">Bence
                - sones protein</label>
            </li>
            <li>
              <input type="checkbox" id="bilePigmentInUrine" name="Parasitology[]"
                value="Bile pigment in urine" /><label for="bilePigmentInUrine">Bile
                pigment in urine</label>
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
              <input type="checkbox" id="papSmear" name="Cytology[]" /><label for="papSmear" value="PAP Smear">PAP
                Smear</label>
            </li>
            <li>
              <input type="checkbox" id="fnac" name="Cytology[]" value="FNAC" /><label for="fnac">FNAC</label>
            </li>
            <li>
              <input type="checkbox" id="bodyFluid" name="Cytology[]" value="Body Fluid" /><label for="bodyFluid">Body
                Fluid</label>
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
              <input type="checkbox" id="tft" name="HormoneAssays[]" value="TFT" /><label for="tft">TFT</label>
            </li>
            <li>
              <input type="checkbox" id="growthHormone" name="HormoneAssays[]" value="Growth Hormone" /><label
                for="growthHormone">Growth
                Hormone</label>
            </li>
            <li>
              <input type="checkbox" id="fertilityProfile" name="HormoneAssays[]" value="Fertility Profile" /><label
                for="fertilityProfile">Fertility Profile</label>
            </li>
            <li>
              <input type="checkbox" id="vit-d" name="HormoneAssays[]" value="Vit -D" /><label for="vit-d">Vit -
                D</label>
            </li>
            <li>
              <input type="checkbox" id="vitB12" name="HormoneAssays[]" value="Vit B12" /><label for="vitB12">Vit
                B12</label>
            </li>
            <li>
              <input type="checkbox" id="anti-tpo" name="HormoneAssays[]" value="Anti - TPO" /><label
                for="anti-tpo">Anti - TPO</label>
            </li>
            <li>
              <input type="checkbox" id="b-Hcg" name="HormoneAssays[]" value="B -HCG" /><label for="b-Hcg">B -
                HCG</label>
            </li>
            <li>
              <input type="checkbox" id="folicAcid" name="HormoneAssays[]" value="Folic Acid" /><label
                for="folicAcid">Folic Acid</label>
            </li>
            <li>
              <input type="checkbox" id="cortisol" name="HormoneAssays[]" value="Cortisol" /><label
                for="cortisol">Cortisol</label>
            </li>
            <li>
              <input type="checkbox" id="quadrupleTest" name="HormoneAssays[]" value="Quadruple Test" /><label
                for="quadrupleTest">Quadruple
                Test</label>
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
              <input type="checkbox" id="upt" name="Immunology[]" value="UPT" /><label for="upt">UPT</label>
            </li>
            <li>
              <input type="checkbox" id="aso" name="Immunology[]" value="ASO" /><label for="aso">ASO</label>
            </li>
            <li>
              <input type="checkbox" id="tpha" name="Immunology[]" value="TPHA" /><label for="tpha">TPHA</label>
            </li>
            <li>
              <input type="checkbox" id="ana" name="Immunology[]" value="ANA" /><label for="ana">ANA</label>
            </li>
            <li>
              <input type="checkbox" id="anti-dsDNA" name="Immunology[]" value="Anti -ds DNA" /><label
                for="anti-dsDNA">Anti -ds DNA</label>
            </li>
            <li>
              <input type="checkbox" id="rprvdrl" name="Immunology[]" value="RPR | VDRL" /><label for="rprvdrl">RPR |
                VDRL</label>
            </li>
            <li>
              <input type="checkbox" id="antiCcp" name="Immunology[]" value="Anti CCP" /><label for="antiCcp">Anti
                CCP</label>
            </li>
            <li>
              <input type="checkbox" id="hPylori" name="Immunology[]" value="H. Pylori Ag, Ab" /><label for="hPylori">H.
                Pylori Ag, Ab</label>
            </li>
            <li>
              <input type="checkbox" id="torchProfile" name="Immunology[]" value="Torch Profile" /><label
                for="torchProfile">Torch
                Profile</label>
            </li>
          </ul>
        </div>
      </section>
      <button type="submit" name="submit">Save</button>
    </form>
  </main>


</body>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</html>

<?php
// session_start();
// include 'connection.php';


if (isset($_POST['submit'])) {
  // $date = $_SESSION['date'];
  // Check if checkboxes are set
  if (isset($_POST['BioChemistry']) || isset($_POST['Haematology']) || isset($_POST['Bacteriology']) || isset($_POST['Mycology']) || isset($_POST['Virology']) || isset($_POST['TumarMarkers']) || isset($_POST['Parasitology']) || isset($_POST['Cytology']) || isset($_POST['HormoneAssays']) || isset($_POST['Immunology'])) {
    $categories = ['BioChemistry', 'Haematology', 'Bacteriology', 'Mycology', 'Virology', 'TumarMarkers', 'Parasitology', 'Cytology', 'HormoneAssays', 'Immunology'];
    $queries = [];
    $last_report_id_query = "SELECT MAX(reportID) AS max_report_id FROM test_data";
    $last_report_id_result = mysqli_query($conn, $last_report_id_query);
    $last_report_id_row = mysqli_fetch_assoc($last_report_id_result);
    $last_report_id = $last_report_id_row['max_report_id'];

    if ($last_report_id === "") {
      $reportID = 1; // If table is empty, set report ID to 1
    } else {
      $reportID = $last_report_id + 1; // Otherwise, increment the last report ID
    }

    foreach ($categories as $category) {
      if (isset($_POST[$category])) {
        $testNames = implode(", ", $_POST[$category]); // Concatenate test names
        $query = "INSERT INTO test_data (`category`, `testNames`,  `patientID`, `patientName`, `doctorID`,`date`, `reportID`, `visitID`) 
                  VALUES ('$category', '$testNames', '$patientID', '$patientName', '{$row['doctorID']}','$date','$reportID','{$rowVisitID['visitID']}')";
        $queries[] = $query;
      }
    }

    // Execute all queries
    foreach ($queries as $query) {
      if (!mysqli_query($conn, $query)) {
        ?>
        <script>
          swal({
            title: "Error",
            text: "Test data not sent successfully",
            icon: "error",
            button: "Ok",
          }).then(function(){
             window.location = "doctor.php";
          });
        </script>
        <?php
      }
    }

    // Check if any queries were executed successfully
    if (count($queries) > 0) {
      $deleteQuery = "DELETE FROM appointed_patient WHERE patientID='$patientID' AND doctorID='{$row['doctorID']}' AND visitID='{$rowVisitID['visitID']}'";
      $resultDelete = mysqli_query($conn, $deleteQuery);

      if($resultDelete){
        ?>
        <script>
          swal({
            title: "Success",
            text: "Test data sent successfully",
            icon: "success",
            button: "Ok",
          }).then(function(){
            window.location = "doctor.php";
          });
        </script>
        <?php

      }
     
    }
  }
}
?>