import "/node_modules/bootstrap/dist/js/bootstrap.min.js";

document.querySelector("#year-footer").textContent = new Date().getFullYear();

document.addEventListener("DOMContentLoaded", () => {
  let navbar = document.querySelector("#navbar");

  window.addEventListener("scroll", () => {
    if (window.scrollY > 0) {
      navbar.classList.add("shadow-sm");
    } else {
      navbar.classList.remove("shadow-sm");
    }
  });

  let mainTitlePost = document.querySelector("#mainTitle");
  let otherTitlePost = document.querySelectorAll(".otherPostTitle");

  let observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          if (entry.target.id == "mainTitle") {
            entry.target.classList.add("mainPostTitleEffect");
          } else {
            entry.target.classList.add("otherPostTitleEffect");
          }
        }
      });
    },
    { threshold: 1 }
  );

  if(mainTitlePost){
    observer.observe(mainTitlePost)
  }
  otherTitlePost.forEach((otherTitle) => observer.observe(otherTitle));
});
