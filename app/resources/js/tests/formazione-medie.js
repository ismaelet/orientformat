const diagram = document.querySelector(".medie-pathways");

if (diagram) {
  const svg = diagram.querySelector("svg");
  const definitions = svg.querySelector("defs");
  const connections = [];

  for (const start of diagram.querySelectorAll("[data-destinations]")) {
    for (const destination of start.dataset.destinations.split(" ").filter(Boolean)) {
      const end = document.getElementById(`medie-${destination}`);
      if (!end) continue;

      const id = `medie-connection-${connections.length}`;
      const gradient = document.createElementNS("http://www.w3.org/2000/svg", "linearGradient");
      gradient.id = `${id}-gradient`;
      gradient.setAttribute("gradientUnits", "userSpaceOnUse");
      for (const [offset, box] of [
        ["0%", start],
        ["100%", end],
      ]) {
        const stop = document.createElementNS("http://www.w3.org/2000/svg", "stop");
        stop.setAttribute("offset", offset);
        stop.setAttribute("stop-color", getComputedStyle(box).backgroundColor);
        gradient.append(stop);
      }
      const marker = definitions.querySelector("#medie-arrow").cloneNode(true);
      marker.id = `${id}-arrow`;
      marker.style.color = getComputedStyle(end).backgroundColor;
      definitions.append(gradient, marker);

      const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
      path.setAttribute("fill", "none");
      path.setAttribute("stroke", `url(#${gradient.id})`);
      path.setAttribute("stroke-width", "2");
      path.setAttribute("marker-end", `url(#${marker.id})`);
      svg.append(path);
      connections.push({ start, end, path, gradient });
    }
  }

  function positionConnections() {
    const bounds = diagram.getBoundingClientRect();
    for (const { start, end, path, gradient } of connections) {
      const from = start.getBoundingClientRect();
      const to = end.getBoundingClientRect();
      const x1 = from.left + from.width / 2 - bounds.left;
      const y1 = from.bottom - bounds.top;
      let arrivalFraction = 1 / 2;
      if (end.classList.contains("medie-pathway--destination")) {
        const incoming = connections
          .filter((connection) => connection.end === end)
          .sort(
            (a, b) => a.start.getBoundingClientRect().left - b.start.getBoundingClientRect().left,
          );
        const index = incoming.findIndex((connection) => connection.path === path);
        arrivalFraction = (index + 1) / (incoming.length + 1);
      }
      const x2 = to.left + to.width * arrivalFraction - bounds.left;
      const y2 = to.top - bounds.top;
      const middle = (y1 + y2) / 2;
      gradient.setAttribute("x1", x1);
      gradient.setAttribute("y1", y1);
      gradient.setAttribute("x2", x2);
      gradient.setAttribute("y2", y2);
      path.setAttribute("d", `M ${x1} ${y1} C ${x1} ${middle}, ${x2} ${middle}, ${x2} ${y2}`);
    }
  }

  new ResizeObserver(positionConnections).observe(diagram);
  document.fonts.ready.then(positionConnections);
}
