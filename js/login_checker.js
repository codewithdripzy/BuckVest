// emmafikayomi2004@gmail.com
if(sessionStorage.getItem("state") == null || sessionStorage.getItem("state") == undefined || !sessionStorage.getItem("state")){
    // logout();
    // console.log(sessionStorage.getItem("state"));
}else{
    // do nothing, session is valid
    redirect("./dashboard.html");
}
