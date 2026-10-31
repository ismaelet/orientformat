import { one, ready } from "../../dom.js";

ready(() => {
  const counter = one("#countdown .number");
  if (!counter) return;
  let seconds = 10;
  counter.textContent = seconds;
  const timer = setInterval(() => {
    counter.textContent = --seconds;
    if (seconds < 1) {
      clearInterval(timer);
      window.location.reload();
    }
  }, 1000);
});
