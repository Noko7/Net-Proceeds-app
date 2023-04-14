<!DOCTYPE html>
<html>
    <head>
        <head class="header">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Net Proceeds App</title>
            <link rel="stylesheet" href="style.css">
    </head><br><br>
    <body>
    <?php
   // Get the form data
$seller_name = $_POST['seller_name'];
$property_address = $_POST['property_address'];
$closing_date = $_POST['closing_date'];
$commission_percent = $_POST['commission_percent'];
$property_taxes = $_POST['property_taxes'];
$first_installment_paid = $_POST['first_installment_paid'];
$second_installment_paid = $_POST['second_installment_paid'];
$current_mortgage_balance = $_POST['current_mortgage_balance'];
$misc_fees1 = $_POST['misc_fees1'];
$misc_fees2 = $_POST['misc_fees2'];
$misc_fees3 = $_POST['misc_fees3'];
$misc_fees4 = $_POST['misc_fees4'];
$sales_price_1 = $_POST['sales_price_1'];
$sales_price_2 = $_POST['sales_price_2'];
$sales_price_3 = $_POST['sales_price_3'];
$zip_code = $_POST['zip_code'];

// Calculate the total estimated net proceeds
$misc_fees = intval($misc_fees1) + intval($misc_fees2) + intval($misc_fees3) + intval($misc_fees4);
$total_estimated_net_proceeds = 0;
$total_estimated_net_proceeds += floatval($sales_price_1);
$total_estimated_net_proceeds += floatval($sales_price_2);
$total_estimated_net_proceeds += floatval($sales_price_3);
$total_estimated_net_proceeds -= floatval($property_taxes);
$total_estimated_net_proceeds -= floatval($current_mortgage_balance);
$total_estimated_net_proceeds -= floatval($misc_fees);
$total_estimated_net_proceeds -= floatval($repair_costs);
$total_estimated_net_proceeds -= floatval($hoa_fees);
$total_estimated_net_proceeds -= floatval($insurance_costs);

// Calculate the various fees
$title_search_fee = $total_estimated_net_proceeds * 0.015;
$closing_fee = 100;
$courier_fee = 35;
// Calculate the state and county tax stamps fee
$state_county_tax_stamps = $total_estimated_net_proceeds * 0.003;
$recording_fee = 35;
$listing_fee = $total_estimated_net_proceeds * 0.006;

//Calculate the total net proceeds
$total_selling_expenses = 0;
$total_selling_expenses += $title_search_fee;
$total_selling_expenses += $closing_fee;
$total_selling_expenses += $courier_fee;
$total_selling_expenses += $state_county_tax_stamps;
$total_selling_expenses += $recording_fee;
$total_selling_expenses += $listing_fee;

$total_net_proceeds = $total_estimated_net_proceeds - $total_selling_expenses;

// Calculate the property taxes
if (!$first_installment_paid) {
    $total_selling_expenses += $property_taxes * $tax_rate / 2;
}

if (!$second_installment_paid) {
    $total_selling_expenses += $property_taxes * $tax_rate / 2;
}

$total_estimated_net_proceeds -= $total_selling_expenses;

// Calculate the commission
$commission = $total_estimated_net_proceeds * ($commission_percent / 100);
$total_estimated_net_proceeds -= $commission;
?>

<div class="buttons-container">
  <div class="button-group">
    <button id="email-button">Share by Email</button>
    <button onclick="window.print()">Print Results</button>
    <img src='https://boomtown-production-consumer-backup.s3.amazonaws.com/1298/files/2021/09/hp.png' alt='Business Logo' width='500' height='180'>
    <button id="pdf-button">Download PDF</button>
    <button id="link-button">Copy Link</button>
    
  </div>
</div>

<script>
 // Get references to the buttons
 var emailButton = document.getElementById('email-button');
 var gmailButton = document.getElementById('gmail-button');
 var pdfButton = document.getElementById('pdf-button');
 var linkButton = document.getElementById('link-button');

 // Add event listeners for each button to handle the click
 emailButton.addEventListener('click', function() {
   var pageUrl = encodeURIComponent(window.location.href);
   var emailLink = "mailto:?subject=Check%20out%20this%20page&body=" + pageUrl;
   var options = "width=600,height=600,left=100,top=100";
   window.open(emailLink, "Email", options);
 });

 gmailButton.addEventListener('click', function() {
   var pageUrl = encodeURIComponent(window.location.href);
   var gmailLink = "https://mail.google.com/mail/?view=cm&fs=1&to=&su=Check%20out%20this%20page&body=" + pageUrl;
   var options = "width=600,height=600,left=100,top=100";
   window.open(gmailLink, "Gmail", options);
 });

 pdfButton.addEventListener('click', function() {
   // Use the print-pdf query parameter to trigger the PDF download
   var pageUrl = window.location.href + "?print-pdf";
   var options = "width=600,height=600,left=100,top=100";
   window.open(pageUrl, "PDF", options);
 });

 linkButton.addEventListener('click', function() {
   var pageUrl = window.location.href;
   // Create a temporary input element to copy the URL to the clipboard
   var tempInput = document.createElement("input");
   tempInput.value = pageUrl;
   document.body.appendChild(tempInput);
   tempInput.select();
   document.execCommand("copy");
   document.body.removeChild(tempInput);
   alert("Copied the link to the clipboard: " + pageUrl);
 });
