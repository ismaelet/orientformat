const clientRoot = document.querySelector("html").getAttribute("data-client-root");
const changeEvent = new Event("change");

$(window).ready(function () {
  //theme management
  if (
    $("html").data("theme-fluid") &&
    window.matchMedia &&
    window.matchMedia("(prefers-color-scheme: dark)").matches
  ) {
    if (document.cookie.indexOf("theme-color") == -1) {
      switch_theme("dark");
    }
  }

  $(".theme-switch .icon-box").click(function () {
    const theme = $(this).data("theme");

    switch_theme(theme);
  });

  function switch_theme(theme) {
    let expiration = new Date();

    $("html").addClass("theme-transition");

    $("html").attr("data-theme", theme);

    setTimeout(function () {
      $("html").removeClass("theme-transition");
    }, 500);

    expiration.setMonth(expiration.getMonth() + 1);

    document.cookie = "theme-color=" + theme + "; expires= " + expiration + "; path=/";
  }
});

/**
 * Post data
 * @param {string} endpoint the url where to post the data
 * @param {object} [data] the data to post
 */
async function postData(endpoint, data = {}) {
  const root = document.querySelector("html").getAttribute("data-client-root");
  const clientEndpoint = root + endpoint;

  const response = await fetch(clientEndpoint, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  });

  const responseData = await response.text();

  try {
    return JSON.parse(responseData);
  } catch (err) {
    console.log("Error: " + responseData);

    return null;
  }
}

/**
 * Call class method
 * @param {string} className the full class name, use double backslash
 * @param {string} methodName the names of the method to call
 * @param {array} [arguments] the arguments to pass, can have objects, strings or numbers inside
 * @param {number} [objectId] the id of the object, if not set, the class will be used statically
 * @param {object} [setProperties] the properties to set
 */
async function call_class_method(
  className,
  methodName,
  arguments = null,
  objectId = null,
  setProperties = null,
) {
  let parameters = {
    scope: methodName,
  };

  if (arguments) {
    parameters.arguments = arguments;
  }

  if (objectId !== null) {
    parameters.objectId = objectId;
  }

  if (setProperties) {
    parameters.setProperties = format_set_request(setProperties);
  }

  return await postData("/api/call-class-method/" + className, parameters);
}

/*
 * OLD
 */
async function AJAX(parcialEndpoint, parameters = {}, contentType = "json", debug = false) {
  // generate endpoint
  const root = document.querySelector("html").getAttribute("data-client-root");

  let responseData;
  let endpoint =
    parcialEndpoint[0] == "/" ? root + parcialEndpoint : root + "/ajax/" + parcialEndpoint;

  if (parameters) {
    endpoint += "?" + new URLSearchParams(parameters);
  }

  // send the request
  const response = await fetch(endpoint);

  // debugger
  if (debug) {
    const debugResponse = response.clone();
    console.log(await debugResponse.text());
  }

  // parse the response
  responseData = await response.text();

  switch (contentType) {
    case "json":
      try {
        responseData = JSON.parse(responseData);
      } catch (err) {
        console.log("Error: " + responseData);
        responseData = null;
      }
      break;
    case "text":
      responseData = responseData;
      break;
    default:
      responseData = null;
  }

  // return the response
  return responseData;
}

/**
 * Call function
 * @param {string} functionName the full function, use double backslash
 * @param {array|string|number} [arguments] the arguments to pass
 * @param {boolean} [debug] the debug option
 */
async function call_function(functionName, arguments = null, debug = false) {
  let parameters = {};

  if (arguments) {
    parameters.arguments = arguments;
  }

  return await AJAX("/api/call-function/" + functionName, parameters, "json", debug);
}

/**
 * Search table
 * @param {string} tableName the name of the table to search
 * @param {array|string} responseFields the list of requested fields
 * @param {array|string} [searchFields] the list of fields to use for the filter
 * @param {string} [search] the searched string
 * @param {string} [orderField] the field to use to order the results
 * @param {string} [orderField] the field to use to order the results
 * @param {boolean} [debug] the debug option
 */
async function search_table(
  tableName,
  responseFields,
  searchFields = null,
  search = null,
  orderField = null,
  orderDirection = null,
  count = null,
  debug = false,
) {
  let parameters = {
    responseFields: responseFields,
  };

  if (searchFields) {
    parameters.searchFields = searchFields;
  }

  if (search) {
    parameters.search = search;
  }

  if (orderField) {
    parameters.orderField = orderField;
  }

  if (orderDirection) {
    parameters.orderDirection = orderDirection;
  }

  if (count) {
    parameters.count = count;
  }

  return await AJAX("/api/search-table/" + tableName, parameters, "json", debug);
}

