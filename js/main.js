// burger menu


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
if (showfooter) {

    
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
}

// const trash = document.querySelectorAll('.trashfavlink');

// console.log(trash);

// for(btn of trash){
//     btn.addEventListener("click", function(event){
//         event.preventDefault();
//         const confirmation = confirm('Sûr de vouloir vous en débarasser?');

//         if (confirmation) {
//             window.location = btn.href;
//             console.log('Image supprimé');
//             return true;
//         }
        
//         console.log('Image non supprimé');
//         return false;
//     })
// }

document.addEventListener("DOMContentLoaded", function() {
    const trash = document.querySelectorAll('.trashfavlink');

    trash.forEach(btn => {
        btn.addEventListener("click", function(event){
            event.preventDefault();
            const confirmation = confirm('Êtes-vous sûr de vouloir supprimer cette image ?');

            if (confirmation) {
                
                window.location = btn.href; // Redirection vers le lien de suppression
                console.log('Image supprimée');
            } else {
                console.log('Image non supprimée');
            }
        });
    });
});