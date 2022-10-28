function PayWithBlockchain(state){
    let modal = document.getElementById("blockchain-deposit-modal");
    let modal_bg = document.getElementById("blockchain-deposit-modal-bg");

    modal_bg.style.display = state == 1 ? "block" : "none";
    modal.style.display = state == 1 ? "block" : "none";

}

function toggleWalletModal(state){
    let modal = document.getElementById("other-payment-options");
    let modal_bg = document.getElementById("other-payment-options-bg");

    modal_bg.style.display = state == 1 ? "block" : "none";
    modal.style.display = state == 1 ? "block" : "none";

}

function GoToOption(prev, id){
    let next = document.getElementById(id);
    let current = document.getElementById(prev);
    let loader =  document.getElementById("loader");

    current.style.display = "none";
    loader.style.display = "inline-block";

    setTimeout(()=>{
        loader.style.display = "none";
        next.style.display = "block";
    }, 3000);
}

function openModal(modal_i){
    let modal = document.getElementById(modal_i);
    modal.style.display = "block";
}


function CustomAlert(msg){
    let custom_alert = document.getElementById('custom-alert');
    custom_alert.innerText = msg;
    custom_alert.style.display = 'block';
}