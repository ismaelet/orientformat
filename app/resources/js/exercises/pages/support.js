import { all, one, on, ready } from "../dom.js";

ready(() => {
  const resize = () =>
    all(".js-topic-text").forEach((el) =>
      el.style.setProperty("--_content-height", el.scrollHeight + "px"),
    );
  resize();
  window.addEventListener("resize", resize);
  on(".js-open-topic", "click", function () {
    const topic = this.closest(".js-topic");
    const url = new URL(window.location.href);
    resize();
    const active = topic.classList.toggle("active");
    url.searchParams.set("topic", active ? topic.dataset.id : "");
    url.hash = active ? "topic" + topic.dataset.id : "";
    window.history.pushState({}, "", url);
  });
  on(".topic_img", "click", function () {
    const image = one(".modal-img");
    if (image) image.src = this.src;
  });
});
