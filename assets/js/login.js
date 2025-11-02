document.addEventListener("DOMContentLoaded", () => {
  let alerts_close = document.querySelectorAll(".alert");
  let buttons_close = document.querySelectorAll(".button-close");  

  buttons_close.forEach((button, index) => {
    button.addEventListener('click', () => {
        const alerts = alerts_close[index]
        alerts.classList.add('close-alert-box')
    })
  })
});
