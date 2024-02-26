<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>labTechnicianPatient</title>
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

      main section .header h2 {
        margin-right: auto;
      }

      main section .header button {
        border: 1px solid gray;
        /* margin: auto 4% auto auto; */
        margin: 1%;
        padding: 1%;
        height: fit-content;
        background-color: rgb(252, 252, 252);
        font-size: 16px;
        border-radius: 12px;
        /* background-color: red; */
      }

      main section .header button:hover {
        box-shadow: 2px 2px 4px 2px darkgrey;
        cursor: pointer;
        background-color: rgb(254, 254, 254);
      }

      main section .container {
        /* background-color: rgb(239, 239, 239); */
        /* background-color: #e3e8f8; */
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

      main section .container .boxContainer table {
        /* background-color: rgb(239, 239, 239); */
        margin: auto;
        border-collapse: collapse;
        font-family: Arial, Helvetica, sans-serif;
        border: 1px solid silver;
      }

      main section .container .boxContainer table th,
      td {
        padding: 4px 8px;
        text-align: left;
        vertical-align: top;
        font-size: 14px;
        text-wrap: balance;
        /* border: 1px solid black; */
      }

      main section .container .boxContainer table th[scope="col"] {
        color: whitesmoke;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        /* font-family: Arial, Helvetica, sans-serif; */
        font-size: 16px;
        font-weight: bold;
        background-color: #4e6eb2;
        border: none;
        text-wrap: nowrap;
      }

      main section .container .boxContainer table th[scope="row"] {
        font-weight: normal;
        padding-left: 2%;
      }

      main section .container .boxContainer table .testCategoryTitle {
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        /* font-family: Arial, Helvetica, sans-serif; */
        font-weight: bold;
        background-color: rgb(239, 239, 239);
        font-size: 14px;
        /* border-top: 1px solid silver; */
        border-bottom: 1px solid silver;
        margin-top: 24px;
        /* background-color: red; */
      }

      main section .container .boxContainer table td .result {
        background-color: transparent;
        border: 1px solid gray;
        width: 80%;
      }

      main section .container .boxContainer table td .flag {
        background-color: transparent;
        border: 1px solid gray;
        width: 40%;
      }

      main section .container .boxContainer table td ul {
        padding-left: 5%;
      }

      main section .container .boxContainer table td ul ul {
        padding-left: 10%;
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
      <section>
        <div class="header">
          <h2>BioChemistry</h2>
        </div>
        <div class="container">
          <div class="boxContainer">
            <table>
              <tr>
                <th scope="col">Test Name</th>
                <th scope="col">Result</th>
                <th scope="col">Unit</th>
                <th scope="col">Flag</th>
                <th scope="col">Reference Range</th>
                <th scope="col">Method</th>
              </tr>

              <tr class="testCategoryTitle">
                <td colspan="6">Complete BioChemistry Profile</td>
              </tr>

              <tr>
                <th scope="row">RBS</th>
                <td><input type="text" class="result" /></td>
                <td>mg/dL</td>
                <td><input type="text" class="flag" /></td>
                <td>70 - 140</td>
                <td>Glucose oxidase-peroxidase</td>
              </tr>

              <tr>
                <th scope="row">FBS</th>
                <td><input type="text" class="result" /></td>
                <td>mg/dL</td>
                <td><input type="text" class="flag" /></td>
                <td>70 - 100</td>
                <td>Glucose oxidase-peroxidase</td>
              </tr>

              <tr>
                <th scope="row">PPBS</th>
                <td><input type="text" class="result" /></td>
                <td>mg/dL</td>
                <td><input type="text" class="flag" /></td>
                <td>&lt; 140 (postprandial)</td>
                <td>Glucose oxidase-peroxidase</td>
              </tr>

              <tr class="testCategoryTitle">
                <td colspan="6">Liver Function Tests</td>
              </tr>

              <tr>
                <th scope="row">LFT</th>
                <td><input type="text" class="result" /></td>
                <td>IU/L</td>
                <td><input type="text" class="flag" /></td>
                <td>
                  <ul>
                    <li>Total Bilirubin: 0.2 - 1.2 mg/ dL</li>
                    <li>
                      Alanine aminotransferase (ALR or SGPT): 7 - 56 IU/ L
                    </li>
                    <li>
                      Aspartate aminotransferase (AST or SGOT): 5 - 40 IU/ L
                    </li>
                  </ul>
                </td>
                <td>Various enzymatic and colorimetric methods</td>
              </tr>

              <tr>
                <td class="testCategoryTitle" colspan="6">
                  Renal Function Tests
                </td>
              </tr>
              <tr>
                <th scope="row">Renal Function Tests</th>
                <td><input type="text" class="result" /></td>
                <td>mg/dL</td>
                <td><input type="text" class="flag" /></td>
                <td>
                  <ul>
                    <li>Blood Urea Nitrogen (BUN or Urea): 7 - 20 mg/ dL</li>
                    <li>
                      Serum Creatinine:
                      <ul>
                        <li>0.6 - 1.2 mg/ dL (adult males)</li>
                        <li>0.5 - 1.1 mg/ dL (adult females)</li>
                      </ul>
                    </li>
                    <li>
                      Estimated Glomerular Filtration Rate (eGFR): &gt; 60
                      mL/min/1.73m<sup>2</sup>
                    </li>
                  </ul>
                </td>
                <td>Various enzymatic and colorimetric methodss</td>
              </tr>

              <tr class="testCategoryTitle">
                <td>Lipid Profile</td>
              </tr>
              <tr>
                <th scope="row">Lipid Profile</th>
                <td><input type="text" class="result" /></td>
                <td>mg/dL</td>
                <td><input type="text" class="flag" /></td>
                <td>
                  <ul>
                    <li>Total Cholesterol: &lt; 200 mg/ dL</li>
                    <li>Triglycerides: &lt; 150 mg/ dL</li>
                    <li>
                      High-Density Lipoprotein (HDL) Cholesterol:
                      <ul>
                        <li>&gt; 40 mg/ dL (men)</li>
                        <li>&gt; 50 mg/ dL (women)</li>
                      </ul>
                    </li>
                    <li>
                      Low-Density Lipoprotein (LDL) Cholesterol: &lt; 130 mg/ dL
                    </li>
                  </ul>
                </td>
                <td>Various enzymatic methods</td>
              </tr>

              <tr class="testCategoryTitle">
                <td colspan="6">Electrolytes and Minerals</td>
              </tr>
              <tr>
                <th scope="row">Ca++</th>
                <td><input type="text" class="result" /></td>
                <td>mg/dL</td>
                <td><input type="text" class="flag" /></td>
                <td>8.5 - 10.5</td>
                <td>Colorimetric method</td>
              </tr>

              <tr>
                <th scope="row">Mg++</th>
                <td><input type="text" class="result" /></td>
                <td>mg/dL</td>
                <td><input type="text" class="flag" /></td>
                <td>1.7 - 2.2</td>
                <td>Colorimetric method</td>
              </tr>

              <tr>
                <th scope="row">Phosphorus</th>
                <td><input type="text" class="result" /></td>
                <td>mg/dL</td>
                <td><input type="text" class="flag" /></td>
                <td>2.5 - 4.5</td>
                <td>Colorimetric method</td>
              </tr>

              <tr>
                <th scope="row">Uric Acid</th>
                <td><input type="text" class="result" /></td>
                <td>mg/dL</td>
                <td><input type="text" class="flag" /></td>
                <td>
                  <ul>
                    <li>3.5 - 7.2 (male)</li>
                    <li>2.6 - 6.0 (female)</li>
                  </ul>
                </td>
                <td>Uricase method</td>
              </tr>

              <tr class="testCategoryTitle">
                <td colspan="6">Cardiac Markers</td>
              </tr>
              <tr>
                <th scope="row">CPK - MB</th>
                <td><input type="text" class="result" /></td>
                <td>IU/L</td>
                <td><input type="text" class="flag" /></td>
                <td>&lt; 5 ng/mL</td>
                <td>Enzymatic method</td>
              </tr>

              <tr>
                <th scope="row">CPK - NAC</th>
                <td><input type="text" class="result" /></td>
                <td>IU/L</td>
                <td><input type="text" class="flag" /></td>
                <td>&lt; 5 ng/mL</td>
                <td>Enzymatic method</td>
              </tr>

              <tr class="testCategoryTitle">
                <td colspan="6">Iron Profile</td>
              </tr>
              <tr>
                <th scope="row">Iron Profile</th>
                <td><input type="text" class="result" /></td>
                <td>μg/dL</td>
                <td><input type="text" class="flag" /></td>
                <td>
                  <ul>
                    <li>Serum Iron: 60 - 170</li>
                    <li>Total Iron-Binding Capacity (TIBC): 240 - 450</li>
                    <li>Transferrin Saturation: 20% - 50%</li>
                  </ul>
                </td>
                <td>Colorimetric and spectrophotometric methods</td>
              </tr>
            </table>
          </div>
        </div>
      </section>

      <section>
        <div class="header">
          <h2>Hematology</h2>
        </div>
        <div class="container">
          <div class="boxContainer">
            <table>
              <tr>
                <th scope="col">Test Name</th>
                <th scope="col">Result</th>
                <th scope="col">Unit</th>
                <th scope="col">Flag</th>
                <th scope="col">Reference Range</th>
                <th scope="col">Method</th>
              </tr>

              <tr class="testCategoryTitle">
                <td colspan="6">Complete Blood Count</td>
              </tr>
              <tr>
                <th scope="row">Complete Blood Count</th>
                <td><input type="text" class="result" /></td>
                <td>%</td>
                <td><input type="text" class="flag" /></td>
                <td>
                  <ul>
                    <li>
                      Hemoglobin (Hb):
                      <ul>
                        <li>13.5 - 17.5 g/gL (male)</li>
                        <li>12 - 16 g/dL (female)</li>
                      </ul>
                    </li>
                    <li>Total Leukocyte Count (TLC or WBC): 4,000 - 11,000 cells/μL</li>
                    <li>Platelet Count: 150,000 - 450,000 platelets/μL</li>
                  </ul>
                </td>
                <td>Automated cell counting and impedance or flow cytometry</td>
              </tr>

              <tr class="testCategoryTitle"><td colspan="6">Erythrocyte Sedimentation Rate(ESR)</td></tr>
              <tr>
                <th scope="row">Erythrocyte Sedimentation Rate</th>
                <td><input type="text" class="result"></td>
                <td>mm/h</td>
                <td><input type="text" class="flag"></td>
                <td><ul>
                  <li>0 - 20 mm/h (male)</li>
                  <li>0 - 30 mm/h (female)</li>
                </ul></td>
                <td>Westergren method or modified Westergren method</td>
              </tr>

              <tr class="testCategoryTitle"><td colspan="6">Blood Grouping</td></tr>
              <tr>
                <th scope="row">Blood Grouping</th>
                <td><input type="text" class="result"></td>
                <td>A, B, AB or O</td>
                <td><input type="text" class="flag"></td>
                <td>Categorized into blood groups</td>
                <td>Agglutination tests</td>
              </tr>

              <tr class="testCategoryTitle"><td colspan="6">Peripheral Blood Smear</td></tr>
              <tr>
                <th scope="row">Peripheral Blood Smear</th>
                <td><input type="text" class="result"></td>
                <td></td>
                <td><input type="text" class="flag"></td>
                <td>Evaluation of blood cell morphology</td>
                <td>Microscopic examination of stained blood smear</td>
              </tr>

              <tr class="testCategoryTitle"><td colspan="6">Reticulocyte Count</td></tr>
              <tr>
                <th scope="row">Retics</th>
                <td><input type="text" class="result"></td>
                <td>cells/μL</td>
                <td><input type="text" class="flag"></td>
                <td>0.5% - 1.5% of total RBC or 25,000 - 75,000 cells/μL</td>
                <td>Flow cytometry or manual counting with supracital stains</td>
              </tr>

              <tr class="testCategoryTitle"><td colspan="6">Bleeding Time and Clotting Time</td></tr>
              <tr>
                <th scope="row">Bleeding Time and Clotting Time</th>
                <td><input type="text" class="result"></td>
                <td>minutes</td>
                <td class="flag"></td>
                <td><ul>
                  <li>BT: 2 - 7 minutes</li>
                  <li>CT: 2 - 5 minutes</li>
                </ul></td>
                <td>Ivy method for BT, Lee-White method for CT</td>
              </tr>

              <tr class="testCategoryTitle"><td colspan="6">Prothrobin Time and International Normalized Ratio</td></tr>
              <th scope="row">Prothrobin Time and International Normalized Ratio</th>
              <td><input type="text" class="result"></td>
              <td><ul>
                <li>Second(s) for PT</li>
                <li>Ration for INR</li>
              </ul></td>
              <td><input type="text" class="flag"></td>
              <td><ul>
                <li>PT: 11 - 13.5 seconds</li>
                <li>INR: 0.8 - 1.2 (normal range)</li>
              </ul></td>
              <td>Clotting assays using thromboplastin reagents</td>

              <tr class="testCategoryTitle"><td colspan="6">Activated Partial Thromboplastin Time</td></tr>
              <tr>
              <th scope="row">Activated Partial Thromboplastin Time</th>
              <td><input type="text" class="result"></td>
              <td>Seconds</td>
              <td><input type="text" class="flag"></td>
              <td>25 - 30 seconds</td>
              <td>Clotting assays using phospholipid and activator reagents</td>
            </tr>

            <tr class="testCategoryTitle"><td colspan="6">Absolute Eosinophil Count</td></tr>
            <tr>
              <th scope="row">Absolute Eosinophil Count</th>
              <td><input type="text" class="result"></td>
              <td>cells/μL</td>
              <td><input type="text" class="flag"></td>
              <td>50 - 500 cells/μL</td>
              <td>Automated cell counting with specific staining</td>
            </tr>

            <tr class="testCategoryTitle"><td colspan="6">Absolute Basophil Count</td></tr>
            <tr>
              <th scope="row">Absolute Basophil Count</th>
              <td><input type="text" class="result"></td>
              <td>cells/μL</td>
              <td><input type="text" class="flag"></td>
              <td>0 - 200 cells/μL</td>
              <td>Automated cell couning with specific staining</td>
            </tr>

            <tr class="testCategoryTitle"><td colspan="6">Absolute Neutrophil Count</td></tr>
            <tr>
              <th scope="row">Absolute Neutrophil Count</th>
              <td><input type="text" class="result"></td>
              <td>cells/μL</td>
              <td><input type="text" class="flag"></td>
              <td>1,500 - 8,000 cells/μL</td>
              <td>Automated cell counting with specific staining</td>
            </tr>

            <tr class="testCategoryTitle"><td colspan="6">D-Dimer</td></tr>
            <tr>
              <th scope="row">D-Dimer</th>
              <td><input type="text" class="result"></td>
              <td>ng/mL</td>
              <td><input type="text" class="flag"></td>
              <td>&lt; 500 ng/mL or &lt; 0.5 μg/mL</td>
              <td>Enzyme-linked immunosorbent assay (ELISA) or latex agglutination assay</td>
            </tr>
            </table>
          </div>
        </div>
      </section>

      <section>
        <div class="header">
          <h2>Recent Visits</h2>
          <button class="add" onclick="requestationLetter()">
            Request Letter
          </button>
          <button class="add" onclick="addPrescription()">
            Add Prescription
          </button>
        </div>
        <div class="container">
          <div class="month">February, 2024</div>
          <div class="boxContainer">
            <div class="box" onclick="visit()">
              Date: 2024/ 02/ 17 <br />
              Visit Type: Routine Check-up <br />
            </div>
            <div class="box">
              Date: 2022/ 09/ 07 <br />
              Visit Type: Follow-up Consultation <br />
            </div>
            <div class="box">
              Date: 2022/ 09/ 05 <br />
              Visit Type: Routine Check-up <br />
            </div>
            <div class="box">7</div>
            <div class="box">8</div>
            <div class="box">9</div>
            <div class="box">10</div>
          </div>
        </div>

        <div class="container">
          <div class="month">September, 2022</div>
          <div class="boxContainer">
            <div class="box">
              Date: 2022/ 09/ 07 <br />
              Visit Type: Follow-up Consultation <br />
            </div>
            <div class="box">
              Date: 2022/ 09/ 05 <br />
              Visit Type: Routine Check-up <br />
            </div>
          </div>
        </div>
      </section>

      <section>
        <div class="header">
          <h2>Recent Reports</h2>
        </div>
        <div class="container">
          <div class="month">February, 2024</div>
          <div class="boxContainer">
            <div class="box" id="b" onclick="biochemistry()">BioChemistry</div>
            <div class="box" onclick="haematology()">Hematology</div>
            <div class="box" onclick="echocardiography()">EchoCardiography</div>
          </div>
        </div>

        <div class="container">
          <div class="month">September, 2024</div>
          <div class="boxContainer">
            <div class="box">Immunology</div>
            <div class="box">4</div>
            <div class="box">5</div>
            <div class="box">6</div>
            <div class="box">7</div>
            <div class="box">8</div>
            <div class="box">9</div>
            <div class="box">10</div>
          </div>
        </div>
      </section>

      <section>
        <div class="header">
          <h2>Cuurrent Medication</h2>
        </div>
        <div class="container">
          <div class="boxContainer">
            <table border="1">
              <tr>
                <td>Name</td>
                <td>Dosage(mg)</td>
                <td>Scheduling</td>
                <td>Duration</td>
              </tr>
              <tr>
                <td>Flexon</td>
                <td>12</td>
                <td>TBS</td>
                <td>1 week</td>
              </tr>
            </table>
          </div>
        </div>
      </section>
    </main>

    <script>
      function requestationLetter() {
        window.location.href = "requestationLetter.html";
      }
      function addPrescription() {
        window.location.href = "doctorPatientVisit.html";
      }

      function visit() {
        window.location.href = "doctorPatientVisit.html";
      }
      function biochemistry() {
        window.location.href = "bioChemistry.html";
      }

      function haematology() {
        window.location.href = "haematology.html";
      }

      function echocardiography() {
        window.location.href = "echocardiography.html";
      }

      // document.addEventListener('DOMContentLoaded', function(){
      //     let box = document.querySelectorAll('.box');
      //     box.forEach(function(bpar){
      //         bpar.addEventListener("click", function(){
      //             this.style.backgroundColor = "red";
      //         });
      //     });
      // });

      // let box = document.querySelectorAll(".box");
      // box.forEach(function (bpar) {
      //   bpar.addEventListener("click", function () {
      //       this.style.transition = "all .2s";
      //       // this.style.zIndex = "0";
      //       if(this.style.backgroundColor == "red"){
      //           this.style.backgroundColor = "grey";
      //           this.style.transform = "scale(1)";
      //           // this.style.zIndex = "0";
      //       }
      //       else{
      //           // this.style.zIndex = "10";
      //           this.style.transform = "scale(2)";
      //           this.style.backgroundColor = "red";
      //       }
      //   });
      // });
    </script>
  </body>
</html>
