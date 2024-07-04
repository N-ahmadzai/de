// JavaScript pour gérer l'affichage complet du texte d'habitat
document.addEventListener("DOMContentLoaded", function () {
  const readMoreLinks = document.querySelectorAll(".read-more-link");

  readMoreLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      const description = this.getAttribute("data-description");
      const cardBody = this.closest(".card-body");
      const habitatDescription = cardBody.querySelector(".habitat-description");
      habitatDescription.textContent = description;
      this.style.display = "none"; // Masquer le lien "Lire la suite"
    });
  });
});
