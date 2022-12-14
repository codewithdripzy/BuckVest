function redirect(url) {
    let home_url = document.createElement('a')

    home_url.hidden = true;
    home_url.href = url;
    document.body.appendChild(home_url);
    home_url.click();
}

function Logout(){
    if(session_destroy()){
        redirect("../login");
    }
}


function session_destroy(){
    sessionStorage.clear();
    return true;
}
  

function deleteAccount(email){
    fetch(`../api/requests.php?request_type=delete_user&email=${email}`, {
        method : "GET",
        mode: 'no-cors',
        cache: 'no-cache',
        headers: { 'Content-type': 'application/json' }
    })
    .then(res =>{
        return res.json();
    })
    .then(res =>{
        if(res.state){
            alert("Query OK. Column Has Been deleted!");
            location.reload();
        }else{
            alert("Something went wrong! Try again.")
        }
    });
}

function verifyAccount(email){
    fetch(`../api/requests.php?request_type=verify_user&email=${email}`, {
        method : "GET",
        mode: 'no-cors',
        cache: 'no-cache',
        headers: { 'Content-type': 'application/json' }
    })
    .then(res =>{
        return res.json();
    })
    .then(res =>{
        if(res.state){
            alert("Query OK. Column Has Been Verified!");
            location.reload();
        }else{
            alert("Something went wrong! Try again.")
        }
    });
}
function verifyTransaction(token, wallet_address, transaction_type){
    fetch(`../api/requests.php?request_type=verify_transaction&wallet_address=${wallet_address}&token=${token}&transaction_type=${transaction_type}`, {
        method : "GET",
        mode: 'no-cors',
        cache: 'no-cache',
        headers: { 'Content-type': 'application/json' }
    })
    .then(res =>{
        return res.json();
    })
    .then(res =>{
        if(res.state){
            alert("Query OK. Column Has Been Verified!");
            location.reload();
        }else{
            alert("Something went wrong! Try again.")
        }
    });
}

function deleteTransaction(token, wallet_address, transaction_type){
    fetch(`../api/requests.php?request_type=delete_transaction&wallet_address=${wallet_address}&token=${token}&transaction_type=${transaction_type}`, {
        method : "GET",
        mode: 'no-cors',
        cache: 'no-cache',
        headers: { 'Content-type': 'application/json' }
    })
    .then(res =>{
        return res.json();
    })
    .then(res =>{
        if(res.state){
            alert("Query OK. Column Has Been Deleted!");
            location.reload();
        }else{
            alert("Something went wrong! Try again.")
        }
    });
}

function confirmPrompt(email){
    console.log(email);
    if(confirm('Are you sure you want to delete this record?')){
        deleteAccount(email);
    }
}

function verifyUser(email){
    if(confirm('Are you sure you want to verify this user record?')){
        verifyAccount(email);
    }
}

function verifyTransact(ref_no, wallet_address, transaction_type){
    if(confirm(`Are you sure you want to verify this ${transaction_type} record?`)){
        verifyTransaction(ref_no, wallet_address, transaction_type);
    }
}