/**
 * Get class properties
 * @param {string} className the full class name, use double backslash
 * @param {array|string} propertyNames the names of the properties to get
 * @param {number} [objectId] the id of the object, if not set, the function will get static properties
 * @param {object} [setProperties] the properties to set
 * @param {boolean} [debug] the debug option
 */
async function get_class_properties(
  className,
  propertyNames,
  objectId = null,
  setProperties = null,
  debug = false,
) {
  let parameters = {
    scope: propertyNames,
  };

  if (objectId !== null) {
    parameters.objectId = objectId;
  }

  if (setProperties) {
    parameters.setProperties = format_set_request(setProperties);
  }

  return await AJAX("/api/get-class-properties/" + className, parameters, "json", debug);
}

/*
 * Function
 */
function format_set_request(setProperties) {
  let setRequest = [];

  if (setProperties) {
    for (const key in setProperties) {
      setRequest.push(key + "=" + setProperties[key]);
    }
  }

  if (setRequest.length) {
    setRequest.join(",");
  } else {
    setRequest = null;
  }

  return setRequest;
}

/*
 * Functions
 */
function redirect_old(url) {
  const root = document.querySelector("html").getAttribute("data-client-root");

  window.location.href = root + url;
}

function client_path(baseUrl) {
  const clientRoot = document.querySelector("html").getAttribute("data-client-root");
  const url = clientRoot + baseUrl;

  return url;
}

/**
 * Modals
 */
const openModalSelector = ".js-open-modal";
const closeModalSelectors = ".modal, .modal__close, .js-close-modal";

document.addEventListener("DOMContentLoaded", function () {
  /**
   * Modals
   */
  document.querySelectorAll(openModalSelector).forEach((element) => {
    element.addEventListener("click", () => {
      const target = element.dataset.target;
      const modal = document.querySelector("#" + target);

      document.querySelector("body").classList.add("fixed");

      modal.classList.add("open");
    });
  });

  document.querySelectorAll(closeModalSelectors).forEach((element) => {
    element.addEventListener("click", (event) => {
      if (event.target == event.currentTarget) {
        const modal = event.target.closest(".modal");

        document.querySelector("body").classList.remove("fixed");

        modal.classList.remove("open");
      }
    });
  });
});

$(document).ready(function () {
  $(".file-inp").on("change", function () {
    $(this).parents(".file-form").find(".file-submit").click();

    console.log(1);
  });

  $(".file-form").submit(function () {
    var self = $(this);

    self.find(".file-cancel").hide();
    self.find(".file-submit").hide();
    self.find(".file-load").show();
    self.find(".file-stick").show().css("opacity", 1);
  });
});

/**
 * Inputs
 */
const noSpaceSelector = ".js-input-no-space";

/*
 * Ajax search
 */
const ajaxSearchSelector = ".js-ajax-search";
const ajaxSearchIndexInputSelector = ".js-ajax-search__index-input";
const ajaxSearchVisibleInputSelector = ".js-ajax-search__visible-input";
const ajaxSearchDropdownSelector = ".js-ajax-search__dropdown";
const ajaxSearchItemListSelector = ".js-ajax-search__items";
const ajaxSearchItemSelector = ".js-ajax-search__item";

/*
 * Ajax search support functions
 */
function make_searched_text_bold(text, search) {
  let pattern = new RegExp("(" + search + ")", "ig");
  return text.replace(pattern, "<strong>$1</strong>");
}

