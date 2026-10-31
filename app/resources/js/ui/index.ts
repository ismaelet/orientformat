import { initDialogs } from "./dialogs";
import { initForms } from "./forms";
import { initReveal } from "./reveal";

import { initNavigation } from "./navigation";
import { initReview } from "./review";

function initialize() {
  initNavigation();
  initReview();
  initDialogs();
  initForms();
  initReveal();
}

if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", initialize, { once: true });
} else {
  initialize();
}
