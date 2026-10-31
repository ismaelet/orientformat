$(document).ready(function () {
  //lines
  generate_lines();

  $(window).resize(function () {
    $(".leader-line").remove();

    generate_lines();
  });

  function generate_lines() {
    const ele1 = document.getElementById("element1");
    const ele2 = document.getElementById("element5");

    if (ele1 && ele2) {
      let line;

      line = new LeaderLine(ele1, ele2, {
        size: 6,
        hide: true,
        startPlugColor: "#f4c152",
        endPlugColor: "#c14e6e",
        gradient: true,
        dash: { animation: true },
      });

      setTimeout(function () {
        line.show("draw", { duration: 800 });
      }, 200);
    }

    // $('.leader-line').appendTo('#img-box')
  }
});
