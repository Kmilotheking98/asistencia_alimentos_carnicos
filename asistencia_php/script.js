const body = document.querySelector('body');
const sidebar = body.querySelector('nav');
const toggle = body.querySelector(".toggle");
const searchBtn = body.querySelector(".search-box");
const modeSwitch = body.querySelector(".toggle-switch");
const modeText = body.querySelector(".mode-Dark");

load();
toggle.addEventListener("click" , () =>{
    sidebar.classList.toggle("close");
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
function store(value) {
    localStorage.setItem('dark', value)
}