document.addEventListener("DOMContentLoaded", function () {
  /**
   * Ajax search
   */
  // trigger search
  document.querySelectorAll(ajaxSearchVisibleInputSelector).forEach((ajaxSearchVisibleInput) => {
    ajaxSearchVisibleInput.addEventListener("keyup", async (event) => {
      if (!["ArrowUp", "ArrowDown"].includes(event.key)) {
        // setup
        const searchBlock = ajaxSearchVisibleInput.closest(ajaxSearchSelector);
        const dropdownElement = searchBlock.querySelector(ajaxSearchDropdownSelector);
        const itemListElement = searchBlock.querySelector(ajaxSearchItemListSelector);
        const table = searchBlock.dataset.search;
        const searchFields = searchBlock.dataset.searchFields.split(",");
        const indexField = searchBlock.dataset.indexField;
        const visibleField = searchBlock.dataset.visibleField;
        const responseFields = [indexField, visibleField];
        const search = ajaxSearchVisibleInput.value;

        // response
        let response = await search_table(
          table,
          responseFields,
          searchFields,
          search,
          visibleField,
          "asc",
        );

        itemListElement.innerHTML = "";

        if (response.length) {
          response.forEach((result) => {
            const indexValue = result[indexField];
            const visibleValue = result[visibleField].replaceAll('"', "&quot;");
            const itemText = make_searched_text_bold(visibleValue, search);

            itemListElement.insertAdjacentHTML(
              "beforeend",
              '<p class="ajax-search__item ' +
                ajaxSearchItemSelector +
                '" data-index-value="' +
                indexValue +
                '" data-visible-value="' +
                visibleValue +
                '" tabindex="-1">' +
                itemText +
                "</p>",
            );
          });

          for (const searchItem of itemListElement.children) {
            searchItem.addEventListener("click", () => {
              ajax_search_item_click(searchItem);
            });

            searchItem.addEventListener("keydown", (event) => {
              ajax_search_item_keydown(searchItem, event);
            });
          }

          dropdownElement.classList.remove("hidden");
        } else {
          dropdownElement.classList.add("hidden");
        }
      }
    });

    // keydown in the search input
    document.querySelectorAll(ajaxSearchVisibleInputSelector).forEach((element) => {
      element.addEventListener("keydown", (event) => {
        const searchBlock = element.closest(ajaxSearchSelector);
        const itemList = searchBlock.querySelector(ajaxSearchItemListSelector);
        const indexInput = searchBlock.querySelector(ajaxSearchIndexInputSelector);

        const eventKey = event.key;

        if (eventKey == "ArrowDown" || eventKey == "ArrowUp") {
          // select the an item
          const item = itemList.querySelector(
            eventKey == "ArrowDown" ? "p:first-child" : "p:last-child",
          );

          item.classList.add("focused");
          item.focus();
        } else {
          // clear the index value on keydown
          indexInput.value = "";
        }
      });
    });

    // hide dropdowns when clicking
    document.addEventListener("click", () => {
      document.querySelectorAll(ajaxSearchDropdownSelector).forEach((element) => {
        element.classList.add("hidden");
      });
    });

    // click on a searched item
    function ajax_search_item_click(searchItem) {
      const searchBlock = searchItem.closest(ajaxSearchSelector);
      const dropdownElement = searchBlock.querySelector(ajaxSearchDropdownSelector);
      const indexInput = searchBlock.querySelector(ajaxSearchIndexInputSelector);
      const visibleInput = searchBlock.querySelector(ajaxSearchVisibleInputSelector);
      const hiddenValue = searchItem.dataset.indexValue;
      const visibleValue = searchItem.dataset.visibleValue;

      indexInput.value = hiddenValue;
      visibleInput.value = visibleValue;
      indexInput.dispatchEvent(changeEvent);
      visibleInput.dispatchEvent(changeEvent);

      if (visibleInput.title !== undefined) {
        visibleInput.title = visibleValue;
      }

      dropdownElement.classList.add("hidden");
    }

    // click on a searched item
    function ajax_search_item_keydown(searchItem, event) {
      const eventKey = event.key;
      const nextItem = searchItem.nextSibling;
      const previousItem = searchItem.previousSibling;

      event.preventDefault();

      if (eventKey == "ArrowDown") {
        if (nextItem) {
          searchItem.classList.remove("focused");
          nextItem.classList.add("focused");
          nextItem.focus();
        }
      } else if (eventKey == "ArrowUp") {
        if (previousItem) {
          searchItem.classList.remove("focused");
          previousItem.classList.add("focused");
          previousItem.focus();
        }
      } else if (eventKey == "Enter") {
        searchItem.click();
      }
    }
  });

  /**
   * Inputs
   */
  // input with no spaces allowed
  document.querySelectorAll(noSpaceSelector).forEach((element) => {
    element.addEventListener("keydown", (event) => {
      const eventKey = event.key;

      if (eventKey == " ") {
        event.preventDefault();

        return false;
      }
    });
  });
});

