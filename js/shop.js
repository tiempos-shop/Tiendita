
function go(url){
    window.location.href=url;
}
function changeImage(imageElement,image){
    imageElement.src=image;
    imageElement.style.cursor="pointer";
}
function view(str){
    let id=str; //str.replace("_", "\'");
    go("view.php?id="+id);
}
function filter(){
    let s=document.getElementById("s");
    let smenu=document.getElementById("sMenu");
    s.style.display="none";
    smenu.style.display="block";
}
