let req_res;

window.addEventListener("load", ()=>{
    let sidebar_usernames = [document.getElementById("side_bar_username"), document.getElementById("profile_username")];
    let sidebar_email = document.getElementById("side_bar_email");
    let refferal_link = document.getElementById("refferalLink");
    let wallet_balance = document.getElementById("wallet-balance");
    let referral_bonus = document.getElementById("referral-balance");
    let wallet_address = document.getElementById("wallet-address-text")
    let earnings = document.getElementById("earnings");


    // ------------------------------- wallet balance
    fetch("./api/fetch.php?request_type=wallet_balance&user_id=" + sessionStorage.getItem('id'), {
        method : "POST",
        mode: 'no-cors',
        cache: 'no-cache',
        headers: { 'Content-type': 'application/json' }
    })
    .then(res =>{
        return res.json();
    })
    .then(res =>{
        wallet_balance.innerText = '$' + res.balance;
        if(res.state){
            sessionStorage.setItem('wallet_address', res.public_wallet_address);
            sessionStorage.setItem('wallet_type', res.wallet_type);
            sessionStorage.setItem('wallet_key', res.wallet_key)
            sessionStorage.setItem('created', res.created);
            sessionStorage.setItem('status', res.status);
        }else{
            alert("Somethig went wrong! Try again.")
        }
    });


    // -------------------------------- earnings

    fetch("./api/fetch.php?request_type=earnings&user_id=" + sessionStorage.getItem('id'), {
        method : "POST",
        mode: 'no-cors',
        cache: 'no-cache',
        headers: { 'Content-type': 'application/json' }
    })
    .then(res =>{
        return res.json();
    })
    .then(res =>{
        let total_earnings = 0;
        if(res[1].state){
            for(let i = 0; i < res[0].length; i++){
                total_earnings += parseInt(res[0][i].amount);
            }
            earnings.innerText = '$' + total_earnings;
        }else{
            // showAlert('alert-danger', res.message);
            alert("Something went wrong! Try again.")
        }
    });

    // -------------------------------- referral Bonus
    fetch("./api/fetch.php?request_type=referral_bonus&user_id=" + sessionStorage.getItem('id'), {
        method : "POST",
        mode: 'no-cors',
        cache: 'no-cache',
        headers: { 'Content-type': 'application/json' }
    })
    .then(res =>{
        return res.json();
    })
    .then(res =>{
        let bonus = 0;
        if(res[1].state){
            for(let i = 0; i < res[0].length; i++){
                bonus += parseInt(res[0][i].bonus);
            }
            referral_bonus.innerText = '$' + bonus;
        }else{
            alert("Something went wrong! Try again.")
        }
    });

    // deposit-table
    fetch("./api/fetch.php?request_type=get_transaction&user_id=" + sessionStorage.getItem('id') + "&transaction_type=deposit", {
        method : "POST",
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
                table.innerHTML += `<tr ${i == 0 ? `class="active-row"` : ""}>
                    <td>${res[0][i].token}</td>
                    <td>${res[0][i].amount}</td>
                    <td>${res[0][i].status == 0 ? "<i>Pending...</i>" : "Verified"}</td>
                    <td>${res[0][i].created}</td>
                </tr>`;
            }
        }else{
            alert("Something went wrong! Try again.")
        }
    });

    fetch("./api/fetch.php?request_type=get_transaction&user_id=" + sessionStorage.getItem('id') + "&transaction_type=withdrawal", {
        method : "POST",
        mode: 'no-cors',
        cache: 'no-cache',
        headers: { 'Content-type': 'application/json' }
    })
    .then(res =>{
        return res.json();
    })
    .then(res =>{
        let table = document.getElementById("widthdrawal-table");

        if(res[1].state){
            for(let i = 0; i < res[0].length; i++){
                table.innerHTML += `<tr ${i == 0 ? `class="active-row"` : ""}>
                    <td>${res[0][i].token}</td>
                    <td>${res[0][i].amount}</td>
                    <td>${res[0][i].status == 0 ? "<i>Pending...</i>" : "Verified"}</td>
                    <td>${res[0][i].created}</td>
                </tr>`;
            }
        }else{
            alert("Something went wrong! Try again.")
        }
    });


    fetch("./api/fetch.php?request_type=my_referrals&user_id=" + sessionStorage.getItem('id'), {
        method : "POST",
        mode: 'no-cors',
        cache: 'no-cache',
        headers: { 'Content-type': 'application/json' }
    })
    .then(res =>{
        return res.json();
    })
    .then(res =>{
        if(res[1].state){
            let list  = document.getElementById('my-referrals');

            for(let i = 0; i < res[0].length; i++){
                let tr = document.createElement('tr');
                let img_row = document.createElement('td');
                let name_row = document.createElement('td');
                let status_row = document.createElement('td');
                let created_row = document.createElement('td');

                name_row.innerText = res[0][i].fullname;

                if(res[0][i].status == 0){
                    status_row.innerText = 'not verified';
                }else{
                    status_row.innerText = 'verified';
                }

                created_row.innerText = res[0][i].created;

                tr.appendChild(name_row);
                tr.appendChild(status_row);
                tr.appendChild(created_row);

                list.appendChild(tr);
            }
            // console.log(bonus);
            // referral_bonus.innerText = '$' + bonus;
        }else{
            // showAlert('alert-danger', res.message);
            alert("Something went wrong! Try again.")
        }
    });
    // wallet_balance.innerText = "$" + fetchData({fetch : "wallet_balance", user_id : sessionStorage.getItem("id")})
    sidebar_usernames.forEach(e=>{
        e.innerText = sessionStorage.getItem("fullname");
    })

    if(sessionStorage.getItem("email").length > 15){
        let text = sessionStorage.getItem("email");
        sidebar_email.innerText = text.substring(0, 15) + "...";
    }else{
        sidebar_email.innerText = sessionStorage.getItem("email");
    }

    let referral_url = "http://buckvest.com/";

    // refferal_link.innerText = referral_url + "referral?user=" + sessionStorage.getItem("email");
    wallet_address.innerText = sessionStorage.getItem("wallet_address").slice(0, 35) + "...";
})

