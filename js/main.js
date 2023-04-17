// burger menu
console.log('coucou');

const navElt = document.querySelector(".Header-nav-link");
const burgerElt = document.querySelector("#burger");

burgerElt.addEventListener("click", function(){
    console.log("coucou");
    //Si le UserMenu contient la classe active
    if (navElt.classList.contains("active")){
        navElt.classList.toggle("active");
        
    //Si c'est que le menu est invisible
    }else{
        navElt.classList.add("active");
    }

});

const footer = document.querySelector(".Footer");
const showfooter = document.querySelector(".showfooter");

showfooter.addEventListener("click", function(){
    console.log("coucou");
    //Si le UserMenu contient la classe active
    if (footer.classList.contains("open")){
        footer.classList.toggle("open");
        
    //Si c'est que le menu est invisible
    }else{
        footer.classList.add("open");
    }

});



