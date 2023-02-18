let translations = {};
let defaultLocale = window.localStorage.getItem("lang");
let isMobileMenuShow = false;

if (defaultLocale == null) {
    defaultLocale = "tr";
    window.localStorage.setItem("lang", "tr");
}

const fetchTranslations = async (newLocale) => {

    const response = await fetch(`../lang/${newLocale}.json`);

    if (!response.ok) {

        console.log(`Could not fetch translations for locale ${newLocale}`);

    }

    return await response.json();

};

function translatePage() {

    document.querySelectorAll('[localization-key]').forEach((element) => {

        let key = element.getAttribute('localization-key');

        let translation = translations[key];

        element.innerHTML = stringToHTML(translation);

    });

}

const setLocale = async (newLocale) => {

    translations = await fetchTranslations(newLocale);

    translatePage();

};

document.addEventListener('DOMContentLoaded', () => {

    setLocale(defaultLocale);

});

var switchLanguage = function (language) {
    if (defaultLocale !== language){
        document.querySelector(".language-option-selected").classList.remove("language-option-selected");
        document.querySelector(".language-option-selected-mobile").classList.remove("language-option-selected-mobile");

        document.querySelector(`.lang-${language}`).classList.add("language-option-selected");
        document.querySelector(`.lang-mobile-${language}`).classList.add("language-option-selected-mobile");

        defaultLocale = language;
        window.localStorage.setItem("lang", language);
    }
    
    setLocale(language);
}

var stringToHTML = function (str) {
	var parser = new DOMParser();
	var doc = parser.parseFromString(str, 'text/html');
	return doc.body.innerHTML;
};

var selectedOption = document.querySelector(`.lang-${defaultLocale}`);
var selectedOptionMobile = document.querySelector(`.lang-mobile-${defaultLocale}`);

selectedOption.classList.add("language-option-selected");

selectedOptionMobile.classList.add("language-option-selected-mobile");

var menu = document.querySelector(".burger");

menu.addEventListener("click", function () {
    isMobileMenuShow = !isMobileMenuShow;

    var mobileLocalization = document.querySelector(".language-options-mobile");
    if (mobileLocalization.classList.contains("language-options-mobile-show")){
        mobileLocalization.classList.remove("language-options-mobile-show");
        mobileLocalization.classList.add("language-options-mobile-hidden");
    }
    else{
        mobileLocalization.classList.remove("language-options-mobile-hidden");
        mobileLocalization.classList.add("language-options-mobile-show");
    }
})
