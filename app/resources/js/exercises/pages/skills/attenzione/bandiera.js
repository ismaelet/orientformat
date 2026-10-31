import { one, on, ready, show, hide } from "../../../dom.js";

ready(() => {
  const countdown = (done) => {
    let seconds = 60;
    show(one("#countdown"));
    one("#countdown").textContent = seconds;
    const timer = setInterval(() => {
      seconds--;
      if (seconds >= 0) one("#countdown").textContent = String(seconds).padStart(2, "0");
      else {
        clearInterval(timer);
        hide(one("#countdown"));
        done();
      }
    }, 1000);
  };
  on("#start", "click", () => {
    document.body.classList.add("fixed");
    show(one("#backgrounds"));
    countdown(() => {
      show(one("#blank"));
      show(one("#interlude"));
      setTimeout(() => {
        hide(one("#interlude"));
        countdown(() => show(one("#end")));
      }, 5000);
    });
  });
});