function fetchData(params){
    let url = "./api/fetch.php?";
    let keys = Object.entries(params);
    
    for(let i = 0; i < keys.length; i++){
        if(i == (keys.length - 1)){
            url += keys[i][0] + '=' + keys[i][1];
        }else{
            url += keys[i][0] + '=' + keys[i][1] + '&';
        }
    }
 
    fetch(url, {
        method : "POST",
        mode: 'no-cors',
        cache: 'no-cache',
        headers: { 'Content-type': 'application/json' }
    })
    .then(res =>{
        return res.json();
    })
    .then(res =>{
        setResponse(res)
    });
}

function setResponse(response){
    req_res = response;
}
function CopyReferralLink(e){
    navigator.clipboard.writeText(e.innerText)
    alert("Link has been copied to clipboard!");
}

function CopyWalletAddress(e){
    navigator.clipboard.writeText(e)
    alert("Wallet Address has been copied to clipboard!");
}

function verifyUSDTPayment(){
    let usdt_container = document.getElementById("wallet-address-input");
    let usdt_propcontainer = document.getElementById("usdt-info");
    let usdt_verified = document.getElementById("wallet-usdt-req");

    if(usdt_container.value == null || usdt_container.value == "" ||  usdt_container.value == undefined){
        alert("Unable to verify payment! Enter the wallet address you used to transfer the USDT so we can verify your payment!");
    }else{

        fetch("./api/requests.php?request_type=deposits&user_id=" + sessionStorage.getItem('id'), {
            method : "POST",
            mode: 'no-cors',
            cache: 'no-cache',
            headers: { 'Content-type': 'application/json' }
        })
        .then(res =>{
            return res.json();
        })
        .then(res =>{
            usdt_propcontainer.style.display = "none";
            usdt_verified.style.display = "block";
        });
    }
}


function verifyBTCPayment(){
    let btc_container = document.getElementById("wallet-address-input");
    let btc_propcontainer = document.getElementById("btc-info");
    let btc_verified = document.getElementById("wallet-btc-req");

    if(btc_container.value == null || btc_container.value == "" ||  btc_container.value == undefined){
        alert("Unable to verify payment! Enter the wallet address you used to transfer the Bitcoin so we can verify your payment!");
    }else{

        fetch("./api/requests.php?request_type=deposits&user_id=" + sessionStorage.getItem('id'), {
            method : "POST",
            mode: 'no-cors',
            cache: 'no-cache',
            headers: { 'Content-type': 'application/json' }
        })
        .then(res =>{
            return res.json();
        })
        .then(res =>{
            btc_propcontainer.style.display = "none";
            btc_verified.style.display = "block";
        });
    }
}


function closeModal(modal){
    let modal_ui = document.getElementById(modal);
    modal_ui.style.display = "none";
}
function rel(){
    location.reload();
}