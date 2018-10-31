@extends('layouts.official')

@section('content')
<div class="container">
<div id="searchMember" >
    <form id="searchMemberForm" name="searchMemberName">
    {{csrf_field()}}
        <div class="form-group col-md-6">
            <br>
            <label for="firstName">Select Member:</label>
            <input class="form-control" type="text" name="member_first_name" placeholder="Member First Name">
        </div>
        <div class="form-group col-md-6">
            <button class="btn btn-primary sm" type="submit">Search</button>
        </div>
    </form>
</div>
<div id="membersList"></div>
<div id="membersLoans"></div>
<div class="row" id ="amortization">
<div id="LoanAmortization" class="col-sm-3"></div>
<div id="LoanAmortization1" class="col-sm-9"></div>
</div>
</div>
<script type="text/javascript">
        
var methods = ["GET", "POST"];
var baseUrl = "http://127.0.0.1:8000/";

//CREATE THE FORM 
// Dynamic function for calling webservices
function createObject(readyStateFunction,requestMethod,requestUrl, sendData = null){
    
    var obj = new XMLHttpRequest;

    obj.onreadystatechange = function(){
        if((this.readyState ==4) && (this.status ==200)){
            readyStateFunction(this.responseText);
        }
        
    };
    obj.open(requestMethod, requestUrl, true);
    if (requestMethod == 'POST'){
        
        obj.setRequestHeader("Content-type", "application/x-www-form-urlencoded" );
        obj.setRequestHeader("X-CSRF-Token", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        obj.send(sendData);
    }
    else 
    {
        obj.send();
    }
    }

    function searchName(e){
        e.preventDefault();
        var name = document.forms['searchMemberName']['member_first_name'].value;
        createObject(displayNames, methods[0], baseUrl + 'amortizationSearch/'+name);
        return false;
    }
    function displayNames(responseTxt){
        var responseObj = JSON.parse(responseTxt);
        var count =0,tData; 
        var tableData = "<div class='container'><table class = 'table table-bordered table-striped table-condensed'><tr><th>#</th><th>Name</th><th>National ID</th><th>Bank Account</th><th>Email</th><th colspan ='2'> Action</th></tr>";
        for(tData in responseObj){
            // alert(responseObj[tData].member_first_name);
            count++;
            tableData +="<tr><td>"+ count +"</td>";
            tableData +="<td>"+ responseObj[tData].member_first_name +"</td>";
            tableData +="<td>"+ responseObj[tData].member_national_id +"</td>";
            tableData +="<td>"+ responseObj[tData].member_bank_account_number +"</td>";
            tableData +="<td>"+ responseObj[tData].member_email +"</td>";
            tableData +="<td><a href = '#' class ='btn btn-info bt-sm' onclick = 'armotization("+responseObj[tData].id+")'>Armotization</a></td>";
            tableData +="<td><a href = '#' class ='btn btn-info bt-sm' onclick = 'viewLoan("+responseObj[tData].id+")'>View Loan</a></td>";

        }
        tableData += "</div></table>";
        document.getElementById("membersList").innerHTML = tableData;
    }
    function armotization(id){
        createObject(displayLoans, methods[0], baseUrl + "fetchLoans/" + id);
    }
    function displayLoans(responseTxt){
        document.getElementById('searchMember').style.display = "none";
        document.getElementById('membersList').style.display = "none";
       
        var responseObj = JSON.parse(responseTxt);
        var count =0,tData; 
        var tableData = "<div class='container'><table class = 'table table-bordered table-striped table-condensed'><tr><th>#</th><th>Name</th><th>Loan Amount</th><th>Loan Installments</th><th>Loan Interest</th><th colspan ='2'> Action</th></tr>";
        for(tData in responseObj){
            count++;
            tableData +="<tr><td>"+ count +"</td>";
            tableData +="<td>"+ responseObj[tData].member_first_name + responseObj[tData].member_last_name +"</td>";
            tableData +="<td>"+ responseObj[tData].loan_amount +"</td>";
            tableData +="<td>"+ responseObj[tData].loan_installments +"</td>";
            tableData +="<td>"+ responseObj[tData].interest_rate +"</td>";
            tableData +="<td><a href = '#' class ='btn btn-info bt-sm' onclick = 'armotizationCalculated("+responseObj[tData].id+")'>View Armotization</a></td>";
            tableData +="<td><a href = '#' class ='btn btn-info bt-sm' onclick = 'viewLoan("+responseObj[tData].id+")'>Back</a></td>";

        }
        tableData += "</div></table>";
        document.getElementById("membersLoans").innerHTML = tableData;
        document.getElementById('membersLoans').style.display = "block";
    }
    function armotizationCalculated(id){
        createObject(displayAmortization, methods[0], baseUrl + "calculateAmortization/"+id)
    }
    function displayAmortization(responseTxt){
        document.getElementById('searchMember').style.display = "none";
        document.getElementById('membersList').style.display = "none";
        document.getElementById('membersLoans').style.display = "none";
       
        var responseObj = JSON.parse(responseTxt);
        var count =0,tData; 
        var tableData = "<div class='container'><table style='float: left;' class = 'table table-bordered table-striped table-condensed'><tr><th>#</th><th>Raw Monthly Interest</th></tr>";
        for(tData in responseObj){
            if(responseObj[tData]==responseObj.interestA){
                
                for(tData1 in responseObj[tData]){
                    count++;
            tableData +="<tr><td>"+ 'Month '+count+"</td>";
            tableData +="<td>"+ responseObj[tData][tData1]+"</td></tr>";
                }
            }

        }
        tableData += "</table></div>";

         var tableData1 = "<div class='row' style='padding:20px;'><table style='display: inline-block,width:100%;' class = 'table table-bordered table-striped table-condensed'><tr><th>Calculated Costs for"+responseObj.name+"</th></tr>";
            
            tableData1 +="<tr><td><strong>"+ 'LOAN AMOUNT =' + "</strong>"+responseObj.loanAmount+"</td></tr>";
            tableData1 +="<tr><td><strong>"+ 'MONTHLY INTEREST =' + "</strong>"+ responseObj.monthlyInterest+"</td></tr>";
            tableData1 +="<tr><td><strong>"+ 'MONTHLY PAY =' + "</strong>"+ responseObj.monthlyPay+"</td></tr>";
            tableData1 +="<tr><td><strong>"+ 'TOTAL INTEREST =' + "</strong>"+ responseObj.interest+"</td></tr>";
            tableData1 +="<tr><td><strong>"+ 'TOTAL PAYABLE =' + "</strong>"+ responseObj.totalRefund+"</td></tr>";
        
      
        tableData1 += "</table></div>";

        document.getElementById("LoanAmortization").innerHTML = tableData;
        document.getElementById("LoanAmortization1").innerHTML = tableData1;
        document.getElementById('amortization').style.display = "block";
        // document.getElementById('LoanAmortization1').style.display = "block";
    }
    document.getElementById("searchMemberForm").addEventListener("submit", searchName);
</script>
@endsection