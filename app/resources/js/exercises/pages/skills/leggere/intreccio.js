import { all, ready, bindMatching } from "../../../dom.js";

ready(() => {
  bindMatching({
    targets: ".box",
    accept: (source, target) =>
      source.classList.contains("reader") === target.classList.contains("reader"),
    updated: () => generate_lines(),
  });
  //lines
  generate_lines();

  function generate_lines() {
    all(".leader-line").forEach((el) => el.remove());

    let start, end;

    start = document.getElementById("box2");
    end = document.getElementById("box5");
    new LeaderLine(start, end, { color: "#c14e6e", dash: { animation: true }, size: 4 });

    start = document.getElementById("box7");
    end = document.getElementById("box5");
    new LeaderLine(start, end, {
      startSocket: "top",
      color: "#c14e6e",
      dash: { animation: true },
      size: 4,
    });
    end = document.getElementById("box8");
    new LeaderLine(start, end, {
      startSocket: "bottom",
      color: "#c14e6e",
      dash: { animation: true },
      size: 4,
    });

    start = document.getElementById("box5");
    end = document.getElementById("box8");
    new LeaderLine(start, end, { color: "#c14e6e", dash: { animation: true }, size: 4 });

    start = document.getElementById("box8");
    end = document.getElementById("box11");
    new LeaderLine(start, end, { color: "#c14e6e", dash: { animation: true }, size: 4 });

    start = document.getElementById("box11");
    end = document.getElementById("box12");
    new LeaderLine(start, end, { color: "#c14e6e", dash: { animation: true }, size: 4 });
    end = document.getElementById("box14");
    new LeaderLine(start, end, { color: "#c14e6e", dash: { animation: true }, size: 4 });
    start = document.getElementById("box12");
    new LeaderLine(start, end, {
      startSocket: "bottom",
      endSocket: "top",
      color: "#c14e6e",
      dash: { animation: true },
      size: 4,
    });

    start = document.getElementById("box15");
    end = document.getElementById("box14");
    new LeaderLine(start, end, { color: "#c14e6e", dash: { animation: true }, size: 4 });

    start = document.getElementById("box14");
    end = document.getElementById("box16");
    new LeaderLine(start, end, {
      endSocket: "top",
      color: "#c14e6e",
      dash: { animation: true },
      size: 4,
    });
    end = document.getElementById("box17");
    new LeaderLine(start, end, { color: "#c14e6e", dash: { animation: true }, size: 4 });

    start = document.getElementById("box16");
    end = document.getElementById("box17");
    new LeaderLine(start, end, {
      startSocket: "bottom",
      color: "#c14e6e",
      dash: { animation: true },
      size: 4,
    });

    start = document.getElementById("box17");
    end = document.getElementById("box18");
    new LeaderLine(start, end, { color: "#c14e6e", dash: { animation: true }, size: 4 });
  }
});
