<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PatientVisit</title>
    <link rel="stylesheet" href="style1.css" />
    <link rel="stylesheet" href="style2Tables.css">
    <style>

    </style>
  </head>
  <body>
    <header>
      <img src="MediDocX Logo.JPG" alt="" />
    </header>

    <aside>
      <div id="profileInfo">
        <div id="profilePic"></div>
        <div id="details">
          <b> Mayukh Baral </b><br />
          Patient <br />
          ID: 54 <br />
          M.D. Cardiology <br />
          (TU, GMC, Nepal)
        </div>
      </div>
    </aside>

    <main>
      <section>
        <div class="sectionTitle">
          <h2>Prescription</h2>
        </div>
        <div class="container">
          <div class="boxContainer">
            <div class="box">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident
              nobis delectus a quisquam sunt rem alias ad aperiam odio? Vero
              illo ut illum quasi dolores reprehenderit dicta optio id sunt.
            </div>
          </div>
        </div>
      </section>

      <section>
        <div class="sectionTitle">
          <h2>BioChemistry</h2>
        </div>
        <div class="tableContainer">
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
              <td><span class="result"></span></td>
              <td>mg/dL</td>
              <td><span class="flag"></span></td>
              <td>70 - 140</td>
              <td>Glucose oxidase-peroxidase</td>
            </tr>

            <tr>
              <th scope="row">FBS</th>
              <td><span class="result"></span></td>
              <td>mg/dL</td>
              <td><span class="flag"></span></td>
              <td>70 - 100</td>
              <td>Glucose oxidase-peroxidase</td>
            </tr>

            <tr>
              <th scope="row">PPBS</th>
              <td><span class="result"></span></td>
              <td>mg/dL</td>
              <td><span class="flag"></span></td>
              <td>&lt; 140 (postprandial)</td>
              <td>Glucose oxidase-peroxidase</td>
            </tr>

            <tr class="testCategoryTitle">
              <td colspan="6">Liver Function Tests</td>
            </tr>

            <tr>
              <th scope="row">LFT</th>
              <td><span class="result"></span></td>
              <td>IU/L</td>
              <td><span class="flag"></span></td>
              <td>
                <ul>
                  <li>Total Bilirubin: 0.2 - 1.2 mg/ dL</li>
                  <li>Alanine aminotransferase (ALR or SGPT): 7 - 56 IU/ L</li>
                  <li>
                    Aspartate aminotransferase (AST or SGOT): 5 - 40 IU/ L
                  </li>
                </ul>
              </td>
              <td>Various enzymatic and colorimetric methods</td>
            </tr>
            <tr>
              <th scope="row">Total Bilirubin</th>
              <td><span class="result"></span></td>
              <td>mg/dL</td>
              <td><input type="text" class="flag" /></td>
              <td>0.3 - 1.2</td>
              <td>Diazo Method</td>
            </tr>

          </table>
        </div>
      </section>

      <section>
        <div class="sectionTitle">
          <h2>Hematology</h2>
        </div>
        <div class="tableContainer">
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
                <td><span class="result"></span></td>
                <td>%</td>
                <td><span class="flag"></span></td>
                <td>
                  <ul>
                    <li>
                      Hemoglobin (Hb):
                      <ul>
                        <li>13.5 - 17.5 g/gL (male)</li>
                        <li>12 - 16 g/dL (female)</li>
                      </ul>
                    </li>
                    <li>
                      Total Leukocyte Count (TLC or WBC): 4,000 - 11,000
                      cells/μL
                    </li>
                    <li>Platelet Count: 150,000 - 450,000 platelets/μL</li>
                  </ul>
                </td>
                <td>Automated cell counting and impedance or flow cytometry</td>
              </tr>

              <tr class="testCategoryTitle">
                <td colspan="6">Erythrocyte Sedimentation Rate(ESR)</td>
              </tr>
              <tr>
                <th scope="row">Erythrocyte Sedimentation Rate</th>
                <td><span class="result"></span></td>
                <td>mm/h</td>
                <td><span class="flag"></span></td>
                <td>
                  <ul>
                    <li>0 - 20 mm/h (male)</li>
                    <li>0 - 30 mm/h (female)</li>
                  </ul>
                </td>
                <td>Westergren method or modified Westergren method</td>
              </tr>
            </table>
        </div>
      </section>

    </main>
  </body>
</html>