$(document).ready(function () {
  //clear error messages
  $(".clear-error").keypress(function () {
    $(".inp.err").hide();
  });
  $(".clear-error").click(function () {
    $(".inp.err").hide();
  });

  //no spance inputs
  $(".inp-nospace").keypress(function (e) {
    if (e.which === 32) return false;
  });

  /*
   * Required checkboxes
   */
  $(".js-required-cbx").on("change", function () {
    let self;

    if ($(this).is("input")) {
      self = $(this);
    } else {
      self = $(this).find('input[type="checkbox"]');
    }

    const name = self.attr("name");

    self.parents(".js-cbx-container").find(".js-required-cbx").prop("checked", false);

    if (name) {
      $('[name="' + name + '"]').prop("checked", false);
    }

    self.prop("checked", true);
  });

  //file upload
  $(".replace-img").click(function () {
    this.nextElementSibling.click();
  });

  $(".upload-on-change").on("change", function () {
    const form = this.closest("form");

    form.classList.add("loading");
    form.submit();
  });

  //fancy inputs
  $(".fancy-input .inp").on("input keyup", function () {
    const self = $(this);

    if (self.val()) {
      self.parent().removeClass("not-filled");
    } else {
      self.parent().addClass("not-filled");
    }
  });

  //dependent selector
  $(".sel.affect").each(function () {
    selector_affect($(this));
  });
  $(".sel.affect").on("change", function () {
    selector_affect($(this));
  });

  function selector_affect(selector) {
    const affected = selector.parent().find('.sel[name="' + selector.data("affect") + '"]');
    const field_id = affected.data("id");
    const field_show = affected.data("show");

    affected.attr("disabled", false).empty();

    $.ajax({
      type: "POST",

      url: affected.data("root") + "/system/modules/ajax/search-selector.php",

      data: {
        tbl: affected.data("tbl"),
        filter: affected.data("filter"),
        filter_val: selector.val(),
        field_id: field_id,
        field_show: field_show,
      },

      success: function (data) {
        const options = $.parseJSON(data);

        for (var i = 0; i < options.length; i++) {
          const option = options[i];

          affected.append(
            '<option value="' + option[field_id] + '" selected>' + option[field_show] + "</option>",
          );
        }
      },
    });
  }

  //ajax search
  $(".ajax-search-txt").keyup(async function () {
    //setup
    const self = $(this);
    const search = self.val();
    const parent = self.parents(".ajax-search");
    const parcialEndpoint = parent.data("endpoint");
    const valueField = parent.data("value-field");
    const showField = parent.data("show-field");
    const filter = parent.data("filter");
    const parameters = {
      searchFields: filter,
      search: search,
      scope: valueField + "," + showField,
      orderBy: showField,
      orderDirection: "ASC",
      limit: 10,
    };

    parent.find(".ajax-search-box").html("");

    response = await API(parcialEndpoint, "GET", parameters);

    if (response["error"]) {
      console.log("API Error: " + response["error"]);
    } else if (response) {
      let results = response;

      const count = Object.keys(results).length;

      //if there are results
      if (count) {
        parent.find(".ajax-search-box").html("");

        //generate the rows with the results
        for (const [key, value] of Object.entries(results)) {
          parent
            .find(".ajax-search-box")
            .append(
              '<p class="ajax-search-item" data-id="' +
                value[valueField] +
                '" data-text="' +
                value[showField] +
                '">' +
                value[showField] +
                "</p>",
            );
        }

        parent.find(".ajax-search-ddown").show();

        //if there aren't results
      } else {
        parent.find(".ajax-search-ddown").hide();
      }
    }
  });

  $(".ajax-search").on("click", ".ajax-search-item", function () {
    var self = $(this);
    var parent = self.parents(".ajax-search");

    parent.find(".ajax-search-id").val(self.data("id"));
    parent.find(".ajax-search-txt").val(self.data("text"));

    parent.find(".ajax-search-ddown").hide();
  });

  function hide_ajax_searcher(searcher) {
    const count = searcher.find(".ajax-search-item").length;

    searcher.find(".ajax-search-ddown").hide();

    if (count == 1) {
      searcher.find(".ajax-search-id").val(searcher.find(".ajax-search-item").data("id"));
      searcher.find(".ajax-search-txt").val(searcher.find(".ajax-search-item").data("text"));
    }
  }

  $(document).click(function () {
    $(".ajax-search").each(function () {
      hide_ajax_searcher($(this));
    });
  });

  $(".ajax-search").click(function (event) {
    event.stopPropagation();
  });
});

