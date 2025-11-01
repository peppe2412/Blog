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

  let othersPostsTitle = document.querySelectorAll(".otherPostTitle");  

  let observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("otherPostTitleEffect");
        }
      });
    },
    {
      threshold: 1,
    }
  );

  othersPostsTitle.forEach((otherTitle)=> observer.observe(otherTitle))
});