</script>

//Print Results
<div class="results-container">
  <div class="results-table">
  <table class="wide-table">
  <tr>
    <td colspan="2"><b>Seller Name:</b> <?php echo $seller_name; ?></td>
  </tr>
  <tr>
  <td colspan="2"><?php echo $property_address; ?></td>
  </tr>
  <tr>
    <td colspan="2"><b>Closing Date:</b> <?php echo $closing_date; ?></td>
  </tr>
  <tr>
    <td class="colnum">Title Search Fee:</td>
    <td class="colnum">$<?php echo number_format($title_search_fee, 2); ?></td>
  </tr>
  <tr>
    <td class="colnum">Closing Fee:</td>
    <td class="colnum">$<?php echo number_format($closing_fee, 2); ?></td>
  </tr>
  <tr>
    <td class="colnum">Courier Fee:</td>
    <td class="colnum">$<?php echo number_format($courier_fee, 2); ?></td>
  </tr>
  <tr>
    <td class="colnum">State and County Tax Stamps:</td>
    <td class="colnum">$<?php echo number_format($state_county_tax_stamps, 2); ?></td>
  </tr>
  <tr>
    <td class="colnum">Recording Fee:</td>
    <td class="colnum">$<?php echo number_format($recording_fee, 2); ?></td>
  </tr>
  <tr>
    <td class="colnum">Listing Fee:</td>
    <td class="colnum">$<?php echo number_format($listing_fee, 2); ?></td>
  </tr>
  <tr>
    <td class="colnum">Property Taxes:</td>
    <td class="colnum">$<?php echo number_format($property_taxes, 2); ?></td>
  </tr>
  <tr>
    <td class="colnum">First Installment Paid:</td>
    <td class="colnum"><?php echo $first_installment_paid ? "Yes" : "No"; ?></td>
  </tr>
  <tr>
    <td class="colnum">Second Installment Paid:</td>
    <td class="colnum"><?php echo $second_installment_paid ? "Yes" : "No"; ?></td>
  </tr>
  <tr>
    <td class="colnum">Mortgage Balance:</td>
    <td class="colnum">$<?php echo number_format($current_mortgage_balance, 2); ?></td>
  </tr>
  <tr>
    <td class="colnum">Misc. Fees:</td>
    <td class="colnum">$<?php echo number_format($misc_fees, 2); ?></td>
    <tr>
    <td class="colnum">Closing Fee:</td>
    <td class="colnum">$<?php echo number_format($closing_fee, 2); ?></td>
  </tr>
  <tr>
    <td class="colnum">Courier Fee:</td>
    <td class="colnum">$<?php echo number_format($courier_fee, 2); ?></td>
  </tr>
  <tr>
    <td class="colnum">State &amp; County Tax Stamps:</td>
    <td class="colnum">$<?php echo number_format($state_county_tax_stamps, 2); ?></td>
  </tr>
  <tr>
    <td class="colnum">Recording Fee:</td>
    <td class="colnum">$<?php echo number_format($recording_fee, 2); ?></td>
  </tr>
  <tr>
    <td class="colnum">Listing Fee:</td>
    <td class="colnum">$<?php echo number_format($listing_fee, 2); ?></td>
  </tr>
  <tr>
    <td class="colnum" style="border-bottom:thin solid black;">Misc. Fees:</td>
    <td class="colnum" style="border-bottom:thin solid black;">$<?php echo number_format($misc_fees, 2); ?></td>
  </tr>
  <tr>
    <td class="colnum" style="border-top:thin solid black;border-bottom:thin solid black;">Total Selling Expenses:</td>
    <td class="colnum" style="border-top:thin solid black;border-bottom:thin solid black;">$<?php echo number_format($total_selling_expenses, 2); ?></td>
  </tr>
  <tr>
    <td class="colnum" style="border-top:thin solid black;border-bottom:thin solid black;">Total Net Proceeds:</td>
    <td class="colnum" style="border-top:thin solid black;border-bottom:thin solid black;">$<?php echo number_format($total_net_proceeds, 2); ?></td>
  </tr>
  <tr>
    <td class="colnum">Commission:</td>
    <td class="colnum">$<?php echo number_format($commission, 2); ?></td>
  </tr>
  <tr>
    <td class="colnum" style="border-top:thin solid black;border-bottom:thin solid black;">Total Estimated Net Proceeds:</td>
    <td class="colnum" style="border-top:thin solid black;border-bottom:thin solid black;">$<?php echo number_format($total_estimated_net_proceeds, 2); ?></td>
  </tr>
</table>
</div>
</div>
        
    
    <main class="input">
        
    </main>


    </body>
</html>

