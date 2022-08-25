const body = document.querySelector('body');
const sidebar = body.querySelector('nav');
const toggle = body.querySelector(".toggle");
const searchBtn = body.querySelector(".search-box");
const modeSwitch = body.querySelector(".toggle-switch");
const modeText = body.querySelector(".mode-Dark");

load();
loadtogle();
toggle.addEventListener("click" , () =>{
    sidebar.classList.toggle("close");
    storetogle(sidebar.classList.contains("close"))
})

searchBtn.addEventListener("click" , () =>{
    sidebar.classList.remove("close");
})

modeSwitch.addEventListener("click" , ()=>{
    body.classList.toggle("dark");
    store(body.classList.contains("dark"))

    if(body.classList.contains("dark")){
        modeText.innerText = "Dark mode";
    }else{
        modeText.innerText = "Dark mode";

    }
});

console.log(body)

function load() {
    const darkmode = localStorage.getItem("dark")

    if(!darkmode){
        store('false')
    }else if(darkmode=='true'){
        body.classList.add('dark')
    }

}
function loadtogle() {
    const toglemode = localStorage.getItem("close")

    if(!toglemode){
        storetogle('true')
    }else if(toglemode=='false'){
        sidebar.classList.toggle("close")
    }
}

function store(value) {
    localStorage.setItem('dark', value)

}
function storetogle(value) {
    localStorage.setItem('close', value)
}