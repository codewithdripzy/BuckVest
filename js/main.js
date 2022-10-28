let req_res;

window.addEventListener("load", ()=>{
    let sidebar_usernames = [document.getElementById("side_bar_username"), document.getElementById("profile_username")];
    let sidebar_email = document.getElementById("side_bar_email");
    let refferal_link = document.getElementById("refferalLink");
    let wallet_balance = document.getElementById("wallet-balance");
    let referral_bonus = document.getElementById("referral-balance");
    let wallet_address = document.getElementById("wallet-address-text")
    let earnings = document.getElementById("earnings");
    let available_balance = document.getElementById("wallet-available-balance")
    let email = document.getElementById("user_email");

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
        email.innerText = sessionStorage.getItem('email');
        wallet_balance.innerText = '$' + res.balance;
        available_balance.innerText = '$' + res.balance;
        wallet_address.innerText = res.public_wallet_address.slice(0,30) + '...';
        
        if(res.state){
            sessionStorage.setItem('wallet_address', res.public_wallet_address);
            sessionStorage.setItem('wallet_type', res.wallet_type);
            sessionStorage.setItem('wallet_key', res.wallet_key);
            sessionStorage.setItem('balance', res.balance);
            sessionStorage.setItem('created', res.created);
            sessionStorage.setItem('status', res.status);
        }else{
            CustomAlert("Somethig went wrong! Try again.")
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
            // showAlert('CustomAlert-danger', res.message);
            CustomAlert("Something went wrong! Try again.")
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
            CustomAlert("Something went wrong! Try again.")
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
                table.innerHTML += `<tr ${i == 0 ? `class="active-row"` : ``}>
                    <td>${res[0][i].token}</td>
                    <td>${res[0][i].amount}</td>
                    <td>${res[0][i].status == 0 ? "<i>Pending...</i>" : "Verified"}</td>
                    <td>${res[0][i].created}</td>
                </tr>`;
            }
        }else{
            CustomAlert("Something went wrong! Try again.")
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
            CustomAlert("Something went wrong! Try again.")
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
            // showAlert('CustomAlert-danger', res.message);
            CustomAlert("Something went wrong! Try again.")
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
    CustomAlert("Link has been copied to clipboard!");
}

function CopyWalletAddress(e){
    navigator.clipboard.writeText(e)
    CustomAlert("Wallet Address has been copied to clipboard!");
}

function verifyUSDTPayment(){
    let usdt_container = document.getElementById("wallet-address-usdt");
    let usdt_propcontainer = document.getElementById("usdt-info");
    let usdt_verified = document.getElementById("wallet-usdt-req");
    let amount = document.getElementById("deposit-amount").value;

    if(usdt_container.value == null || usdt_container.value == "" || usdt_container.value == undefined){
        CustomAlert("Unable to verify payment! Enter the wallet address you used to transfer the USDT so we can verify your payment!");
    }else{
        if(isNaN(parseFloat(amount)) || amount > 1000000000 || parseFloat(amount) == null || parseFloat(amount) == undefined){
            CustomAlert("Enter a valid and true Amount");
        }else{
            fetch("./api/requests.php?request_type=deposit&from_wallet_address=" + usdt_container.value + "&to_wallet_address="+ sessionStorage.getItem('wallet_address') + "&amount=" + parseFloat(amount) + "&user_id=" + sessionStorage.getItem('id'), {
                method : "POST",
                mode: 'no-cors',
                cache: 'no-cache',
                headers: { 'Content-type': 'application/json' }
            })
            .then(res =>{
                return res.json();
            })
            .then(res =>{
                if(res.state){
                    usdt_propcontainer.style.display = "none";
                    usdt_verified.style.display = "block";
                }else{
                    CustomAlert(res.msg)
                }
            });
        }
    }
}


function verifyBTCPayment(){
    let btc_container = document.getElementById("wallet-address-input");
    let btc_propcontainer = document.getElementById("btc-info");
    let amount = document.getElementById("btc-deposit-amount").value;
    let btc_verified = document.getElementById("wallet-btc-req");
    console.log(amount);
    if(btc_container.value == null || btc_container.value == "" ||  btc_container.value == undefined){
        CustomAlert("Unable to verify payment! Enter the wallet address you used to transfer the Bitcoin so we can verify your payment!");
    }else{
        if(btc_container.value == null || btc_container.value == "" || btc_container.value == undefined){
            CustomAlert("Unable to verify payment! Enter the wallet address you used to transfer the USDT so we can verify your payment!");
        }else{
            if(isNaN(parseInt(amount)) || amount > 1000000000 || parseInt(amount) == null || parseInt(amount) == undefined){
                CustomAlert("Enter a valid and true Amount");
            }else{
                fetch("./api/requests.php?request_type=deposit&from_wallet_address=" + btc_container.value + "&to_wallet_address="+ sessionStorage.getItem('wallet_address') + "&amount=" + parseFloat(amount) + "&user_id=" + sessionStorage.getItem('id'), {
                    method : "POST",
                    mode: 'no-cors',
                    cache: 'no-cache',
                    headers: { 'Content-type': 'application/json' }
                })
                .then(res =>{
                    return res.json();
                })
                .then(res =>{
                    if(res.state){
                        btc_propcontainer.style.display = "none";
                        btc_verified.style.display = "block";
                    }else{
                        CustomAlert(res.msg)
                    }
                });
            }
        }
    }
}


function closeModal(modal){
    let modal_ui = document.getElementById(modal);
    modal_ui.style.display = "none";
}

function rel(){
    location.reload();
}

function togglePaymentPipeLine(){
    let payment_method = document.getElementById("payment_method");
    let wallet_address = document.getElementById("crypto_pipeline");
    let paypal = document.getElementById("paypal_pipeline");

    if(payment_method.value == "null" || payment_method.value == undefined || payment_method.value == null || payment_method.value == ""){
        CustomAlert("Select a valid Payment Method");
    }else{
        if(payment_method.value == "USDT" || payment_method.value == "BTC"){
            wallet_address.style.display = "block";
            paypal.style.display = "none";
        }else if(payment_method.value == "PP"){
            wallet_address.style.display = "none";
            paypal.style.display = "block";
        }else{
            wallet_address.style.display = "none";
            paypal.style.display = "none";
        }
    }
}

function withdrawAmount(){
    let wallet_address = sessionStorage.getItem("wallet_address");
    let payment_method = document.getElementById("payment_method");
    let amount = document.getElementById("withdrawal-mount").value;
    let modal = document.getElementById("wallet-btc-withdrawal");
    let modal_cont = document.getElementById("withdrawal-cont");

    let payment_address;

    function CustomAlert(msg){
        let custom_alert = document.getElementById('custom-alert');
        custom_alert.innerText = msg;
        custom_alert.style.display = 'block';
    }

    if(payment_method.value == "USDT" || payment_method.value == "BTC"){
        payment_address = document.getElementById("crypto_pipe");
    }else if(payment_method.value == "PP"){
        payment_address = document.getElementById("paypal_pipe");
    }else{
        payment_address = null;
    }
    
    if(wallet_address == null || wallet_address == "" ||  wallet_address == undefined){
        CustomAlert("Unable to request payment! Try Logging in again or contact the admin if this issue repeates itself");
    }else{
        if(payment_method.value == null || payment_method.value == "" || payment_method.value == undefined){
            CustomAlert("Unable to request payment! Choose a Payment Method!");
        }else{
            if(payment_address.value == null || payment_address.value == "" || payment_address.value == undefined){
                CustomAlert("Unable to request payment! Enter a valid Payment Address!");
            }else{
                if(isNaN(parseInt(amount)) || amount > 1000000000 || parseInt(amount) == null || parseInt(amount) == undefined){
                    CustomAlert("Enter a valid and true Amount to withdraw");
                }else{
                    if(parseInt(amount) > sessionStorage.getItem("balance")){
                        CustomAlert("Your wallet balance is to low to withdraw this amount");
                    }else{
                        fetch("./api/requests.php?request_type=withdrawal&to_wallet_address=" + wallet_address + "&wallet_address="+ sessionStorage.getItem('wallet_address') + "&amount=" + parseFloat(amount) + "&user_id=" + sessionStorage.getItem('id'), {
                            method : "POST",
                            mode: 'no-cors',
                            cache: 'no-cache',
                            headers: { 'Content-type': 'application/json' }
                        })
                        .then(res =>{
                            return res.json();
                        })
                        .then(res =>{
                            if(res.state){
                                modal_cont.style.display = "none";
                                modal.style.display = "block";
                            }else{
                                CustomAlert(res.msg)
                            }
                        });
                    }
                }
            }
        }
    }
}

function investplan(plan){
    if(plan == 'BSP' || plan == 'PRP' || plan == 'ETP'){
        let balance = sessionStorage.getItem('balance');
        amount = parseInt(prompt('How much would you like to Invest?'));
        
        if(amount == null || amount == undefined || amount == '' || amount == 0 || isNaN(amount)){
            CustomAlert('Invalid Amount Entered! Try again!');
        }else{
            if(plan == 'BSP' && balance < 50 || plan == 'PRP' && balance < 1000 || plan == 'ETP' && balance < 10000){
                CustomAlert('Your wallet balance is too low to invest in this plan! Load your wallet and try again.');
            }else{
                if(plan == 'BSP' && amount > 500 || plan == 'PRP' && balance > 10000){
                    CustomAlert('The amount you entered is to large for this plan! Try upgrading to another plan that suit you best.');
                }else{
                    fetch("./api/requests.php?request_type=invest&wallet_address=" + sessionStorage.getItem('wallet_address')+ "&plan=" + plan + "&user_id=" + sessionStorage.getItem('id') + "&amount=" + amount, {
                        method : "POST",
                        mode: 'no-cors',
                        cache: 'no-cache',
                        headers: { 'Content-type': 'application/json' }
                    })
                    .then(res =>{
                        return res.json();
                    })
                    .then(res =>{
                        if(res.state){
                            CustomAlert(plan == 'BSP' ? 'You have sucessfully invested in basic plan!' : plan == 'PRP' ? 'You have sucessfully invested in pro plan!' : plan == 'ETP' ? 'You have sucessfully invested in Ethusiast plan!' : 'Something went wrong!');
                            setTimeout(()=>{
                                rel();
                            }, 3000);
                        }else{
                            CustomAlert(res.msg)
                        }
                    });
                }
            }
        }
        
    }else{
        CustomAlert('Enter a valid Plan!')
    }
    
}

function CustomAlert(msg){
    let custom_alert = document.getElementById('custom-alert');
    custom_alert.innerText = msg;
    custom_alert.style.display = 'block';
}