import { ready, bindMatching } from "../../../dom.js";

ready(() => {
  // lines
  let start = document.getElementById("box1");
  let end = document.getElementById("box2");
  let parameters = {
    path: "magnet",
    startSocket: "bottom",
    endSocket: "top",
    color: "#849bbd",
    size: 3,
  };

  // row 1
  new LeaderLine(start, end, parameters);

  // row 2
  start = document.getElementById("box2");
  end = document.getElementById("box3");
  parameters.endSocket = "right";
  new LeaderLine(start, end, parameters);

  parameters.endSocket = "left";
  end = document.getElementById("box4");
  new LeaderLine(start, end, parameters);

  // row 3
  start = document.getElementById("box3");
  end = document.getElementById("box5");
  parameters.endSocket = "left";
  new LeaderLine(start, end, parameters);

  parameters.endSocket = "right";
  start = document.getElementById("box4");
  new LeaderLine(start, end, parameters);

  // row 4
  start = document.getElementById("box5");
  end = document.getElementById("box6");
  parameters.endSocket = "right";
  new LeaderLine(start, end, parameters);

  parameters.endSocket = "left";
  end = document.getElementById("box7");
  new LeaderLine(start, end, parameters);

  // row 5
  start = document.getElementById("box6");
  end = document.getElementById("box8");
  parameters.endSocket = "top";
  new LeaderLine(start, end, parameters);

  start = document.getElementById("box7");
  end = document.getElementById("box9");
  new LeaderLine(start, end, parameters);

  // row 6
  start = document.getElementById("box8");
  end = document.getElementById("box10");
  new LeaderLine(start, end, parameters);

  start = document.getElementById("box9");
  end = document.getElementById("box11");
  new LeaderLine(start, end, parameters);

  // row 7
  start = document.getElementById("box10");
  end = document.getElementById("box14");
  parameters.endSocket = "left";
  new LeaderLine(start, end, parameters);

  end = document.getElementById("box16");
  new LeaderLine(start, end, parameters);

  end = document.getElementById("box18");
  new LeaderLine(start, end, parameters);

  start = document.getElementById("box11");
  end = document.getElementById("box12");
  parameters.endSocket = "top";
  new LeaderLine(start, end, parameters);

  // row 8
  start = document.getElementById("box12");
  end = document.getElementById("box13");
  parameters.endSocket = "top";
  new LeaderLine(start, end, parameters);

  // row 9
  start = document.getElementById("box13");
  end = document.getElementById("box14");
  parameters.endSocket = "right";
  new LeaderLine(start, end, parameters);

  // row 10
  start = document.getElementById("box13");
  end = document.getElementById("box15");
  parameters.endSocket = "top";
  new LeaderLine(start, end, parameters);

  // row 11
  start = document.getElementById("box15");
  end = document.getElementById("box16");
  parameters.endSocket = "right";
  new LeaderLine(start, end, parameters);

  end = document.getElementById("box17");
  parameters.endSocket = "top";
  new LeaderLine(start, end, parameters);

  // row 12
  start = document.getElementById("box17");
  end = document.getElementById("box18");
  parameters.endSocket = "right";
  new LeaderLine(start, end, parameters);

  // row 13
  start = document.getElementById("box18");
  end = document.getElementById("box19");
  parameters.endSocket = "top";
  new LeaderLine(start, end, parameters);

  bindMatching({
    targets: ".box",
    accept: (source, target) =>
      source.classList.contains("js-box--solid") === target.classList.contains("js-box--solid"),
  });
});
