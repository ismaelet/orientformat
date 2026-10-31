$(document).ready(function () {
  $("#questions .block").click(function () {
    const self = $(this);

    self.parents(".question").find(".cbx-mirror").prop("checked", false);

    self.find(".cbx-mirror").prop("checked", true).change();
  });
});
