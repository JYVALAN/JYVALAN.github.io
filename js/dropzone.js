console.log('coucou');

// Sélectionnez l'élément HTML où vous voulez afficher la miniature
const miniature = document.getElementById('insight');

// Sélectionnez l'élément input de type "file" où l'utilisateur choisira l'image
const input = document.getElementById('picture');

// const img = document.querySelector('img');
// img.classList.add('photo');

// Ajoutez un événement "change" à l'élément input
input.addEventListener('change', function(event) {
  // Sélectionnez le fichier choisi par l'utilisateur
  const file = event.target.files[0];
  
  // Créez un objet FileReader
  const reader = new FileReader();
  
  // Ajoutez un événement "load" à l'objet FileReader
  reader.addEventListener('load', function() {
    // Créez un élément image
    const image = new Image();
    image.classList.add('sendpicture');
    
    // Définissez la source de l'image sur la donnée de l'objet FileReader
    image.src = reader.result;
    
    // Ajoutez l'image à l'élément miniature
    miniature.appendChild(image);
  });
  
  // Lancez la lecture du fichier
  reader.readAsDataURL(file);
});
