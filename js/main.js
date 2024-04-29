function myFunction(){
    var x = document.getElementsByClassName("links");
    console.log(x[i]);
    for(var i = 0; i < x.length; i++){
        if(x[i].style.display === "block"){
            x[i].style.display = "none";
        } else{
            x[i].style.display = "block";
        }
    }
}