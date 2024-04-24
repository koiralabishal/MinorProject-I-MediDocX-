<?php
// session_name('doctor_session');
session_start();
include 'connection.php';




if (!isset($_SESSION['doctorEmail'])) {
  header('Location:index.php');
}

function logout()
{
  // Clear session data
  unset($_SESSION['doctorEmail']);
  // Redirect to the login page
  header('Location: index.php');
  exit;
}

// Check if logout request is received
if (isset($_POST['logout'])) {
  logout();
}


// if (!isset($_SESSION['patientID'], $_SESSION['age'], $_SESSION['gender'])) {
//   header('Location:labTechnician.php');
// }





$email = $_SESSION['doctorEmail'];
// $patientName = $_SESSION['patientName'];
// $patientID = $_SESSION['patientID'];
// $patientage = $_SESSION['age'];
// $patientgender = $_SESSION['gender'];
// $visitID = $_SESSION['visitID'];
// $patientName = $_GET['patientName'];
// $patientID = $_GET['patientID'];
// $patientage = $_GET['age'];
// $patientgender = $_GET['gender'];
$date = $_SESSION['date'];
$visitID = $_SESSION['visitID'];
// $sqlVisitID = "SELECT visitID FROM patientVisitDetails WHERE date = '$date'";
// $resultVisitID = mysqli_query($conn, $sqlVisitID);

