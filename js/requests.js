function LoginRequest(email, password) {
  fetch('./api/login.php?email=' + email + '&password=' + password, {
    method: 'GET',
    mode: 'no-cors',
    cache: 'no-cache',
    headers: { 'Content-type': 'application/json' },
  })
  .then((response) => {
    return response.json()
  })
  .then((data) => {
    if(data.state == false || data.err == 404){
      showAlert('alert-danger', data.message);
    }else{
      showAlert('alert-success', data.message);
      session_start(data);
    }
    //!data.state && data.err == 404 ? showAlert('alert-danger', data.message) : session_start(data);
  });
}

function SignupRequest(fullname, email, password) {
  let referral;

  if(sessionStorage.getItem("referral_email") != null || sessionStorage.getItem("referral_email") != undefined || sessionStorage.getItem("referral_email") != ""){
    referral = "?referral=" + sessionStorage.getItem("referral_email") + "&";
  }else{
    referral = "?"
  }

  fetch("./api/createAccount.php" + referral + "fullname=" + fullname + "&email=" + email + "&password=" + password, {
    method: 'GET',
    mode: 'no-cors',
    cache: 'no-cache',
    headers: { 'Content-type': 'application/json' }
  })
  .then(response  => {
    return response.json();
  }
  ).then(res =>{
    console.log(res);
    if(!res.state){
      showAlert('alert-danger', res.message);
    }else{
      showAlert('alert-safe', res.message + " You'll be redirected.");
      sessionStorage.clear();
      
      setTimeout(()=>{
        redirect('./verify');
      }, 3000);
    }
  })
}

function EmailExistsRequest(email){
  fetch("./api/EmailValidation.php?email=" + email, {
    method: 'GET',
    mode: 'no-cors',
    cache: 'no-cache',
    headers: { 'Content-type': 'application/json' }
  })
  .then(response  => {
    return response.json();
  }
  ).then(res =>{
    if(!res.state){
      showAlert('alert-danger', res.message);
    }else{
      let alert = document.getElementById("alert");
      alert.classList.remove("show");
    }
  })
}

function TransferCryptoRequest(wallet_address, amount){
  fetch(`./api/transfer.php?my_wallet_address=${sessionStorage.getItem('wallet_address')}&wallet_address=${wallet_address}&amount=${amount}&user_id=${sessionStorage.getItem('id')}&token=${sessionStorage.getItem('wallet_key')}`, 
  {
    method : 'GET',
    mode: 'no-cors',
    cache: 'no-cache',
    headers: { 'Content-type': 'application/json' }
  }).then((res)=>{
    return res.json();
  })
  .then((res)=>{
      alert(res.msg)
      let btn = document.getElementById('transferCryptoBtn');
      btn.disabled = false;
      location.reload();
  })
}

function showAlert(type, message){
  let alert = document.getElementById("alert");
  alert.innerHTML = message;
  
  switch (type) {
    case 'alert-danger':
      alert.classList.add('alert-danger');
      break;
    case 'alert-caution':
      alert.classList.add('alert-caution');
      break;
    case 'alert-safe':
      alert.classList.add('alert-safe');
      break; 
    default:
      alert.classList.add('alert-info');
      break;
  }
  alert.classList.add('show');
}

function session_start(data){
  if (createSession(data)) {
    if(data.access_level == 'user' && data.status == 1){
      redirect('./dashboard');
    }else if(data.access_level == 'admin' && data.status == 1){
      redirect('./admin/dashboard');
    }
  }
}

function session_destroy(){
  sessionStorage.clear();
  return true;
}

function createSession(data) {
  sessionStorage.setItem('id', data.id);
  sessionStorage.setItem('fullname', data.fullname);
  sessionStorage.setItem('email', data.email);
  sessionStorage.setItem('access_code', data.access_code);
  sessionStorage.setItem('access_level', data.access_level);
  sessionStorage.setItem('created', data.created);
  sessionStorage.setItem('modified', data.modified);
  sessionStorage.setItem('state', data.state);

  return true;
}

function redirect(url) {
  let home_url = document.createElement('a')

  home_url.hidden = true;
  home_url.href = url;
  document.body.appendChild(home_url);
  home_url.click();
}

function Logout(){
  if(session_destroy()){
    redirect("./login");
  }
}

