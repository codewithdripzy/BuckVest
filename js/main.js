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
            // showAlert('alert-danger', res.message);
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
            alert("Somethig went wrong! Try again.")
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
            // console.log(bonus);
            referral_bonus.innerText = '$' + bonus;
        }else{
            // showAlert('alert-danger', res.message);
            alert("Somethig went wrong! Try again.")
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
        console.log(res);
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
                    status_row.innerText = 'verified';
                }else{
                    status_row.innerText = 'not verified';
                }

                created_row.innerText = res[0][i].created;

                tr.appendChild(name_row);
                tr.appendChild(status_row);
                tr.appendChild(created_row);

                list.appendChild(tr);
            }
            // console.log(bonus);
            referral_bonus.innerText = '$' + bonus;
        }else{
            // showAlert('alert-danger', res.message);
            alert("Somethig went wrong! Try again.")
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

    let referral_url = "http://localhost/ElonBTC/";

    refferal_link.innerText = referral_url + "referral?user=" + sessionStorage.getItem("email");
    wallet_address.innerText = sessionStorage.getItem("wallet_address").slice(0, 20) + "...";
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