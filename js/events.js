function Login() {
  let email = document.getElementById('email').value;
  let password = document.getElementById('password').value;

  LoginRequest(email, password);
}

function checkPasswordLength(){
  let psw = document.getElementById('rgstpsw');
  let alert = document.getElementById("alert");

  if(psw.value.length < 8){
    showAlert("alert-caution", "Password must not be less than 8 characthers");
  }else{
    alert.classList.remove("show");
  }
}

function validatePassword(){
  let psw = document.getElementById('rgstpsw');
  let confirmpassword = document.getElementById('confirmpsw');
  let alert = document.getElementById("alert");

  if (psw.value != confirmpassword.value) {
    showAlert('alert-caution', "The passwords you provided do not match!");
  }else{
    alert.classList.remove("show");
  }
}

function SignUp() {
  let fullname = document.getElementById('fullname');
  let email = document.getElementById('email');
  let psw = document.getElementById('rgstpsw');
  let confirmpassword = document.getElementById('confirmpsw');
  let alert = document.getElementById('alert');

  if(fullname.value != null && email.value != null && psw.value != null && confirmpassword.value != null){
    if (psw.value.length >= 8) {
      if (psw.value != confirmpassword.value) {
        showAlert('alert-danger', "The passwords you provided do not match!");
      } else {
        SignupRequest(fullname.value, email.value, psw.value)
      }
    } else {
      alert.innerHTML = "<i class='fa fa-info-circle'></i> Password must not be less than 8 characters"
      alert.style.display = 'block'
      alert.classList.add('alert-danger')
    }
  }
}

function ValidateEmail(){
  let email = document.getElementById('email');
  EmailExistsRequest(email.value);
}

function disableButton(button){
  button.disabled = true;
}

function TransferCrypto(){
  let wallet_address = document.getElementById('transfer-wallet-address').value;
  let amount = document.getElementById('transfer-amount').value;
  let btn = document.getElementById('transferCryptoBtn');
  disableButton(btn);
  if(confirm(`Send $${amount} to ${wallet_address}`)){
    TransferCryptoRequest(wallet_address, amount)
  }
}