// if ($resultVisitID) {
//     $rowVisitID = mysqli_fetch_assoc($resultVisitID);
// }
$sqlPatientInfo = "SELECT * FROM patientvisitdetails WHERE visitID = '$visitID' AND date = '$date'";
$resultPatientInfo = mysqli_query($conn, $sqlPatientInfo);
if ($resultPatientInfo) {
  $rowPatientInfo = mysqli_fetch_assoc($resultPatientInfo);
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
  <link rel="stylesheet" href="style1.css">
  <link rel="stylesheet" href="requestationLetter.css">
</head>

<body>
  <header>
    <img src="MediDocX Logo.JPG" alt="" />
    <form method="post" id="logoutForm">
      <input type="hidden" name="logout" value="1"> <!-- Hidden input to identify logout action -->
      <button type="submit" id="logoutButton">Log out</button>
    </form>



    <!-- <input type="text" id="searchInput" placeholder="Search Tests..." /> -->
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
        <?php echo $rowPatientInfo['patientName']; ?>
      </div>
      <div class="reportTemplatesAside">Patient ID:
        <?php echo $rowPatientInfo['patientID']; ?>
      </div>
      <div class="reportTemplatesAside">Age:
        <?php echo $rowPatientInfo['age']; ?>
      </div>
      <div class="reportTemplatesAside">Gender:
        <?php echo $rowPatientInfo['gender']; ?>
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
      <section name>
        <div class="header">
          <h2>BioChemistry</h2>
          <input type="text" id="biochemistrySearchInput" placeholder="Search tests..." />
        </div>
        <div class="container">
          <ul>
            <li>
              <input type="checkbox" id="rbs" name="BioChemistry[]" value="RBS" /><label for="rbs">RBS</label>
            </li>
            <li>
              <input type="checkbox" id="Fbs" name="BioChemistry[]" value="FBS" /><label for="fbs">FBS</label>
            </li>
            <li>
              <input type="checkbox" id="ppbs" name="BioChemistry[]" value="PPBS" /><label for="ppbs">
                PPBS</label>
            </li>
            <li>
              <input type="checkbox" id="totalBilirubin" name="BioChemistry[]" value="Total Bilirubin" /><label
                for="totalBilirubin">Total Bilirubin</label>
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
              <input type="checkbox" id="serumCreatinine" name="BioChemistry[]" value="Serum Creatinine" /><label
                for="serumCreatinine">Serum Creatinine</label>
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
              <input type="checkbox" id="tibc" name="BioChemistry[]" value="TIBC" /><label for="tibc">TIBC</label>
            </li>
          </ul>
        </div>
      </section>

      <section>
        <div class="header">
          <h2>Haematology</h2>
          <input type="text" id="haematologySearchInput" placeholder="Search tests..." />
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
              <input type="checkbox" id="plateletCount" name="Haematology[]" value="Platelet Count" /><label
                for="plateletCount">Platelet Count</label>
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
              <input type="checkbox" id="d-dimer" name="Haematology[]" value="D-Dimer" /><label
                for="d-dimer">D-Dimer</label>
            </li>
          </ul>
        </div>
      </section>

      <section>
        <div class="header">
          <h2>Bacteriology</h2>
          <input type="text" id="bacteriologySearchInput" placeholder="Search tests..." />
        </div>
        <div class="container">
          <ul>
            <li>
              <input type="checkbox" id="gramStain" name="Bacteriology[]" value="Gram Stain" /><label
                for="gramStain">Gram
                Stain</label>
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
          <input type="text" id="mycologySearchInput" placeholder="Search tests..." />
        </div>
        <div class="container">
          <ul>
            <li>
              <input type="checkbox" id="kohMount" name="Mycology[]" value="KOH Mount" /><label id="mt"
                for="kohMount">KOH
                Mount</label>
            </li>
          </ul>
        </div>
      </section>

      <section>
        <div class="header">
          <h2>Virology</h2>
          <input type="text" id="virologySearchInput" placeholder="Search tests..." />
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
          <input type="text" id="tumarMarkersSearchInput" placeholder="Search tests..." />
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
          <input type="text" id="parasitologySearchEngine" placeholder="Search tests..." />
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
          <input type="text" id="cytologySearchInput" placeholder="Search tests..." />
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
          <input type="text" id="hormoneAssaysSearchInput" placeholder="Search tests..." />
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
                for="anti-tpo">Anti
                - TPO</label>
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
          <input type="text" id="immunologySearchInput" placeholder="Search tests..." />
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


      <section>
        <div class="sectionTitle">
          <h2></h2>
          <button type="submit" name="submit">Send All Tests</button>
          <h2></h2>
        </div>
      </section>


    </form>

  </main>


</body>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Biochemistry section search
    var biochemistrySearchInput = document.getElementById('biochemistrySearchInput');

    biochemistrySearchInput.addEventListener('input', function () {
      filterCheckboxes('BioChemistry', biochemistrySearchInput.value.toLowerCase());
    });

    // Haematology section search
    var haematologySearchInput = document.getElementById('haematologySearchInput');

    haematologySearchInput.addEventListener('input', function () {
      filterCheckboxes('Haematology', haematologySearchInput.value.toLowerCase());
    });

    // Bacteriology section search
    var bacteriologySearchInput = document.getElementById('bacteriologySearchInput');

    bacteriologySearchInput.addEventListener('input', function () {
      filterCheckboxes('Bacteriology', bacteriologySearchInput.value.toLowerCase());
    });

    // Mycology section search
    var mycologySearchInput = document.getElementById('mycologySearchInput');

    mycologySearchInput.addEventListener('input', function () {
      filterCheckboxes('Mycology', mycologySearchInput.value.toLowerCase());
    });

    // Virology section search
    var virologySearchInput = document.getElementById('virologySearchInput');

    virologySearchInput.addEventListener('input', function () {
      filterCheckboxes('Virology', virologySearchInput.value.toLowerCase());
    });

    // Tumar Markers section search
    var tumarMarkersSearchInput = document.getElementById('tumarMarkersSearchInput');

    tumarMarkersSearchInput.addEventListener('input', function () {
      filterCheckboxes('TumarMarkers', tumarMarkersSearchInput.value.toLowerCase());
    });

    // Parasitology section search
    var parasitologySearchInput = document.getElementById('parasitologySearchEngine');

    parasitologySearchInput.addEventListener('input', function () {
      filterCheckboxes('Parasitology', parasitologySearchInput.value.toLowerCase());
    });

    // Cytology section search
    var cytologySearchInput = document.getElementById('cytologySearchInput');

    cytologySearchInput.addEventListener('input', function () {
      filterCheckboxes('Cytology', cytologySearchInput.value.toLowerCase());
    });

    // Hormone Assays section search
    var hormoneAssaysSearchInput = document.getElementById('hormoneAssaysSearchInput');

    hormoneAssaysSearchInput.addEventListener('input', function () {
      filterCheckboxes('HormoneAssays', hormoneAssaysSearchInput.value.toLowerCase());
    });

    // Immunology section search
    var immunologySearchInput = document.getElementById('immunologySearchInput');

    immunologySearchInput.addEventListener('input', function () {
      filterCheckboxes('Immunology', immunologySearchInput.value.toLowerCase());
    });


    function filterCheckboxes(section, searchValue) {
      var checkboxes = document.querySelectorAll('[name="' + section + '[]"]');

      checkboxes.forEach(function (checkbox) {
        var labelText = checkbox.nextElementSibling.textContent.toLowerCase(); // Get the label text

        if (labelText.includes(searchValue)) {
          checkbox.parentNode.style.display = 'block'; // Show the parent li element
        } else {
          checkbox.parentNode.style.display = 'none'; // Hide the parent li element
        }
      });
    }
  });
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
  // Show SweetAlert confirmation dialog when the logout button is clicked
  document.getElementById('logoutButton').addEventListener('click', function (event) {
    event.preventDefault(); // Prevent the default form submission

    swal({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      buttons: ["Cancel", "Yes"], // Customize the buttons
      dangerMode: true, // Highlight the "Yes" button in red
    }).then((willLogout) => {
      if (willLogout) {
        document.getElementById('logoutForm').submit(); // Submit the form to perform logout
      } else {
        swal("You can continue browsing!", {
          icon: "success",
        });
      }
    });
  });
</script>

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
    $last_report_id_query = "SELECT MAX(reportID) AS max_report_id FROM report";
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
                  VALUES ('$category', '$testNames', '{$rowPatientInfo['patientID']}', '{$rowPatientInfo['patientName']}', '{$row['doctorID']}','$date','$reportID','$visitID')";
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
          }).then(function () {
            window.location = "doctor.php";
          });
        </script>
        <?php
      }
    }

    // Check if any queries were executed successfully
    if (count($queries) > 0) {
      $deleteQuery = "DELETE FROM appointed_patient WHERE patientID='{$rowPatientInfo['patientID']}' AND doctorID='{$row['doctorID']}' AND visitID='$visitID'";
      $resultDelete = mysqli_query($conn, $deleteQuery);

      if ($resultDelete) {
        ?>
        <script>
          swal({
            title: "Success",
            text: "Test data sent successfully",
            icon: "success",
            button: "Ok",
          }).then(function () {
            window.location = "doctor.php";
          });
        </script>
        <?php

      }

    }
  }
}
?>