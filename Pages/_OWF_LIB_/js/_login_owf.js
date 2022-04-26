const bottom_text = document.querySelector(".bottom p");
const pc = document.querySelector(".passcode");
const ky = document.querySelector(".auth-key");
const key_text = document.querySelector(".key-class p");

function btnLoginWEffect(){
    if(pc.value != "" && ky.files.length > 0){
        bottom_text.style.opacity = 1;
    }else{
        bottom_text.style.opacity = 0.1;
    }
}

pc.addEventListener("keyup",() => {
    btnLoginWEffect();
})

pc.addEventListener("keydown",() => {
    btnLoginWEffect();
})

ky.addEventListener("change",() => {
    btnLoginWEffect();
    if(ky.files.length > 0){
        key_text.style.opacity = 1;
    }else{
        key_text.style.opacity = 0.1;
    }
})