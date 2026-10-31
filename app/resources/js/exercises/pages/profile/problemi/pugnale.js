import { all, one, ready, setField, bindDrop } from "../../../dom.js";

ready(() => {
  bindDrop(
    ".js-weapon",
    ".js-character",
    () => true,
    (source, target) => {
      const input = one(".js-field,.filler-inp", target);
      const old = input?.value;
      if (old)
        all(".js-weapon")
          .find((el) => el.dataset.id === old)
          ?.classList.remove("hidden");
      source.classList.add("hidden");
      one(".js-weapon-image-wrapper", target)?.classList.add("active");
      const image = one(".js-weapon-image", target);
      if (image) image.src = one("img", source).src;
      setField(input, source.dataset.id);
    },
  );
});
