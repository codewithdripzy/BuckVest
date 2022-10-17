function PayWithBitcoin(wallet_address, amount){
    fetch("http://api.blockchain.com", {
        body : {
            wallet_address : wallet_address,
            amount :amount
        }
    }, (e)=>{
            
    })
}