$(document).ready(function () {
  //open
  $(".lbox-open").click(function () {
    const tar = $($(this).data("tar"));

    if ($(".lbox.open").length) {
      $(".lbox").removeClass("open");
    } else {
      $("body").addClass("fixed");
    }

    tar.addClass("open");
  });

  //close
  $(".lbox").click(function (e) {
    if (e.target != this) return;

    close();
  });

  $(".lbox-close").click(function () {
    close();
  });
  $(".lbox .close-icon").click(function () {
    close();
  });

  function close() {
    $(".lbox").removeClass("open");
    $("body").removeClass("fixed");
  }
});

$(window).on("load", function () {
  load();

  $(window).scroll(function () {
    load();
  });
  $(window).on("resize", function () {
    load();
  });

  function load() {
    const winBot = $(window).scrollTop() + $(window).height();

    $(".load").each(function () {
      let elem = $(this);

      if (visible(elem, winBot)) {
        elem.removeClass("load");
      }
    });

    $(".lazy-loading").each(function () {
      let elem = $(this);

      if (visible(elem, winBot)) {
        elem.attr("src", elem.data("lazy-src"));
      }
    });
  }

  function visible(elem, winBot) {
    const elemPos = elem.offset().top;
    //const elemPos = elem.offset().top + elem.outerHeight(true)

    return elemPos <= winBot;
  }
});

let loadClass = "js-load";

document.addEventListener("DOMContentLoaded", () => {
  let loadableElements = document.querySelectorAll('.js-load:not([data-load-type="always"])');

  const defaultOptions = {
    root: null,
    threshold: 0.5,
    rootMargin: "0px",
  };

  const elementStartOptions = {
    root: null,
    threshold: 0,
    rootMargin: "0px",
  };

  const observer = new IntersectionObserver(observerCallback, defaultOptions);
  const observerStart = new IntersectionObserver(observerCallback, elementStartOptions);

  function observerCallback(entries) {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.remove(loadClass);
      }
    });
  }

  loadableElements.forEach((element) => {
    if (element) {
      if (element.getAttribute("data-load-threshold") == 0) {
        observerStart.observe(element);
      } else {
        observer.observe(element);
      }
    }
  });
});

window.addEventListener("load", () => {
  let loadableElements = document.querySelectorAll('.js-load[data-load-type="always"]');

  loadableElements.forEach((element) => {
    if (element) {
      element.classList.remove(loadClass);
    }
  });
});

/**
 * Modals
 */
document.addEventListener("DOMContentLoaded", function () {
  /**
   * Modals
   */
  document.querySelectorAll(openModalSelector).forEach((element) => {
    element.addEventListener("click", () => {
      const target = element.dataset.target;
      const modal = document.querySelector("#" + target);

      document.querySelector("body").classList.add("fixed");

      modal.classList.add("open");
    });
  });

  document.querySelectorAll(closeModalSelectors).forEach((element) => {
    element.addEventListener("click", (event) => {
      if (event.target == event.currentTarget) {
        const modal = event.target.closest(".modal");

        document.querySelector("body").classList.remove("fixed");

        modal.classList.remove("open");
      }
    });
  });
});

