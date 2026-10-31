import { all, one, ready, setField, bindDrop } from "../../../dom.js";

ready(() => {
  bindDrop(
    ".js-answer",
    ".js-empty-image",
    () => true,
    (source, target) => {
      all(".js-answer").forEach((el) => el.classList.remove("hidden"));
      source.classList.add("hidden");
      const image = one("img", target);
      if (image) image.src = one("img", source).src;
      setField(one(".js-field,.filler-inp"), source.dataset.id);
    },
  );
});
