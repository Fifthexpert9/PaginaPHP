function googleTranslateElementInit() {
  new google.translate.TranslateElement(
    {
      pageLanguage: "es",
      includedLanguages: "en,fr,de,it,pt,ca,gl,eu",
      layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
    },
    "google_translate_element"
  );
}

document.addEventListener("DOMContentLoaded", function () {
  var btn = document.getElementById("open-translate");
  if (btn) {
    btn.onclick = function () {
      var elem = document.querySelector(".goog-te-gadget-icon");
      if (elem) elem.click();
    };
  }
});
