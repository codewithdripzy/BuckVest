function PayWithBitcoin(wallet_address, amount){
    fetch("http://api.blockchain.com", {
        body : {
            wallet_address : wallet_address,
            amount :amount
        }
    }, (e)=>{
            
    })
}

function toggleWalletModal(state){
    let modal = document.getElementById("other-payment-options");
    let modal_bg = document.getElementById("other-payment-options-bg");

    
    modal_bg.style.display = state == 1 ? "block" : "none";
    modal.style.display = state == 1 ? "block" : "none";


}