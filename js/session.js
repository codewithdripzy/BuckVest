// emmafikayomi2004@gmail.com
if(sessionStorage.getItem("state") == null || sessionStorage.getItem("state") == undefined || !sessionStorage.getItem("state")){
    Logout();
}else{
    // do nothing, session is valid
    // console.log(sessionStorage);
}