function deleteTransact(ref_no, wallet_address, transaction_type){
    if(confirm(`Are you sure you want to delete this ${transaction_type} record?`)){
        deleteTransaction(ref_no, wallet_address, transaction_type);
    }
}
window.onload = function (){
    let sidebar_username = document.getElementById("side_bar_username");
    let sidebar_email = document.getElementById("side_bar_email");

    sidebar_username.innerText = sessionStorage.getItem("fullname").slice(0, 30) + "...";
    sidebar_email.innerText = sessionStorage.getItem("email").slice(0, 15) + "...";

    fetch("../api/admin_fetch.php?request_type=dashboard_data", {
        method : "GET",
        mode: 'no-cors',
        cache: 'no-cache',
        headers: { 'Content-type': 'application/json' }
    })
    .then(res =>{
        return res.json();
    })
    .then(res =>{
        let users = document.getElementById("users_count");
        let referral = document.getElementById("referral_count");
        let withdrawal = document.getElementById("withdrawal_count");
        let transactions = document.getElementById("transaction_count");
        let wallet = document.getElementById("wallet_gross");
        let cashflow = document.getElementById("cashflow");
        
        if(res[1].state){
            users.innerText = res[0].users;
            referral.innerText = res[0].referral;
            withdrawal.innerText = "$" + res[0].withdrawals;
            wallet.innerText = "$" + res[0].wallet_gross;
            cashflow.innerText = res[0].cashflow < 0 ? "- $" + -(parseInt(res[0].cashflow)) :  "$" + res[0].cashflow;
            transactions.innerText = res[0].transactions;
        }else{
            alert("Something went wrong! Try again.")
        }
    });



    fetch("../api/admin_fetch.php?request_type=users", {
        method : "GET",
        mode: 'no-cors',
        cache: 'no-cache',
        headers: { 'Content-type': 'application/json' }
    })
    .then(res =>{
        return res.json();
    })
    .then(res =>{
        let table = document.getElementById('users-table');

        if(res[1].state){
            for(let i = 0; i < res[0].length; i++){
                table.innerHTML += 
                `<tr ${i == 0 ? "class='active-row'" : null}>
                    <td>${res[0][i].fullname}</td>
                    <td>${res[0][i].email}</td>
                    <td>${res[0][i].status == 0 ? "Not Verified" : "Verified"}</td>
                    <td>${res[0][i].access_code}</td>
                    <td>${res[0][i].access_level}</td>
                    <td class="action-btn">
                        ${res[0][i].status == 1 ? '' : `<a onclick="verifyUser('` + res[0][i].email + `')" class="action-btn check-btn"><i class="fas fa-check"></i></a>`}
                        <a onclick="confirmPrompt('` + res[0][i].email + `')" class="action-btn delete-btn"><i class="fas fa-trash"></i></a>
                    </td>
                    <td>${res[0][i].created}</td>
                </tr>`
            }
        }else{
            alert("Something went wrong! Try again.")
        }
    });


    fetch("../api/admin_fetch.php?request_type=investments", {
        method : "GET",
        mode: 'no-cors',
        cache: 'no-cache',
        headers: { 'Content-type': 'application/json' }
    })
    .then(res =>{
        return res.json();
    })
    .then(res =>{
        if(res[1].state){
            for(let i = 0; i < res[0].length; i++){
            }
        }else{
            alert("Something went wrong! Try again.")
        }
    });

    fetch("../api/admin_fetch.php?request_type=refferals", {
        method : "GET",
        mode: 'no-cors',
        cache: 'no-cache',
        headers: { 'Content-type': 'application/json' }
    })
    .then(res =>{
        return res.json();
    })
    .then(res =>{
        let table = document.getElementById("table-content");
        
        if(res[1].state){
            for(let i = 0; i < res[0].length; i++){
                table.innerHTML += 
                `<tr ${i == 0 ? "class='active-row'" : null}>
                    <td>${res[0][i].fullname}</td>
                    <td>${res[0][i].email}</td>
                    <td>${res[0][i].status == 0 ? "Not Verified" : "Verified"}</td>
                    <td>${res[0][i].referrer_name}</td>
                    <td>${res[0][i].referrer_email}</td>
                    <td>${res[0][i].created}</td>
                </tr>`
            }
        }else{
            alert("Something went wrong! Try again.")
        }
    });



    fetch("../api/admin_fetch.php?request_type=deposit", {
        method : "GET",
        mode: 'no-cors',
        cache: 'no-cache',
        headers: { 'Content-type': 'application/json' }
    })
    .then(res =>{
        return res.json();
    })
    .then(res =>{
        let table = document.getElementById("deposit-table");
        
        if(res[1].state){
            for(let i = 0; i < res[0].length; i++){
                table.innerHTML += 
                `<tr ${i == 0 ? "class='active-row'" : null}>
                    <td class='hover-tooltip'>${res[0][i].reference_number.slice(0, 10) + '...'}<span>${res[0][i].reference_number}</span></td>
                    <td class='hover-tooltip'>${res[0][i].payment_method.slice(0, 10) + '...'}<span>${res[0][i].payment_method}</span></td>
                    <td class='hover-tooltip'>${res[0][i].wallet_address.slice(0, 10) + '...'}<span>${res[0][i].wallet_address}</span></td>
                    <td class='hover-tooltip'>${res[0][i].fullname.slice(0, 10) + '...'}<span>${res[0][i].fullname}</span></td>
                    <td class='hover-tooltip'>${res[0][i].email.slice(0, 10) + '...'}<span>${res[0][i].email}</span></td>
                    <td>${res[0][i].amount}</td>
                    <td>${res[0][i].status == 0 ? "Not Verified" : "Verified"}</td>
                    <td class="action-btn">
                        ${res[0][i].status == 0 ? `<a onclick="verifyTransact('` + res[0][i].reference_number + `', '` + res[0][i].wallet_address + `', 'deposit')" class="action-btn check-btn"><i class="fas fa-check"></i></a>` : ''}
                        <a onclick="deleteTransact('` + res[0][i].reference_number + `', '` + res[0][i].wallet_address + `', 'deposit')" class="action-btn delete-btn"><i class="fas fa-trash"></i></a>
                    </td>
                    <td>${res[0][i].created}</td>
                </tr>`
            }
        }else{
            alert("Something went wrong! Try again.")
        }
    });

    // withdrawal-table

    fetch("../api/admin_fetch.php?request_type=transactions", {
        method : "GET",
        mode: 'no-cors',
        cache: 'no-cache',
        headers: { 'Content-type': 'application/json' }
    })
    .then(res =>{
        return res.json();
    })
    .then(res =>{
        let table = document.getElementById("transaction-table");
        
        if(res[1].state){
            for(let i = 0; i < res[0].length; i++){
                table.innerHTML += 
                `<tr ${i == 0 ? "class='active-row'" : null}>
                    <td class='hover-tooltip'>${res[0][i].from_wallet_address.slice(0, 10) + '...'}<span>${res[0][i].from_wallet_address}</span></td>
                    <td class='hover-tooltip'>${res[0][i].to_wallet_address.slice(0, 10) + '...'}<span>${res[0][i].to_wallet_address}</span></td>
                    <td class='hover-tooltip'>${res[0][i].description.slice(0, 10) + '...'}<span>${res[0][i].description}</span></td>
                    <td class='hover-tooltip'>${res[0][i].token.slice(0, 10) + '...'}<span>${res[0][i].token}</span></td>
                    <td>${res[0][i].amount}</td>
                    <td>${res[0][i].status == 0 ? "Not Verified" : "Verified"}</td>
                    <td class="action-btn">
                        ${res[0][i].status == 0 ? `<a onclick="verifyTransact('`+ res[0][i].token + `', '` + res[0][i].to_wallet_address + `', 'transfer')" class="action-btn check-btn"><i class="fas fa-check"></i></a>` : ''}
                        <a onclick="deleteTransact('`+ res[0][i].token + `', '` + res[0][i].to_wallet_address + `', 'transfer')" class="action-btn delete-btn"><i class="fas fa-trash"></i></a>
                    </td>
                    <td>${res[0][i].created}</td>
                </tr>`
            }
        }else{
            alert("Something went wrong! Try again.")
        }
    });

    fetch("../api/admin_fetch.php?request_type=withdrawals", {
        method : "GET",
        mode: 'no-cors',
        cache: 'no-cache',
        headers: { 'Content-type': 'application/json' }
    })
    .then(res =>{
        return res.json();
    })
    .then(res =>{
        let table = document.getElementById("withdrawal-table");
        
        if(res[1].state){
            for(let i = 0; i < res[0].length; i++){
                table.innerHTML += 
                `<tr ${i == 0 ? "class='active-row'" : null}>
                    <td class='hover-tooltip'>${res[0][i].token.slice(0, 10) + '...'}<span>${res[0][i].token}</span></td>
                    <td class='hover-tooltip'>${res[0][i].payment_method.slice(0, 10) + '...'}<span>${res[0][i].payment_method}</span></td>
                    <td class='hover-tooltip'>${res[0][i].wallet_address.slice(0, 10) + '...'}<span>${res[0][i].wallet_address}</span></td>
                    <td class='hover-tooltip'>${res[0][i].fullname.slice(0, 10) + '...'}<span>${res[0][i].fullname}</span></td>
                    <td class='hover-tooltip'>${res[0][i].email.slice(0, 10) + '...'}<span>${res[0][i].email}</span></td>
                    <td>${res[0][i].amount}</td>
                    <td>${res[0][i].status == 0 ? "Not Verified" : "Verified"}</td>
                    <td class="action-btn">
                        ${res[0][i].status == 0 ? `<a onclick="verifyTransact('` + res[0][i].token + `', '` + res[0][i].wallet_address + `', 'withdrawal')" class="action-btn check-btn"><i class="fas fa-check"></i></a>` : ''}
                        ${res[0][i].status == 0 ? `<a onclick="deleteTransact('` + res[0][i].token + `', '` + res[0][i].wallet_address + `', 'withdrawal')" class="action-btn delete-btn"><i class="fas fa-trash"></i></a>` : ''}
                    </td>
                    <td>${res[0][i].created}</td>
                </tr>`
            }
        }else{
            alert("Something went wrong! Try again.")
        }
    });
}