/// <reference types="vite/client" />

import "./ui";

import { printPage } from "./print";
import { initTextSelection } from "./tests/text-selection";

import.meta.glob(["../images/**"]);

window.printPage = printPage;
window.initTextSelection = initTextSelection;