$(document).ready(function () {
  //setup
  $(".carousel").each(function () {
    const panel = $(this);

    panel.find(".carousel-grid").addClass("no-trans");

    panel[0].offsetHeight;

    panel.find(".carousel-grid").removeClass("no-trans");
  });

  //on click
  $(".carousel-arrow").click(function () {
    if (!$(this).hasClass("disabled")) {
      const arrow = $(this);
      const panel = $(arrow.data("tar"));

      update_position(arrow, panel);
      slide(panel);
    }
  });

  //on click
  $(".carousel-dot").click(function () {
    const self = $(this);
    const panel = $(self.parent().data("target"));

    if (!self.hasClass("disabled")) {
      const span = Math.round(panel.css("--columns"));
      const page = self.index() + 1;

      let pos = span * (page - 1) + 1;

      panel.data("pos", pos);

      self.parent().find(".carousel-dot").removeClass("active");
      self.addClass("active");

      slide(panel);
    }
  });

  //update position variable
  function update_position(arrow, panel) {
    let pos;

    //if is a fixed arrow
    if (arrow.data("pos")) {
      pos = parseInt(arrow.data("pos"));

      //if is a dynamic arrow
    } else {
      const step = panel.css("--step") ? parseInt(panel.css("--step")) : 1;
      const span = Math.round(panel.css("--columns"));
      const loop = panel.data("loop") ? true : false;
      const rows = parseInt(panel.css("--rows"));
      const count = panel.find("> *").length / rows;
      const last = count - span + 1;
      const posOld = panel.data("pos");

      let direction;

      pos = posOld;

      if (arrow.data("direction")) {
        direction = arrow.data("direction");
      } else {
        direction = arrow.hasClass("left") ? "left" : "right";
      }

      //update position
      if (direction === "right") {
        pos += step;
        arrow.prev(".left.disabled").removeClass("disabled");
      } else if (direction === "left") {
        pos -= step;
        arrow.next(".right.disabled").removeClass("disabled");
      }

      //disable arrows if the limit is reached
      if (pos <= 1 && !loop) {
        arrow.addClass("disabled");
      }
      if (pos >= last && !loop) {
        arrow.addClass("disabled");
      }

      //clamp position
      if (pos < 1) {
        if (loop && posOld <= 1) {
          pos = last;
        } else {
          pos = 1;
        }
      }

      if (pos > last) {
        if (loop && posOld >= last) {
          pos = 1;
        } else {
          pos = last;
        }
      }
    }

    //save the new position
    panel.data("pos", pos);
  }

  //move panel
  function slide(panel) {
    const rows = parseInt(panel.css("--rows"));
    const pos = rows > 1 ? parseInt(panel.data("pos")) * rows - 1 : parseInt(panel.data("pos"));
    const left = panel.find("> *:nth-child(" + pos + ")").position().left + panel.scrollLeft();

    panel.scrollLeft(left);
  }
});
$(document).ready(function () {
  //setup
  $(".carousel").each(function () {
    const panel = $(this);

    panel.find(".carousel-grid").addClass("no-trans");

    panel[0].offsetHeight;

    panel.find(".carousel-grid").removeClass("no-trans");
  });

  //on click
  $(".carousel-arrow").click(function () {
    if (!$(this).hasClass("disabled")) {
      const arrow = $(this);
      const panel = $(arrow.data("tar"));

      update_position(arrow, panel);
      slide(panel);
    }
  });

  //on click
  $(".carousel-dot").click(function () {
    const self = $(this);
    const panel = $(self.parent().data("target"));

    if (!self.hasClass("disabled")) {
      const span = Math.round(panel.css("--columns"));
      const page = self.index() + 1;

      let pos = span * (page - 1) + 1;

      panel.data("pos", pos);

      self.parent().find(".carousel-dot").removeClass("active");
      self.addClass("active");

      slide(panel);
    }
  });

  //update position variable
  function update_position(arrow, panel) {
    let pos;

    //if is a fixed arrow
    if (arrow.data("pos")) {
      pos = parseInt(arrow.data("pos"));

      //if is a dynamic arrow
    } else {
      const step = panel.css("--step") ? parseInt(panel.css("--step")) : 1;
      const span = Math.round(panel.css("--columns"));
      const loop = panel.data("loop") ? true : false;
      const rows = parseInt(panel.css("--rows"));
      const count = panel.find("> *").length / rows;
      const last = count - span + 1;
      const posOld = panel.data("pos");

      let direction;

      pos = posOld;

      if (arrow.data("direction")) {
        direction = arrow.data("direction");
      } else {
        direction = arrow.hasClass("left") ? "left" : "right";
      }

      //update position
      if (direction === "right") {
        pos += step;
        arrow.prev(".left.disabled").removeClass("disabled");
      } else if (direction === "left") {
        pos -= step;
        arrow.next(".right.disabled").removeClass("disabled");
      }

      //disable arrows if the limit is reached
      if (pos <= 1 && !loop) {
        arrow.addClass("disabled");
      }
      if (pos >= last && !loop) {
        arrow.addClass("disabled");
      }

      //clamp position
      if (pos < 1) {
        if (loop && posOld <= 1) {
          pos = last;
        } else {
          pos = 1;
        }
      }

      if (pos > last) {
        if (loop && posOld >= last) {
          pos = 1;
        } else {
          pos = last;
        }
      }
    }

    //save the new position
    panel.data("pos", pos);
  }

  //move panel
  function slide(panel) {
    const rows = parseInt(panel.css("--rows"));
    const padding = panel.css("--padding") ? parseInt(panel.css("--padding")) : 0;
    const pos = rows > 1 ? parseInt(panel.data("pos")) * rows - 1 : parseInt(panel.data("pos"));
    const left =
      panel.find("> *:nth-child(" + pos + ")").position().left + panel.scrollLeft() - padding * 16;

    console.log(padding);

    panel.scrollLeft(left);
  }
});
